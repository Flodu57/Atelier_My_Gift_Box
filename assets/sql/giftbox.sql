SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `password` text NOT NULL,
  `account_level` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `categories`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `boxes`;

CREATE TABLE IF NOT EXISTS `boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `titre` text NOT NULL,
  `date_ouverture` date NOT NULL,
  `url` text NOT NULL,
  `valide` BOOLEAN NOT NULL DEFAULT 0,
  `payer` BOOLEAN NOT NULL DEFAULT 0,
  `prix_total` int(11) NOT NULL,
  `mode_paiement` text,
  `message` text NOT NULL,
  `message_retour` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `prestations`;

CREATE TABLE IF NOT EXISTS `prestations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `titre` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `prix` int(11) NOT NULL,
  `suspendue` BOOLEAN NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `box_prestation`;

CREATE TABLE IF NOT EXISTS `box_prestation` (
  `box_id` int(11) NOT NULL,
  `prestation_id` int(11) not null,
  PRIMARY KEY (`box_id`, `prestation_id`)
)ENGINE=InnoDB;