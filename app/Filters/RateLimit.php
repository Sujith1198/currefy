<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * RateLimit Filter
 *
 * Simple IP-based rate limiter backed by the file cache.
 * Protects converter / API AJAX endpoints from abuse.
 *
 * Security: Limits each IP to $maxRequests per $window seconds.
 * The client IP comes from the server (REMOTE_ADDR) - no client-supplied
 * headers are trusted, so the limit cannot be bypassed by spoofing.
 */
class RateLimit implements FilterInterface
{
    /** Max requests allowed within the window. */
    private int $maxRequests = 60;

    /** Window length in seconds. */
    private int $window = 60;

    public function before(RequestInterface $request, $arguments = null)
    {
        $ip  = $request->getIPAddress();
        $key = 'ratelimit_' . md5($ip);

        try {
            $cache = cache();
            $count = (int) ($cache->get($key) ?? 0);

            if ($count >= $this->maxRequests) {
                return service('response')
                    ->setStatusCode(429)
                    ->setHeader('Retry-After', (string) $this->window)
                    ->setJSON([
                        'success' => false,
                        'error'   => 'Too many requests. Please try again shortly.',
                    ]);
            }

            $cache->save($key, $count + 1, $this->window);
        } catch (\Throwable $e) {
            // Cache unavailable (e.g. unwritable writable/cache on shared hosting):
            // fail open rather than returning 500 for every request.
            log_message('warning', 'RateLimit cache error: ' . $e->getMessage());
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}
