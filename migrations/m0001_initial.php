<?php

use Core\Database\Migration;

/**
 * Initial Migration. (Users Table)
 */
class m0001_initial extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `users` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `uid` varchar(300) NOT NULL,
        `username` varchar(300) DEFAULT NULL,
        `surname` varchar(300) NOT NULL,
        `name` varchar(300) NOT NULL,
        `email` varchar(300) NOT NULL,
        `password` varchar(300) NOT NULL,
        `avatar` text DEFAULT NULL,
        `phone` varchar(30) DEFAULT NULL,
        `acl` varchar(30) NOT NULL DEFAULT 'user',
        `token` varchar(300) DEFAULT NULL,
        `bio` varchar(800) DEFAULT NULL,
        `social` varchar(800) DEFAULT NULL,
        `blocked` tinyint(4) NOT NULL DEFAULT 0,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        KEY `username` (`username`),
        KEY `uid` (`uid`)
        ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE users;";
        $this->connection->exec($SQL);
    }
}