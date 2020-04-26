CREATE TABLE `Services`
(
    `id`            INT NOT NULL auto_increment,
    `astrologer_id` INT NOT NULL,
    `product_id`    INT NOT NULL,
    `price`         FLOAT NOT NULL,
    PRIMARY KEY (`id`)
    );

CREATE TABLE `Astrologers`
(
    `id`        INT NOT NULL auto_increment,
    `name`      VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    `surname`   VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    `photo`     VARCHAR(255),
    `biography` TEXT,
    `email`     VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
    );

CREATE TABLE `Orders`
(
    `id`           INT NOT NULL auto_increment,
    `service_id`   INT NOT NULL,
    `client_email` VARCHAR(255) NOT NULL,
    `client_name`  VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
    );

CREATE TABLE `Products`
(
    `id`          INT NOT NULL auto_increment,
    `name`        VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    PRIMARY KEY (`id`)
    );

ALTER TABLE `Services`
    ADD CONSTRAINT `services_fk0` FOREIGN KEY (`astrologer_id`) REFERENCES
    `Astrologers`(`id`);

ALTER TABLE `Services`
    ADD CONSTRAINT `services_fk1` FOREIGN KEY (`product_id`) REFERENCES `Products`
    (`id`);

ALTER TABLE `Orders`
    ADD CONSTRAINT `orders_fk0` FOREIGN KEY (`service_id`) REFERENCES `Services`(
    `id`);
