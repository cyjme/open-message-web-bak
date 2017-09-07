CREATE USER IF NOT EXISTS '{dbUsername}'@'%' IDENTIFIED BY '{dbPassword}';

GRANT ALL ON {dbDatabase}.* TO '{dbUsername}'@'%';

CREATE DATABASE IF NOT EXISTS {dbDatabase};

USE {dbDatabase};

CREATE TABLE IF NOT EXISTS `meta` (
  `metaId` varbinary(16) NOT NULL DEFAULT '',
  `localeKey` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`metaId`),
  KEY `localeKey-key` (`localeKey`,`key`(191)) KEY_BLOCK_SIZE=16
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `trans` (
  `transId` varbinary(16) NOT NULL DEFAULT '',
  `localeKey` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transId`),
  KEY `localeKey-str` (`localeKey`,`key`(191)) KEY_BLOCK_SIZE=16
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `trans_group` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `group` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
