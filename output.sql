-- MySQL Script generated by MySQL Workbench
-- Sun Sep  1 18:24:02 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema a111
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema a111
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `a111` DEFAULT CHARACTER SET utf8mb4 ;
USE `a111` ;

-- -----------------------------------------------------
-- Table `a111`.`person`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`person` ;

CREATE TABLE IF NOT EXISTS `a111`.`person` (
  `name` VARCHAR(25) NOT NULL,
  `cnic` VARCHAR(13) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cnic` (`cnic` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`address` ;

CREATE TABLE IF NOT EXISTS `a111`.`address` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `address_city` VARCHAR(20) NOT NULL DEFAULT 'lahore',
  `address_town` VARCHAR(30) NOT NULL,
  `address_street_no` INT(11) NULL DEFAULT NULL,
  `address_house_no` INT(11) NULL DEFAULT NULL,
  `person_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_address_person1_idx` (`person_id` ASC),
  CONSTRAINT `fk_address_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `a111`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`number`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`number` ;

CREATE TABLE IF NOT EXISTS `a111`.`number` (
  `number` VARCHAR(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `is_number_active` TINYINT NOT NULL DEFAULT 1,
  `person_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_number_person1_idx` (`person_id` ASC),
  CONSTRAINT `fk_number_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `a111`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`order` ;

CREATE TABLE IF NOT EXISTS `a111`.`order` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `total_amount` INT(11) NULL DEFAULT 0,
  `order_comments` TEXT NULL DEFAULT NULL,
  `total_person` INT NOT NULL,
  `is_active` INT NOT NULL DEFAULT 1,
  `destination_date` DATE NULL,
  `booking_date` DATE NULL,
  `destination_time` TIME(6) NULL,
  `address_id` INT(11) NOT NULL,
  `extre_charges` INT NULL,
  `person_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_order_address1_idx` (`address_id` ASC),
  INDEX `fk_order_person1_idx` (`person_id` ASC),
  CONSTRAINT `fk_order_address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `a111`.`address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `a111`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`dish_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`dish_type` ;

CREATE TABLE IF NOT EXISTS `a111`.`dish_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`dish`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`dish` ;

CREATE TABLE IF NOT EXISTS `a111`.`dish` (
  `name` VARCHAR(30) NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(50) NULL,
  `dish_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dish_dish_type1_idx` (`dish_type_id` ASC),
  CONSTRAINT `fk_dish_dish_type1`
    FOREIGN KEY (`dish_type_id`)
    REFERENCES `a111`.`dish_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`attribute`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`attribute` ;

CREATE TABLE IF NOT EXISTS `a111`.`attribute` (
  `name` INT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(45) NULL,
  `dish_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_attribute_dish1_idx` (`dish_id` ASC),
  CONSTRAINT `fk_attribute_dish1`
    FOREIGN KEY (`dish_id`)
    REFERENCES `a111`.`dish` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`dish_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`dish_detail` ;

CREATE TABLE IF NOT EXISTS `a111`.`dish_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `describe` TEXT(300) NULL,
  `price` INT NULL,
  `expire_date` DATETIME NULL,
  `quantity` VARCHAR(45) NULL,
  `dish_id` INT NOT NULL,
  `order_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dish_detail_dish1_idx` (`dish_id` ASC),
  INDEX `fk_dish_detail_order1_idx` (`order_id` ASC),
  CONSTRAINT `fk_dish_detail_dish1`
    FOREIGN KEY (`dish_id`)
    REFERENCES `a111`.`dish` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dish_detail_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `a111`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`attribute_name`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`attribute_name` ;

CREATE TABLE IF NOT EXISTS `a111`.`attribute_name` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `quantity` INT NULL,
  `attribute_id` INT NOT NULL,
  `dish_detail_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_attribute_name_attribute1_idx` (`attribute_id` ASC),
  INDEX `fk_attribute_name_dish_detail1_idx` (`dish_detail_id` ASC),
  CONSTRAINT `fk_attribute_name_attribute1`
    FOREIGN KEY (`attribute_id`)
    REFERENCES `a111`.`attribute` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attribute_name_dish_detail1`
    FOREIGN KEY (`dish_detail_id`)
    REFERENCES `a111`.`dish_detail` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`order_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`order_status` ;

CREATE TABLE IF NOT EXISTS `a111`.`order_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`user` ;

CREATE TABLE IF NOT EXISTS `a111`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(10) NULL,
  `person_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_person1_idx` (`person_id` ASC),
  CONSTRAINT `fk_user_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `a111`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`change_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`change_status` ;

CREATE TABLE IF NOT EXISTS `a111`.`change_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `order_status_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `dateTime` DATETIME(6) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_change_status_order1_idx` (`order_id` ASC),
  INDEX `fk_change_status_order_status1_idx` (`order_status_id` ASC),
  INDEX `fk_change_status_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_change_status_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `a111`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_change_status_order_status1`
    FOREIGN KEY (`order_status_id`)
    REFERENCES `a111`.`order_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_change_status_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `a111`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`payment` ;

CREATE TABLE IF NOT EXISTS `a111`.`payment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` INT NULL,
  `nameCustomer` VARCHAR(45) NULL,
  `receive` DATETIME NULL,
  `personality` TEXT(300) NULL,
  `rating` INT NULL,
  `IsReturn` BLOB NULL,
  `order_id` INT(11) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_payment_order1_idx` (`order_id` ASC),
  INDEX `fk_payment_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_payment_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `a111`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `a111`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `a111`.`transfer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `a111`.`transfer` ;

CREATE TABLE IF NOT EXISTS `a111`.`transfer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Isconfirm` DATETIME NULL,
  `senderTimeDate` DATETIME NULL,
  `payment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_transfer_payment1_idx` (`payment_id` ASC),
  INDEX `fk_transfer_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_transfer_payment1`
    FOREIGN KEY (`payment_id`)
    REFERENCES `a111`.`payment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transfer_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `a111`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
