-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: ProjectShelf
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

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

--
-- Table structure for table `tb_user`
--
CREATE DATABASE `gestor-de-projetos`;
USE `gestor-de-projetos`;

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_user` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES (1,'Thiago','thiago@gmail.com','1234',NULL);
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_project`
--

DROP TABLE IF EXISTS `tb_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_project` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `nome_projeto` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_projeto` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_projeto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UltUpdate_projeto` tinyint NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_project`),
  KEY `fk_id_user_idx` (`id_user`),
  CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_todo`
--

DROP TABLE IF EXISTS `tb_todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_todo` (
  `id_todo` int NOT NULL AUTO_INCREMENT,
  `tarefa_todo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isDone_todo` tinyint NOT NULL,
  `id_projeto` int NOT NULL,
  PRIMARY KEY (`id_todo`),
  KEY `fk_id_projeto_idx` (`id_projeto`),
  CONSTRAINT `fk_id_projeto` FOREIGN KEY (`id_projeto`) REFERENCES `tb_project` (`id_project`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_todo`
--

LOCK TABLES `tb_todo` WRITE;
/*!40000 ALTER TABLE `tb_todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_todo` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-10  7:48:31