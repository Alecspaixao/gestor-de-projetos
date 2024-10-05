-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: gestor-de-projetos
-- ------------------------------------------------------
-- Server version	8.0.39

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

-- Começar desabilitando as verificações de chave estrangeira
SET FOREIGN_KEY_CHECKS = 0;

-- Remover tabelas existentes
DROP TABLE IF EXISTS `tb_todo`;
DROP TABLE IF EXISTS `tb_project`;
DROP TABLE IF EXISTS `tb_user`;

-- Reabilitar as verificações de chave estrangeira
SET FOREIGN_KEY_CHECKS = 1;

-- Estruturas das tabelas
USE `gestor-de-projetos`;	

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_user` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tb_project` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `nome_projeto` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_projeto` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria_projeto` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indefinido',
  `banner_projeto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UltUpdate_projeto` datetime DEFAULT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_project`),
  KEY `fk_id_user_idx` (`id_user`),
  CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tb_todo` (
  `id_todo` int NOT NULL AUTO_INCREMENT,
  `tarefa_todo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isDone_todo` tinyint NOT NULL,
  `id_projeto` int NOT NULL,
  PRIMARY KEY (`id_todo`),
  KEY `fk_id_projeto_idx` (`id_projeto`),
  CONSTRAINT `fk_id_projeto` FOREIGN KEY (`id_projeto`) REFERENCES `tb_project` (`id_project`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserção de dados
LOCK TABLES `tb_user` WRITE;
INSERT INTO `tb_user` VALUES 
(6,'Pr0xy_3301','eriksynyster30@gmail.com','$2y$10$0hzgnExugRmsyv9IjBjFxuN2SUAO5iX/BFp/HTpuXyBfQEeElphO.','66e72b82d2bab.jpg'),
(17,'teste','thiago@gmail.com','$2y$10$wnr02SPrN9VJSZudoWmuLO1BtvKU4VmxOMIXGi39qnQb9NHYw6aEK','default-banner.png'),
(19,'Thiago','thiago3@gmail.com','$2y$10$ngAWbBarzYCVxQnTJE9sEu6nSE3kLnOIOkUOW1NOC34sIaDs1C.aK','66ecbcc039340.png');
UNLOCK TABLES;

LOCK TABLES `tb_project` WRITE;
INSERT INTO `tb_project` VALUES 
(51,'ProjectShelf','Genetica','Projeto Pessoal','66ecac024e310.jpeg','2024-09-19 19:56:02',19),
(54,'Django','documentos','Trabalho','default-banner.jpg','2024-09-19 20:29:14',19),
(55,'NLW','front-end','Projeto Pessoal','default-banner.jpg','2024-09-19 21:29:11',17);
UNLOCK TABLES;

LOCK TABLES `tb_todo` WRITE;
INSERT INTO `tb_todo` VALUES 
(1,'Tarefa 1', 0, 51),
(2,'Tarefa 2', 1, 54);
UNLOCK TABLES;

-- Finalizando
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
