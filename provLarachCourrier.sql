CREATE DATABASE IF NOT EXISTS provlaracheCollect;

USE provlaracheCollect;

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";
  

-- Table `districts`
CREATE TABLE
  IF NOT EXISTS `districts` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `AALs`
CREATE TABLE
  IF NOT EXISTS `AALs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `name` varchar(50) NOT NULL,
    `district_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `roles`
CREATE TABLE
  IF NOT EXISTS `roles` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(50) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `users`
CREATE TABLE
  IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `aal_id` int,
    `role_id` int,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    FOREIGN KEY (`aal_id`) REFERENCES `AALs` (`id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `agents`

CREATE TABLE
  IF NOT EXISTS `agents` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `firstname` varchar(50) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `phone` varchar(50) NOT NULL,
    `aal_id` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aal_id`) REFERENCES `AALs` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `Datas`
CREATE TABLE
  IF NOT EXISTS `datas` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `list_douar` TEXT NOT NULL,
    `nbr_menage` int NOT NULL,
    `nbr_famille` int NOT NULL,
    `agent_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;


INSERT INTO `districts` (`name`) VALUES ('Larache'), ('Ksar El Kebir'), ('laouamra'), ('tazroute');

INSERT INTO `AALs` (`name`, `district_id`) VALUES ('AAL1', 1), ('AAL2', 1), ('AAL3', 2), ('AAL4', 2), ('AAL5', 3), ('AAL6', 3), ('AAL7', 4), ('AAL8', 4);

INSERT INTO `roles` (`nom`) VALUES ('agent'), ('sg_gouv');

INSERT INTO `users` (`username`, `password`, `aal_id`, `role_id`) 
VALUES ('agent', '$2a$12$Ti6lncbmo99HPFNgQSnh8O2xu2F9TPJAV1HOk05ImPAMNW2FKDiXK', 1, 1), 
        ('sg_gouv', '$2a$12$ev2wT1LbkSy3CLbId3.r9eYZ4O.lzybEBLEz/xcTBGvxZOEL06Uvy', 1, 2);

INSERT INTO `agents` (`firstname`, `lastname`, `phone`, `aal_id`)
VALUES ('agent1', 'agent1', '0612345678', 1),
        ('agent2', 'agent2', '0612345678', 2),
        ('agent3', 'agent3', '0612345678', 3),
        ('agent4', 'agent4', '0612345678', 4),
        ('agent5', 'agent5', '0612345678', 4),
        ('agent6', 'agent6', '0612345678', 3),
        ('agent7', 'agent7', '0612345678', 2),
        ('agent8', 'agent8', '0612345678', 1);
