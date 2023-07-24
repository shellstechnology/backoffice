create database BackOfficeBD;
use BackOfficeBD;
CREATE TABLE `Producto` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Nombre` varchar(20) NOT NULL,
	`Precio` INT NOT NULL,
	`TipoMoneda` varchar(3) NOT NULL,
	`Stock` INT NOT NULL,
	PRIMARY KEY (`Id`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);
CREATE TABLE `Paquete` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`FechaDeEntrega` DATE NOT NULL,
	`IdLugarEntrega` INT NOT NULL,
	`IdCaracteristica` INT NOT NULL,
	`NombreRemitente` varchar(20) NOT NULL,
	`NombreDestinatario` varchar(20) NOT NULL,
	`IdProducto` INT NOT NULL,
	`VolumenL` FLOAT NOT NULL,
	`PesoKg` FLOAT NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`Id`)
);


CREATE TABLE `Caracteristica` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Descripcion` varchar(100) NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`Id`)
);
CREATE TABLE `LugarEntrega` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Direccion` varchar(25) NOT NULL,
	`Latitud` FLOAT NOT NULL,
	`Longitud` FLOAT NOT NULL,
	PRIMARY KEY (`Id`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `Lote` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`VolumenL` FLOAT NOT NULL,
	`PesoKg` FLOAT NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`Id`)
);

CREATE TABLE `Almacen` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`IdDireccionAlmacen` INT NOT NULL,
	`IdLugarDeEntrega` INT,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`Id`)
);
CREATE TABLE `DireccionAlmacen` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Direccion` varchar(25) NOT NULL,
	`Latitud` FLOAT NOT NULL,
	`Longitud` FLOAT NOT NULL,
    `created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`Id`)
);

CREATE TABLE `Camion` (
	`Matricula` varchar(8) NOT NULL,
	`IdModelo` INT NOT NULL,
	`IdEstado` INT NOT NULL,
	PRIMARY KEY (`Matricula`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `Modelo` (
	`IdModelo` INT NOT NULL AUTO_INCREMENT,
	`Marca` varchar(20) NOT NULL,
	`Modelo` varchar(20) NOT NULL,
	`VolumenMaxKg` FLOAT NOT NULL,
	`PesoMaxKg` FLOAT NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`IdModelo`)
);

CREATE TABLE `Estado` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Estado` varchar(17) NOT NULL,
	PRIMARY KEY (`Id`)
);

CREATE TABLE `PaqueteContieneLote` (
	`IdPaquete` INT NOT NULL AUTO_INCREMENT,
	`IdLote` INT NOT NULL,
	`IdAlmacen` INT NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`IdPaquete`)
);

CREATE TABLE `CamionLlevaLote` (
	`IdLote` INT NOT NULL AUTO_INCREMENT,
	`IdCamion` varchar(8) NOT NULL,
	PRIMARY KEY (`IdLote`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `Usuario` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`NombreDeUsuario` varchar(20) NOT NULL,
	`Contraseña` varchar(20) NOT NULL,
	`TipoDeUsuario` varchar(20) NOT NULL,
	PRIMARY KEY (`Id`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `TelefonosUsuario` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	`Telefono` INT NOT NULL,
	PRIMARY KEY (`IdUsuario`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `MailUsuario` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	`Mail` varchar(40) NOT NULL,
	PRIMARY KEY (`IdUsuario`),
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime
);

CREATE TABLE `Chofer` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	`LicenciaDeConducir` INT NOT NULL,
	`created_at` datetime,
    `updated_at` datetime,
	`deleted_at` datetime,
	PRIMARY KEY (`IdUsuario`)
);

CREATE TABLE `ChoferConduceCamion` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	`IdCamion` varchar(8) NOT NULL,
	`FechaYHora` DATETIME NOT NULL,
	PRIMARY KEY (`IdUsuario`)
);

CREATE TABLE `Almacenero` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`IdUsuario`)
);

CREATE TABLE `Cliente` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`IdUsuario`)
);

CREATE TABLE `Administrador` (
	`IdUsuario` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`IdUsuario`)
);

ALTER TABLE `Paquete` ADD CONSTRAINT `Paquetefk0` FOREIGN KEY (`IdLugarEntrega`) REFERENCES `LugarEntrega`(`Id`);

ALTER TABLE `Paquete` ADD CONSTRAINT `Paquetefk1` FOREIGN KEY (`IdCaracteristica`) REFERENCES `Caracteristica`(`Id`);

ALTER TABLE `Almacen` ADD CONSTRAINT `Almacenfk0` FOREIGN KEY (`IdDireccionAlmacen`) REFERENCES `DireccionAlmacen`(`Id`);

ALTER TABLE `Almacen` ADD CONSTRAINT `Almacenfk1` FOREIGN KEY (`IdLugarDeEntrega`) REFERENCES `LugarEntrega`(`Id`);

ALTER TABLE `Camion` ADD CONSTRAINT `Camionfk0` FOREIGN KEY (`IdModelo`) REFERENCES `Modelo`(`IdModelo`);

ALTER TABLE `Camion` ADD CONSTRAINT `Camionfk1` FOREIGN KEY (`IdEstado`) REFERENCES `Estado`(`Id`);

ALTER TABLE `PaqueteContieneLote` ADD CONSTRAINT `PaqueteContieneLotefk0` FOREIGN KEY (`IdPaquete`) REFERENCES `Paquete`(`Id`);

ALTER TABLE `PaqueteContieneLote` ADD CONSTRAINT `PaqueteContieneLotefk1` FOREIGN KEY (`IdLote`) REFERENCES `Lote`(`Id`);

ALTER TABLE `PaqueteContieneLote` ADD CONSTRAINT `PaqueteContieneLotefk2` FOREIGN KEY (`IdAlmacen`) REFERENCES `Almacen`(`Id`);

ALTER TABLE `CamionLlevaLote` ADD CONSTRAINT `CamionLlevaLotefk0` FOREIGN KEY (`IdLote`) REFERENCES `Lote`(`Id`);

ALTER TABLE `CamionLlevaLote` ADD CONSTRAINT `CamionLlevaLotefk1` FOREIGN KEY (`IdCamion`) REFERENCES `Camion`(`Matricula`);

ALTER TABLE `TelefonosUsuario` ADD CONSTRAINT `TelefonosUsuariofk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

ALTER TABLE `MailUsuario` ADD CONSTRAINT `MailUsuariofk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

ALTER TABLE `Chofer` ADD CONSTRAINT `Choferfk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

ALTER TABLE `ChoferConduceCamion` ADD CONSTRAINT `ChoferConduceCamionfk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Chofer`(`IdUsuario`);

ALTER TABLE `ChoferConduceCamion` ADD CONSTRAINT `ChoferConduceCamionfk1` FOREIGN KEY (`IdCamion`) REFERENCES `Camion`(`Matricula`);

ALTER TABLE `Almacenero` ADD CONSTRAINT `Almacenerofk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

ALTER TABLE `Cliente` ADD CONSTRAINT `Clientefk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

ALTER TABLE `Administrador` ADD CONSTRAINT `Administradorfk0` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario`(`Id`);

