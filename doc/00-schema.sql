DROP TABLE IF EXISTS `company_relation`;
DROP TABLE IF EXISTS `agreement`;
DROP TABLE IF EXISTS `company`;
DROP TABLE IF EXISTS `relation`;

CREATE TABLE `company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `agreement` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agreement_company_1` (`company_id`),
  CONSTRAINT `agreement_company_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `company_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `agreement_id` int(11) unsigned NOT NULL,
  `company_id` int(11) unsigned NOT NULL,
  `relation_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_relation_agreement` (`agreement_id`),
  KEY `company_relation_company` (`company_id`),
  KEY `company_relation_relation` (`relation_id`),
  CONSTRAINT `company_relation_agreement` FOREIGN KEY (`agreement_id`) REFERENCES `agreement` (`id`),
  CONSTRAINT `company_relation_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `company_relation_relation` FOREIGN KEY (`relation_id`) REFERENCES `relation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

