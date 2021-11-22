-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: ocqms
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.21.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `Uname` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `AdminId` int NOT NULL AUTO_INCREMENT,
  `Profile` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`AdminId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,'images/adminUserProfile.png');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatchers`
--

DROP TABLE IF EXISTS `dispatchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dispatchers` (
  `FirstName` varchar(100) NOT NULL,
  `OnDuty` tinyint(1) NOT NULL,
  `PIN` varchar(10) NOT NULL,
  `Contact` varchar(30) NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `Profile` varchar(200) DEFAULT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Suffix` varchar(10) DEFAULT NULL,
  `Address` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatchers`
--

LOCK TABLES `dispatchers` WRITE;
/*!40000 ALTER TABLE `dispatchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `dispatchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loaded_passengers`
--

DROP TABLE IF EXISTS `loaded_passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loaded_passengers` (
  `Vehicle` varchar(40) NOT NULL,
  `Passenger` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loaded_passengers`
--

LOCK TABLES `loaded_passengers` WRITE;
/*!40000 ALTER TABLE `loaded_passengers` DISABLE KEYS */;
/*!40000 ALTER TABLE `loaded_passengers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `LogId` int NOT NULL AUTO_INCREMENT,
  `Directory` varchar(80) NOT NULL,
  `Vehicle` varchar(20) NOT NULL,
  `Passengers` varchar(20) NOT NULL,
  `LogTime` time DEFAULT NULL,
  `Route` varchar(50) NOT NULL,
  `LogDate` date DEFAULT NULL,
  PRIMARY KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ormoc_commuters`
--

DROP TABLE IF EXISTS `ormoc_commuters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ormoc_commuters` (
  `QR` varchar(100) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Contact` varchar(50) NOT NULL,
  PRIMARY KEY (`QR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ormoc_commuters`
--

LOCK TABLES `ormoc_commuters` WRITE;
/*!40000 ALTER TABLE `ormoc_commuters` DISABLE KEYS */;
/*!40000 ALTER TABLE `ormoc_commuters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `QuestionId` int NOT NULL AUTO_INCREMENT,
  `Question` varchar(100) NOT NULL,
  `Answer` varchar(200) NOT NULL,
  PRIMARY KEY (`QuestionId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'What is your favorite color?','78988010b890ce6f4d2136481f392787ec6d6106'),(2,'What is your mothers maiden name?','78988010b890ce6f4d2136481f392787ec6d6106'),(3,'What elementary school did you attend?','78988010b890ce6f4d2136481f392787ec6d6106'),(4,'When you were young, what did you want to be when you grew up?','78988010b890ce6f4d2136481f392787ec6d6106'),(5,'What is the name of the town where you were born?','78988010b890ce6f4d2136481f392787ec6d6106');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registered_vehicles`
--

DROP TABLE IF EXISTS `registered_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registered_vehicles` (
  `Route` varchar(30) NOT NULL,
  `Capacity` int NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `Contact` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Suffix` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DFirstName` varchar(100) NOT NULL,
  `DMiddleName` varchar(100) NOT NULL,
  `DLastName` varchar(100) NOT NULL,
  `DSuffix` varchar(5) NOT NULL,
  `DContact` varchar(20) NOT NULL,
  `DAddress` varchar(100) NOT NULL,
  `VehicleProfile` varchar(100) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `PlateNo` varchar(10) NOT NULL,
  PRIMARY KEY (`PlateNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registered_vehicles`
--

LOCK TABLES `registered_vehicles` WRITE;
/*!40000 ALTER TABLE `registered_vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `registered_vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waiting_passengers`
--

DROP TABLE IF EXISTS `waiting_passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `waiting_passengers` (
  `Destination` varchar(50) NOT NULL,
  `Passenger` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waiting_passengers`
--

LOCK TABLES `waiting_passengers` WRITE;
/*!40000 ALTER TABLE `waiting_passengers` DISABLE KEYS */;
/*!40000 ALTER TABLE `waiting_passengers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-22 15:24:21
