USE `dynamic-forms`;

DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `form_name` VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `form_name` (`form_name`),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `form_fields`;
CREATE TABLE `form_fields` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `form_id` INT(10) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `type` VARCHAR(25) NOT NULL,
    `required` BIT(1) NOT NULL,
    `placeholder` VARCHAR(255) NULL,
    `sort_order` INT(10) NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `field_options`;
CREATE TABLE `field_options` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `field_id` INT(10) NOT NULL,
    `option_text` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `form_responses`;
CREATE TABLE `form_responses` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `form_id` INT(10) NOT NULL,
    `user_id` INT(10) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `form_response_values`;
CREATE TABLE `form_response_values` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `response_id` INT(10) NOT NULL,
    `field_id` INT(10) NOT NULL,
    `value` TEXT NULL,
    PRIMARY KEY (`id`)
);

