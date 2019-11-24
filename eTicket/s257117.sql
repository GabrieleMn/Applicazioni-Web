-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 18, 2019 alle 16:31
-- Versione del server: 10.1.40-MariaDB
-- Versione PHP: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airline`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`) VALUES
(28, 'u1@p.it', '$2y$10$dzh2M69WYC6O0uItQg9UbuHHChOqcQyn4at0Eg4fg7xLq9VXdq2ii'),
(29, 'u2@p.it', '$2y$10$Uew4lqkci1WOMl936vy0ceHOjv4LSlV7NwoawBreyyGYHS9F9IptO');

-- --------------------------------------------------------

--
-- Struttura della tabella `seats`
--

DROP TABLE IF EXISTS `seats`;
CREATE TABLE `seats` (
  `rowId` int(1) NOT NULL,
  `columnId` char(1) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `owner` varchar(20) DEFAULT '""'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `seats`
--

INSERT INTO `seats` (`rowId`, `columnId`, `status`, `owner`) VALUES
(2, 'B', 2, 'u2@p.it'),
(3, 'B', 2, 'u2@p.it'),
(4, 'A', 1, 'u1@p.it'),
(4, 'B', 2, 'u2@p.it'),
(4, 'D', 1, 'u1@p.it'),
(4, 'F', 1, 'u2@p.it');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`rowId`,`columnId`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
