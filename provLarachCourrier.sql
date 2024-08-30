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


INSERT INTO `districts` (`name`)
VALUES 
('(District) MOULAY ALI BOUGHALEB'),
('(District) District Lamrina'),
('(District) LALLA MENANA'),
('(District) EL MAGHRIB EL JADID'),
('(District) SIDI EL ARBI'),
('(Cercle) LOUKOUS'),
('(Cercle) MOULAY ABDESLAM BEN MACHICH'),
('(Cercle) OUED AL MAKHAZINE');

INSERT INTO `AALs` (`name`, `district_id`)
VALUES
-- MOULAY ALI BOUGHALEB (district_id = 1)
('(Annexe administrative) PREMIERE', 1),
('(Annexe administrative) DEUXIEME', 1),
('(Annexe administrative) SIXIEME', 1),

-- District Lamrina (district_id = 2)
('(Annexe administrative) TROISIEME', 2),
('(Annexe administrative) QUATRIEME', 2),
('(Annexe administrative) CINQUIEME', 2),

-- LALLA MENANA (district_id = 3)
('(Annexe administrative) PREMIERE', 3),
('(Annexe administrative) DEUXIEME', 3),
('(Annexe administrative) TROISIEME', 3),

-- EL MAGHRIB EL JADID (district_id = 4)
('(Annexe administrative) QUATRIEME', 4),
('(Annexe administrative) CINQUIEME', 4),

-- SIDI EL ARBI (district_id = 5)
('(Annexe administrative) SIXIEME', 5),
('(Annexe administrative) SEPTIEME', 5),

-- LOUKOUS (district_id = 6)
('(Caidat) LAAOUAMRA', 6),
('(Caidat) QOLLA', 6),
('(Caidat) SIDI SLAMA', 6),
('(Caidat) TATOFT', 6),

-- MOULAY ABDESLAM BEN MACHICH (district_id = 7)
('(Caidat) AYACHA', 7),
('(Caidat) BNI AROUSS', 7),
('(Caidat) BNI GERFET', 7),
('(Caidat) TAZROUTE', 7),

-- OUED AL MAKHAZINE (district_id = 8)
('(Caidat) OULAD OUCHIH SOUAKEN', 8),
('(Caidat) RISSANA', 8),
('(Caidat) SAHEL', 8),
('(Caidat) SOUK TOLBA', 8);

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
