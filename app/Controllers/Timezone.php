<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/** Timezone Controller */
class Timezone extends Controller
{
    public function index(): string
    {
        $timezones = $this->getTimezones();
        $data = [
            'title'       => 'Time Zone Converter | Currefy',
            'description' => 'Free online time zone converter. Convert times between any world time zones.',
            'timezones'   => $timezones,
            'lastUpdated' => null,
        ];

        return view('layouts/main', ['content' => view('timezone', $data), ...$data]);
    }

    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        $allTz  = $this->getTimezones();
        $tzList = implode(',', array_keys($allTz));

        $rules = [
            'datetime' => 'required|regex_match[/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/]',
            'from'     => ['required', 'in_list[' . $tzList . ']'],
            'to'       => ['required', 'in_list[' . $tzList . ']'],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input.'])->setStatusCode(400);
        }

        $datetime = $this->request->getPost('datetime');
        $from     = $this->request->getPost('from');
        $to       = $this->request->getPost('to');

        try {
            $fromDt = new \DateTime($datetime, new \DateTimeZone($from));
            $toDt   = new \DateTime($datetime, new \DateTimeZone($from));
            $toDt->setTimezone(new \DateTimeZone($to));

            $fromOffset = $fromDt->getOffset();
            $toOffset   = $toDt->getOffset();

            $diffHours  = ($toOffset - $fromOffset) / 3600;
            $diffLabel  = $diffHours == (int) $diffHours ? number_format($diffHours, 0) : number_format($diffHours, 1);
            $difference = ($diffHours > 0 ? '+' : '') . $diffLabel . 'h';

            return $this->response->setJSON([
                'success'     => true,
                'result'      => $toDt->format('Y-m-d H:i'),
                'result_full' => $toDt->format('D, d M Y H:i:s T'),
                'offset'      => $toDt->format('P'),
                'difference'  => $difference,
                'from'        => [
                    'formatted' => $fromDt->format('D, d M Y H:i'),
                    'abbr'      => $fromDt->format('T'),
                    'label'     => $allTz[$from],
                ],
                'to'          => [
                    'formatted' => $toDt->format('D, d M Y H:i'),
                    'abbr'      => $toDt->format('T'),
                    'label'     => $allTz[$to],
                ],
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Timezone convert error: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'error' => 'Conversion failed.'])->setStatusCode(400);
        }
    }

    private function getTimezones(): array
    {
        return [
            'UTC'                    => 'UTC (Universal Coordinated Time)',
            'America/New_York'       => 'New York (EST/EDT)',
            'America/Chicago'        => 'Chicago (CST/CDT)',
            'America/Denver'         => 'Denver (MST/MDT)',
            'America/Los_Angeles'    => 'Los Angeles (PST/PDT)',
            'America/Toronto'        => 'Toronto (EST/EDT)',
            'America/Vancouver'      => 'Vancouver (PST/PDT)',
            'America/Sao_Paulo'      => 'São Paulo (BRT)',
            'America/Buenos_Aires'   => 'Buenos Aires (ART)',
            'America/Mexico_City'    => 'Mexico City (CST/CDT)',
            'Europe/London'          => 'London (GMT/BST)',
            'Europe/Paris'           => 'Paris (CET/CEST)',
            'Europe/Berlin'          => 'Berlin (CET/CEST)',
            'Europe/Madrid'          => 'Madrid (CET/CEST)',
            'Europe/Rome'            => 'Rome (CET/CEST)',
            'Europe/Amsterdam'       => 'Amsterdam (CET/CEST)',
            'Europe/Moscow'          => 'Moscow (MSK)',
            'Europe/Istanbul'        => 'Istanbul (TRT)',
            'Africa/Cairo'           => 'Cairo (EET)',
            'Africa/Nairobi'         => 'Nairobi (EAT)',
            'Africa/Lagos'           => 'Lagos (WAT)',
            'Africa/Johannesburg'    => 'Johannesburg (SAST)',
            'Asia/Kolkata'           => 'India (IST)',
            'Asia/Dubai'             => 'Dubai (GST)',
            'Asia/Riyadh'            => 'Riyadh (AST)',
            'Asia/Karachi'           => 'Karachi (PKT)',
            'Asia/Dhaka'             => 'Dhaka (BST)',
            'Asia/Bangkok'           => 'Bangkok (ICT)',
            'Asia/Singapore'         => 'Singapore (SGT)',
            'Asia/Kuala_Lumpur'      => 'Kuala Lumpur (MYT)',
            'Asia/Hong_Kong'         => 'Hong Kong (HKT)',
            'Asia/Shanghai'          => 'Shanghai (CST)',
            'Asia/Seoul'             => 'Seoul (KST)',
            'Asia/Tokyo'             => 'Tokyo (JST)',
            'Asia/Jakarta'           => 'Jakarta (WIB)',
            'Australia/Sydney'       => 'Sydney (AEST/AEDT)',
            'Australia/Melbourne'    => 'Melbourne (AEST/AEDT)',
            'Australia/Perth'        => 'Perth (AWST)',
            'Pacific/Auckland'       => 'Auckland (NZST/NZDT)',
            'Pacific/Honolulu'       => 'Honolulu (HST)',
        ];
    }
}
