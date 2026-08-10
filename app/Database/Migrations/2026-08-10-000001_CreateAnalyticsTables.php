<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalyticsTables extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'visitor_key' => ['type' => 'VARCHAR', 'constraint' => 64],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45],
            'country_code' => ['type' => 'VARCHAR', 'constraint' => 8, 'null' => true],
            'user_agent' => ['type' => 'TEXT', 'null' => true],
            'first_seen' => ['type' => 'DATETIME'],
            'last_seen' => ['type' => 'DATETIME'],
            'page_count' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('visitor_key');
        $this->forge->addKey('last_seen');
        $this->forge->createTable('analytics_visitors', true);

        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'visit_token' => ['type' => 'VARCHAR', 'constraint' => 64],
            'visitor_key' => ['type' => 'VARCHAR', 'constraint' => 64],
            'page_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'page_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'started_at' => ['type' => 'DATETIME'],
            'last_seen' => ['type' => 'DATETIME'],
            'duration_seconds' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('visit_token');
        $this->forge->addKey('visitor_key');
        $this->forge->addKey('page_path');
        $this->forge->addKey('last_seen');
        $this->forge->createTable('analytics_page_visits', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('analytics_page_visits', true);
        $this->forge->dropTable('analytics_visitors', true);
    }
}
