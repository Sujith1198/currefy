<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalyticsModel extends Model
{
    protected $table = 'analytics_visitors';
    protected $allowedFields = ['visitor_key', 'ip_address', 'country_code', 'user_agent', 'first_seen', 'last_seen', 'page_count'];

    public function record(array $payload): void
    {
        $db = $this->db;
        $now = date('Y-m-d H:i:s');
        $visitorKey = $payload['visitor_key'];
        $visitor = $db->table('analytics_visitors')->where('visitor_key', $visitorKey)->get()->getRowArray();

        if ($visitor) {
            $db->table('analytics_visitors')->where('visitor_key', $visitorKey)->update([
                'ip_address' => $payload['ip_address'],
                'country_code' => $payload['country_code'],
                'user_agent' => $payload['user_agent'],
                'last_seen' => $now,
                'page_count' => (int) $visitor['page_count'] + ($payload['action'] === 'start' ? 1 : 0),
            ]);
        } else {
            $db->table('analytics_visitors')->insert([
                'visitor_key' => $visitorKey,
                'ip_address' => $payload['ip_address'],
                'country_code' => $payload['country_code'],
                'user_agent' => $payload['user_agent'],
                'first_seen' => $now,
                'last_seen' => $now,
                'page_count' => $payload['action'] === 'start' ? 1 : 0,
            ]);
        }

        if ($payload['visit_token'] === '') {
            return;
        }

        $visitTable = $db->table('analytics_page_visits');
        $visit = $visitTable->where('visit_token', $payload['visit_token'])->get()->getRowArray();
        $visitData = [
            'visitor_key' => $visitorKey,
            'page_path' => $payload['page_path'],
            'page_title' => $payload['page_title'],
            'last_seen' => $now,
            'duration_seconds' => max(0, min(86400, (int) $payload['duration_seconds'])),
        ];

        if ($visit) {
            $visitTable->where('visit_token', $payload['visit_token'])->update($visitData);
        } else {
            $visitTable->insert($visitData + [
                'visit_token' => $payload['visit_token'],
                'started_at' => $now,
            ]);
        }
    }

    public function dashboard(): array
    {
        $db = $this->db;
        return [
            'visitors' => $db->table('analytics_visitors')->orderBy('last_seen', 'DESC')->limit(500)->get()->getResultArray(),
            'pages' => $db->table('analytics_page_visits')
                ->select('page_path, page_title, COUNT(*) AS visits, SUM(duration_seconds) AS total_seconds, AVG(duration_seconds) AS average_seconds, MAX(last_seen) AS last_seen')
                ->groupBy(['page_path', 'page_title'])
                ->orderBy('visits', 'DESC')->limit(500)->get()->getResultArray(),
            'summary' => [
                'visitors' => (int) $db->table('analytics_visitors')->countAllResults(),
                'pageVisits' => (int) $db->table('analytics_page_visits')->countAllResults(),
                'countries' => (int) $db->table('analytics_visitors')->select('country_code')->distinct()->countAllResults(),
                'seconds' => (int) ($db->table('analytics_page_visits')->selectSum('duration_seconds')->get()->getRow()->duration_seconds ?? 0),
            ],
        ];
    }
}
