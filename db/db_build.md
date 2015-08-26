-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'authors_t'
--
-- ---

DROP TABLE IF EXISTS `authors_t`;

CREATE TABLE `authors_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `author_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'books_t'
--
-- ---

DROP TABLE IF EXISTS `books_t`;

CREATE TABLE `books_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'authors_books_t'
--
-- ---

DROP TABLE IF EXISTS `authors_books_t`;

CREATE TABLE `authors_books_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `author_id` INTEGER NULL DEFAULT NULL,
  `book_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'copies_t'
--
-- ---

DROP TABLE IF EXISTS `copies_t`;

CREATE TABLE `copies_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `book_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'patrons_t'
--
-- ---

DROP TABLE IF EXISTS `patrons_t`;

CREATE TABLE `patrons_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `patron_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'checkouts_t'
--
-- ---

DROP TABLE IF EXISTS `checkouts_t`;

CREATE TABLE `checkouts_t` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `due_date` DATE NULL DEFAULT NULL,
  `copy_id` INTEGER NULL DEFAULT NULL,
  `patron_id` INTEGER NULL DEFAULT NULL,
  `checkin_status` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys
-- ---

ALTER TABLE `authors_books_t` ADD FOREIGN KEY (author_id) REFERENCES `authors_t` (`id`);
ALTER TABLE `authors_books_t` ADD FOREIGN KEY (author_id) REFERENCES `authors_t` (`id`);
ALTER TABLE `authors_books_t` ADD FOREIGN KEY (book_id) REFERENCES `books_t` (`id`);
ALTER TABLE `copies_t` ADD FOREIGN KEY (book_id) REFERENCES `books_t` (`id`);
ALTER TABLE `checkouts_t` ADD FOREIGN KEY (copy_id) REFERENCES `copies_t` (`id`);
ALTER TABLE `checkouts_t` ADD FOREIGN KEY (patron_id) REFERENCES `patrons_t` (`id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `authors_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `books_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `authors_books_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `copies_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `patrons_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `checkouts_t` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `authors_t` (`id`,`author_name`) VALUES
-- ('','');
-- INSERT INTO `books_t` (`id`,`title`) VALUES
-- ('','');
-- INSERT INTO `authors_books_t` (`id`,`author_id`,`book_id`) VALUES
-- ('','','');
-- INSERT INTO `copies_t` (`id`,`book_id`) VALUES
-- ('','');
-- INSERT INTO `patrons_t` (`id`,`patron_name`) VALUES
-- ('','');
-- INSERT INTO `checkouts_t` (`id`,`due_date`,`copy_id`,`patron_id`,`checkin_status`) VALUES
-- ('','','','','');
