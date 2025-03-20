-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 11:07 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tygodniowyharmonogram`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `harmonogram`
--

CREATE TABLE `harmonogram` (
  `Pracownik` varchar(50) NOT NULL,
  `Firma` varchar(100) NOT NULL,
  `Opis` varchar(256) NOT NULL,
  `ID_Uslugi` int(11) DEFAULT NULL,
  `Data` date DEFAULT NULL,
  `Godzina` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `harmonogram`
--

INSERT INTO `harmonogram` (`Pracownik`, `Firma`, `Opis`, `ID_Uslugi`, `Data`, `Godzina`) VALUES
('Paulina Kucharska', 'IRBUD Płock', 'Instalacja systemu GPS', 81418, '2025-03-16', '09:00:00'),
('Norbert Gierczak', 'REAL Siedlce', 'Wymiana zbiornika paliwa', 81001, '2025-03-16', '09:10:00'),
('Daniel Jaskółka', 'AGRO-TOP Wiśniew', 'Instalacja systemu GPS', 12612, '2025-03-17', '09:30:00'),
('Paweł Bocian', 'SOKOŁÓW-SERVICE', 'Wymiana świecy zapłonowej', 35825, '2025-03-17', '09:00:00'),
('Norbert Ciemniak', 'EURO EKO POLSKA Kielce', 'Wymiana zbiornika paliwa', 92478, '2025-03-18', '10:15:00'),
('Mikołaj Młynarski', 'SOKOŁÓW-SERVICE', 'Instalacja Bomby', 24573, '2025-03-19', '13:00:00'),
('Mikołaj Młynarski', 'IRBUD Płock', 'Instalacja Bomby', 89469, '2025-03-20', '07:00:00'),
('Norbert Ciemniak', 'EURO EKO POLSKA Kielce', 'Wymiana zbiornika paliwa', 23574, '2025-03-20', '15:00:00'),
('Mikołaj Młynarski', 'KOSD Kielce', 'Instalacja Bomby', 92464, '2025-03-21', '13:00:00'),
('Paweł Bocian', 'RDKIK Warszawa', 'Wymiana świecy zapłonowej', 18458, '2025-03-21', '11:00:00'),
('Norbert Gierczak', 'REAL Siedlce', 'Wymiana zbiornika paliwa', 19237, '2025-03-21', '11:30:00'),
('Norbert Gierczak', 'AGRO-TOP Wiśniew', 'Wymiana zbiornika paliwa', 12321, '2025-03-22', '10:00:00'),
('Paweł Bocian', 'IRBUD Płock', 'Wymiana świecy zapłonowej', 65432, '2025-03-23', '11:00:00'),
('Mikołaj Młynarski', 'SOKOŁÓW-SERVICE', 'Instalacja Bomby', 34129, '2025-03-23', '10:00:00'),
('Paulina Kucharska', 'EURO EKO POLSKA Kielce', 'Instalacja systemu GPS', 62481, '2025-03-24', '10:30:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `harmonogram`
--
ALTER TABLE `harmonogram`
  ADD UNIQUE KEY `ID_Uslugi` (`ID_Uslugi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
