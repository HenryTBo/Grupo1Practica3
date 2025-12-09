CREATE DATABASE IF NOT EXISTS `practica3` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `practica3`;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- -------------- TABLA PRINCIPAL

DROP TABLE IF EXISTS `principal`;

CREATE TABLE `principal` (
  `IdCompra` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(100) NOT NULL,
  `Precio` DECIMAL(10,2) NOT NULL,
  `Saldo` DECIMAL(10,2) NOT NULL,
  `Estado` ENUM('Pendiente','Cancelado') DEFAULT 'Pendiente',
  PRIMARY KEY (`IdCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `principal` (Descripcion, Precio, Saldo, Estado) VALUES
('Impresora Epson', 50000, 50000, 'Pendiente'),
('Monitor Samsung', 75000, 75000, 'Pendiente'),
('Laptop Lenovo', 250000, 0, 'Cancelado');

-- --------------- TABLA ABONOS

DROP TABLE IF EXISTS `abonos`;

CREATE TABLE `abonos` (
  `IdAbono` INT(11) NOT NULL AUTO_INCREMENT,
  `IdCompra` INT(11) NOT NULL,
  `Monto` DECIMAL(10,2) NOT NULL,
  `Fecha` DATETIME NOT NULL,
  PRIMARY KEY (`IdAbono`),
  KEY `fk_abono_compra` (`IdCompra`),
  CONSTRAINT `fk_abono_compra` FOREIGN KEY (`IdCompra`)
    REFERENCES `principal` (`IdCompra`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------- PROCEDIMIENTOS ALMACENADOS

DELIMITER $$

-- 1. Listar todas las compras
DROP PROCEDURE IF EXISTS sp_Compras_ObtenerTodas $$
CREATE PROCEDURE sp_Compras_ObtenerTodas()
BEGIN
    SELECT IdCompra, Descripcion, Precio, Saldo, Estado
    FROM principal
    ORDER BY Estado='Pendiente' DESC, IdCompra ASC;
END $$

-- 2. Compras pendientes (para el dropdown)
DROP PROCEDURE IF EXISTS sp_Compras_ObtenerPendientes $$
CREATE PROCEDURE sp_Compras_ObtenerPendientes()
BEGIN
    SELECT IdCompra, Descripcion, Saldo
    FROM principal
    WHERE Estado='Pendiente'
    ORDER BY IdCompra ASC;
END $$

-- 3. Obtener saldo de una compra
DROP PROCEDURE IF EXISTS sp_Compras_ObtenerSaldo $$
CREATE PROCEDURE sp_Compras_ObtenerSaldo(IN pid INT)
BEGIN
    SELECT Saldo FROM principal WHERE IdCompra = pid;
END $$

-- 4. Registrar abono
DROP PROCEDURE IF EXISTS sp_Abonos_Registrar $$
CREATE PROCEDURE sp_Abonos_Registrar(IN pid INT, IN pmonto DECIMAL(10,2))
BEGIN
    DECLARE vsaldo DECIMAL(10,2);

    SELECT Saldo INTO vsaldo FROM principal WHERE IdCompra = pid FOR UPDATE;

    IF vsaldo IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='La compra no existe';
    END IF;

    IF pmonto <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='El abono debe ser mayor a cero';
    END IF;

    IF pmonto > vsaldo THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='El abono no puede ser mayor al saldo';
    END IF;

    INSERT INTO abonos(IdCompra, Monto, Fecha) VALUES (pid, pmonto, NOW());

    SET vsaldo = vsaldo - pmonto;

    UPDATE principal
    SET Saldo = vsaldo,
        Estado = IF(vsaldo=0,'Cancelado','Pendiente')
    WHERE IdCompra = pid;
END $$

DELIMITER ;
