create database if not exists phpchat;

drop table if exists `phpchat`.`user`;
drop table if exists `phpchat`.`lines`;

CREATE TABLE `phpchat`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nick` VARCHAR(45) NOT NULL,
  `urlimg` TEXT NULL,
  `ts` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `nick_UNIQUE` (`nick` ASC));
  
  CREATE TABLE `phpchat`.`lines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nick` VARCHAR(45) NOT NULL,
  `urlimg` TEXT NULL,
  `msg` VARCHAR(160) NOT NULL,
  `ts` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
  
  insert into `phpchat`.`lines` (nick, urlimg, msg) values ("chi", "", "hola");