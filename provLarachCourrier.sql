CREATE DATABASE IF NOT EXISTS provlaracheCollect;

USE provlaracheCollect;

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

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
    `role_id` int NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `districts`

CREATE TABLE
  IF NOT EXISTS `district` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `nom` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `AALs`

CREATE TABLE
  IF NOT EXISTS `AAL` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `nom` varchar(50) NOT NULL,
    `district_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `Agents`

CREATE TABLE
  IF NOT EXISTS `Agent` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `nom` varchar(50) NOT NULL,
    `prenom` varchar(50) NOT NULL,
    `telephone` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `AAL_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`AAL_id`) REFERENCES `AAL` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `Datas`

CREATE TABLE
  IF NOT EXISTS `Data` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `list_douar` int NOT NULL,
    `nbr_menage` int NOT NULL,
    `nbr_famille` int NOT NULL,
    `agent_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`agent_id`) REFERENCES `Agent` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- // hash password after insert using trigger
DELIMITER $$
CREATE TRIGGER `hash_password` BEFORE INSERT ON `users` FOR EACH ROW
BEGIN
  -- don't use md5  or sha1 for password hashing use bcrypt or argon2
  SET NEW.password = SHA2(NEW.password, 256);
END$$
DELIMITER ;

INSERT INTO `roles` (`nom`) VALUES ('agent'), ('sg_gouv');

INSERT INTO `users` (`username`, `password`, `role_id`) VALUES ('agent', 'agent', 1), ('sg_gouv', 'sg_gouv', 2);

INSERT INTO `district` (`nom`) VALUES ('Larache'), ('Ksar El Kebir'), ('laouamra'), ('Sidi Kacem');

INSERT INTO `AAL` (`nom`, `district_id`) VALUES ('AAL1', 1), ('AAL2', 1), ('AAL3', 2), ('AAL4', 2), ('AAL5', 3), ('AAL6', 3), ('AAL7', 4), ('AAL8', 4);
