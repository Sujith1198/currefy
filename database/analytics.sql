-- Currefy admin analytics database setup
-- Run this in phpMyAdmin or MySQL after selecting your Currefy database.

CREATE TABLE IF NOT EXISTS `analytics_visitors` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `visitor_key` VARCHAR(64) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `country_code` VARCHAR(8) NULL,
    `user_agent` TEXT NULL,
    `first_seen` DATETIME NOT NULL,
    `last_seen` DATETIME NOT NULL,
    `page_count` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_analytics_visitors_visitor_key` (`visitor_key`),
    KEY `idx_analytics_visitors_last_seen` (`last_seen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `analytics_page_visits` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `visit_token` VARCHAR(64) NOT NULL,
    `visitor_key` VARCHAR(64) NOT NULL,
    `page_path` VARCHAR(255) NOT NULL,
    `page_title` VARCHAR(255) NULL,
    `started_at` DATETIME NOT NULL,
    `last_seen` DATETIME NOT NULL,
    `duration_seconds` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_analytics_page_visits_visit_token` (`visit_token`),
    KEY `idx_analytics_page_visits_visitor_key` (`visitor_key`),
    KEY `idx_analytics_page_visits_page_path` (`page_path`),
    KEY `idx_analytics_page_visits_last_seen` (`last_seen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
