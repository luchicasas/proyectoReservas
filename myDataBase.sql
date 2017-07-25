-- MySQL Script generated by MySQL Workbench
-- 10/22/16 13:23:53
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema reservasDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema reservasDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `reservasDB` DEFAULT CHARACTER SET utf8 ;
USE `reservasDB` ;

-- -----------------------------------------------------
-- Table `reservasDB`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`rol` (
  `idrol` INT NOT NULL AUTO_INCREMENT,
  `tipoRol` VARCHAR(45) NULL,
  PRIMARY KEY (`idrol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`usuarios` (
  `dniUsuario` INT NOT NULL AUTO_INCREMENT,
  `rol_idrol` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `apellido` VARCHAR(45) NULL,
  `mail` VARCHAR(45) NULL,
  `telefono` INT NULL,
  `contraseña` VARCHAR(45) NULL,
  `activo` INT NULL,
  PRIMARY KEY (`dniUsuario`),
  INDEX `fk_usuarios_rol1_idx` (`rol_idrol` ASC),
  CONSTRAINT `fk_usuarios_rol1`
    FOREIGN KEY (`rol_idrol`)
    REFERENCES `reservasDB`.`rol` (`idrol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`estados` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `tipoEstado` VARCHAR(45) NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`salas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`salas` (
  `idSala` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `precio` FLOAT NULL,
  `capacidad` INT NULL,
  `direccion` VARCHAR(45) NULL,
  PRIMARY KEY (`idSala`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`reservas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`reservas` (
  `idReserva` INT NOT NULL AUTO_INCREMENT,
  `estados_idEstado` INT NOT NULL,
  `salas_idSala` INT NOT NULL,
  `usuarios_dniUsuario` INT NOT NULL,
  `fecha` DATE NULL,
  `hora` VARCHAR(45) NULL,
  `duracion` FLOAT NULL,
  `precioSala` FLOAT NULL,
  PRIMARY KEY (`idReserva`),
  INDEX `fk_reservas_estados1_idx` (`estados_idEstado` ASC),
  INDEX `fk_reservas_salas1_idx` (`salas_idSala` ASC),
  INDEX `fk_reservas_usuarios1_idx` (`usuarios_dniUsuario` ASC),
  CONSTRAINT `fk_reservas_estados1`
    FOREIGN KEY (`estados_idEstado`)
    REFERENCES `reservasDB`.`estados` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservas_salas1`
    FOREIGN KEY (`salas_idSala`)
    REFERENCES `reservasDB`.`salas` (`idSala`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservas_usuarios1`
    FOREIGN KEY (`usuarios_dniUsuario`)
    REFERENCES `reservasDB`.`usuarios` (`dniUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`recursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`recursos` (
  `idRecurso` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` FLOAT NULL,
  `salas_idSala` INT NOT NULL,
  PRIMARY KEY (`idRecurso`),
  INDEX `fk_recursos_salas1_idx` (`salas_idSala` ASC),
  CONSTRAINT `fk_recursos_salas1`
    FOREIGN KEY (`salas_idSala`)
    REFERENCES `reservasDB`.`salas` (`idSala`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`servicios` (
  `idServicio` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `precio` FLOAT NULL,
  `descripcion` VARCHAR(45) NULL,
  PRIMARY KEY (`idServicio`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`tarjetas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`tarjetas` (
  `numTarjeta` INT NOT NULL,
  `codSeguridad` INT NULL,
  `usuarios_dniUsuario` INT NOT NULL,
  PRIMARY KEY (`numTarjeta`),
  INDEX `fk_tarjetas_usuarios1_idx` (`usuarios_dniUsuario` ASC),
  CONSTRAINT `fk_tarjetas_usuarios1`
    FOREIGN KEY (`usuarios_dniUsuario`)
    REFERENCES `reservasDB`.`usuarios` (`dniUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`recursos_has_reservas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`recursos_has_reservas` (
  `recursos_idRecurso` INT NOT NULL,
  `reservas_idReserva` INT NOT NULL,
  `precio` FLOAT NULL,
  PRIMARY KEY (`recursos_idRecurso`, `reservas_idReserva`),
  INDEX `fk_recursos_has_reservas_reservas1_idx` (`reservas_idReserva` ASC),
  INDEX `fk_recursos_has_reservas_recursos1_idx` (`recursos_idRecurso` ASC),
  CONSTRAINT `fk_recursos_has_reservas_recursos1`
    FOREIGN KEY (`recursos_idRecurso`)
    REFERENCES `reservasDB`.`recursos` (`idRecurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recursos_has_reservas_reservas1`
    FOREIGN KEY (`reservas_idReserva`)
    REFERENCES `reservasDB`.`reservas` (`idReserva`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservasDB`.`reservas_has_servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservasDB`.`reservas_has_servicios` (
  `reservas_idReserva` INT NOT NULL,
  `servicios_idServicio` INT NOT NULL,
  `precio` FLOAT NULL,
  PRIMARY KEY (`reservas_idReserva`, `servicios_idServicio`),
  INDEX `fk_reservas_has_servicios_servicios1_idx` (`servicios_idServicio` ASC),
  INDEX `fk_reservas_has_servicios_reservas1_idx` (`reservas_idReserva` ASC),
  CONSTRAINT `fk_reservas_has_servicios_reservas1`
    FOREIGN KEY (`reservas_idReserva`)
    REFERENCES `reservasDB`.`reservas` (`idReserva`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservas_has_servicios_servicios1`
    FOREIGN KEY (`servicios_idServicio`)
    REFERENCES `reservasDB`.`servicios` (`idServicio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;