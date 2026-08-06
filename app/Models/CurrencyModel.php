<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * CurrencyModel
 *
 * Handles fetching and caching of exchange rates from Frankfurter.app (free, no API key).
 * Rates are cached for 24 hours in writable/cache/rates.json.
 *
 * Security: API responses are validated before caching. No user input is used in API URLs.
 */
class CurrencyModel extends Model
{
    /**
     * API base URL (Frankfurter - ECB data, completely free, no key needed).
     * Frankfurter moved to api.frankfurter.dev (v1). The legacy .app domain
     * 301-redirects here, so the direct URL avoids the redirect hop.
     * TODO(security): If upgrading to a paid API, store the API key in .env, never hardcode.
     */
    private string $apiUrl = 'https://api.frankfurter.dev/v1';

    /**
     * Local cache file path
     */
    private string $cacheFile;

    /**
     * Cache duration in seconds (24 hours)
     */
    private int $cacheDuration = 86400;

    public function __construct()
    {
        parent::__construct();
        $this->cacheFile = WRITEPATH . 'cache/rates.json';

        // Ensure cache directory exists
        if (!is_dir(WRITEPATH . 'cache')) {
            mkdir(WRITEPATH . 'cache', 0755, true);
        }
    }

    /**
     * Get exchange rates. Returns from cache if fresh, otherwise fetches from API.
     *
     * @return array ['rates' => [...], 'base' => 'EUR', 'date' => '...', 'cached_at' => ...]
     */
    public function getRates(): array
    {
        // Try to serve from cache
        if ($this->isCacheValid()) {
            $cached = json_decode(file_get_contents($this->cacheFile), true);
            if (is_array($cached) && isset($cached['rates'])) {
                return $cached;
            }
        }

        // Fetch fresh rates
        return $this->fetchAndCache();
    }

    /**
     * Check if the cache file exists and is less than 24 hours old.
     */
    private function isCacheValid(): bool
    {
        if (!file_exists($this->cacheFile)) {
            return false;
        }

        $mtime = filemtime($this->cacheFile);
        return (time() - $mtime) < $this->cacheDuration;
    }

    /**
     * Fetch latest rates from Frankfurter API and cache them.
     * Security: No user input is used in the URL. API response is validated.
     */
    private function fetchAndCache(): array
    {
        $url = $this->apiUrl . '/latest?from=EUR';

        // Fallback HTTP client if the cURL extension is missing on the server.
        if (!function_exists('curl_init')) {
            $response = @file_get_contents($url, false, stream_context_create([
                'http' => ['timeout' => 10, 'header' => "Accept: application/json\r\nUser-Agent: Currefy/1.0 (https://currefy.com)\r\n"],
                'ssl'  => ['verify_peer' => true, 'verify_peer_name' => true],
            ]));
            if ($response !== false) {
                $data = json_decode($response, true);
                if (is_array($data) && isset($data['rates']) && is_array($data['rates'])) {
                    return $this->storeRates($data);
                }
            }
            log_message('error', 'CurrencyModel: cURL missing and file_get_contents fallback failed.');
            return $this->fallbackRates();
        }

        // Use cURL for the HTTP request
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 3,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4, // Avoid slow/broken IPv6 routes on Windows
            CURLOPT_USERAGENT      => 'Currefy/1.0 (https://currefy.com)',
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        // Validate response
        if ($error || $httpCode !== 200 || empty($response)) {
            log_message('error', "CurrencyModel: Failed to fetch rates. HTTP:{$httpCode} Error:{$error}");
            return $this->fallbackRates();
        }

        $data = json_decode($response, true);

        // Validate JSON structure
        if (!is_array($data) || !isset($data['rates']) || !is_array($data['rates'])) {
            log_message('error', 'CurrencyModel: Invalid API response structure.');
            return $this->fallbackRates(true);
        }

        return $this->storeRates($data);
    }

    /**
     * Validate, normalize and persist fresh rates, then return them.
     */
    private function storeRates(array $data): array
    {
        // Add EUR itself (base currency) to rates for completeness
        $data['rates']['EUR'] = 1.0;

        // Add metadata
        $data['cached_at'] = time();

        // Sort by currency code
        ksort($data['rates']);

        // Cache to file (writable/cache/rates.json)
        if (!is_writable(dirname($this->cacheFile))) {
            log_message('warning', 'CurrencyModel: cache directory not writable, skipping cache write.');
        } else {
            @file_put_contents($this->cacheFile, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
        }

        return $data;
    }

    /**
     * Stale cache if available, otherwise a static approximation.
     */
    private function fallbackRates(bool $empty = false): array
    {
        // Return stale cache if available
        if (file_exists($this->cacheFile)) {
            $stale = json_decode(@file_get_contents($this->cacheFile), true);
            if (is_array($stale) && isset($stale['rates'])) {
                return $stale;
            }
        }

        if ($empty) {
            return ['rates' => [], 'base' => 'EUR', 'date' => date('Y-m-d'), 'cached_at' => time(), 'error' => true];
        }

        // Static fallback if API is blocked and no cache exists
        return [
            'rates' => [
                'EUR' => 1.0, 'USD' => 1.08, 'GBP' => 0.85, 'INR' => 90.50,
                'JPY' => 160.20, 'AUD' => 1.65, 'CAD' => 1.45, 'CHF' => 0.95,
                'CNY' => 7.80, 'SGD' => 1.45, 'NZD' => 1.78, 'ZAR' => 20.50,
                'BRL' => 5.40, 'MXN' => 18.20, 'HKD' => 8.45, 'SEK' => 11.20
            ],
            'base' => 'EUR',
            'date' => date('Y-m-d'),
            'cached_at' => time(),
            'error' => true
        ];
    }

    /**
     * Convert an amount from one currency to another.
     *
     * @param float  $amount
     * @param string $from   3-letter currency code (uppercase)
     * @param string $to     3-letter currency code (uppercase)
     * @param array  $rates  Rate data from getRates()
     * @return float|null
     */
    public function convert(float $amount, string $from, string $to, array $rates): ?float
    {
        if (empty($rates['rates'])) {
            return null;
        }

        $rateMap = $rates['rates'];

        // All rates are relative to EUR (base)
        if (!isset($rateMap[$from]) || !isset($rateMap[$to])) {
            return null;
        }

        // Convert from -> EUR -> to
        $inEur  = $amount / $rateMap[$from];
        $result = $inEur * $rateMap[$to];

        return round($result, 6);
    }

    /**
     * Get list of available currencies with their names.
     */
    public function getCurrencyNames(): array
    {
        return [
            'AUD' => 'Australian Dollar',
            'BGN' => 'Bulgarian Lev',
            'BRL' => 'Brazilian Real',
            'CAD' => 'Canadian Dollar',
            'CHF' => 'Swiss Franc',
            'CNY' => 'Chinese Yuan',
            'CZK' => 'Czech Koruna',
            'DKK' => 'Danish Krone',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungarian Forint',
            'IDR' => 'Indonesian Rupiah',
            'ILS' => 'Israeli New Shekel',
            'INR' => 'Indian Rupee',
            'ISK' => 'Icelandic Króna',
            'JPY' => 'Japanese Yen',
            'KRW' => 'South Korean Won',
            'MXN' => 'Mexican Peso',
            'MYR' => 'Malaysian Ringgit',
            'NOK' => 'Norwegian Krone',
            'NZD' => 'New Zealand Dollar',
            'PHP' => 'Philippine Peso',
            'PLN' => 'Polish Złoty',
            'RON' => 'Romanian Leu',
            'SEK' => 'Swedish Krona',
            'SGD' => 'Singapore Dollar',
            'THB' => 'Thai Baht',
            'TRY' => 'Turkish Lira',
            'USD' => 'United States Dollar',
            'ZAR' => 'South African Rand',
        ];
    }

    /**
     * Get the last updated timestamp from cache.
     */
    public function getLastUpdated(): ?string
    {
        if (!file_exists($this->cacheFile)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->cacheFile), true);
        if (isset($data['cached_at'])) {
            return date('d M Y, H:i', $data['cached_at']) . ' UTC';
        }
        return null;
    }
}
