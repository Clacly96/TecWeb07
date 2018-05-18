-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2018 at 06:22 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TecWeb07`
--

-- --------------------------------------------------------

--
-- Table structure for table `Evento`
--

CREATE TABLE `Evento` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(40) COLLATE utf8_bin NOT NULL,
  `Descrizione` text COLLATE utf8_bin NOT NULL,
  `Luogo` varchar(60) COLLATE utf8_bin NOT NULL,
  `Data_Ora` datetime NOT NULL,
  `Programma` tinytext COLLATE utf8_bin NOT NULL,
  `Biglietti_Rimanenti` int(11) NOT NULL,
  `Tipologia` varchar(20) COLLATE utf8_bin NOT NULL,
  `Organizzazione` varchar(20) COLLATE utf8_bin NOT NULL,
  `Sconto` int(11) DEFAULT NULL,
  `Data_Inizio_Sconto` date DEFAULT NULL,
  `Data_Fine_Acquisto` datetime NOT NULL,
  `Data_Inserimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Prezzo_Biglieto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Evento`
--

INSERT INTO `Evento` (`Id`, `Nome`, `Descrizione`, `Luogo`, `Data_Ora`, `Programma`, `Biglietti_Rimanenti`, `Tipologia`, `Organizzazione`, `Sconto`, `Data_Inizio_Sconto`, `Data_Fine_Acquisto`, `Data_Inserimento`, `Prezzo_Biglieto`) VALUES
(3, 'jbef', 'jkwjrenj', 'wre', '2018-05-18 00:00:00', 'wervb', 3, 'Cinema', 'qwef', NULL, NULL, '2018-05-18 00:00:00', '2018-05-18 18:13:46', 20),
(4, 'bhdj', 'ubdgekbsd fdeujhsadubvg sauhb', 'ujbsgadkiougbsad', '2018-05-23 09:00:00', 'uygfaigbufedsauigfsead', 100, 'Cinema', 'uihasdei', 20, '2018-05-16', '2018-05-22 00:00:00', '2018-05-18 18:14:03', 60),
(5, 'jkbgdscaijk', 'seadujvbkasdjc', 'uisach', '2018-05-28 00:00:00', 'asckjvbsajvcjk sac asc', 3, 'Mostra', 'qegw', NULL, NULL, '2018-05-30 00:00:00', '2018-05-18 18:14:27', 55.5),
(6, 'kvuciefg', 'weufigbwebkjf weujbev', 'wreg', '2018-05-22 00:00:00', 'wregwegwegqwevweg', 34, 'Cinema', 'wfeweg', NULL, NULL, '2018-05-19 00:00:00', '2018-05-18 18:21:42', 999.99);

-- --------------------------------------------------------

--
-- Table structure for table `FAQ`
--

CREATE TABLE `FAQ` (
  `Id` int(11) NOT NULL,
  `Domanda` tinytext COLLATE utf8_bin NOT NULL,
  `Risposta` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FAQ`
--

INSERT INTO `FAQ` (`Id`, `Domanda`, `Risposta`) VALUES
(1, 'iahvedsuibsedvahbbvd aujhgaiovgb?', 'kujbagukbgebe eauavgunjbesb fseaafhesdu'),
(2, 'asvcubgjk sacwuhjbgvasc', 'kjb<asvckubjkas<vc');

-- --------------------------------------------------------

--
-- Table structure for table `Partecipazione`
--

CREATE TABLE `Partecipazione` (
  `Utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `Evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Partecipazione`
--

INSERT INTO `Partecipazione` (`Utente`, `Evento`) VALUES
('admin', 5),
('rot', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Storico`
--

CREATE TABLE `Storico` (
  `Numero_Ordine` int(11) NOT NULL,
  `Utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `Evento` int(11) NOT NULL,
  `Data_Ora` datetime NOT NULL,
  `Numero_Biglietti` int(11) NOT NULL,
  `Modalita_Pagamento` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Storico`
--

INSERT INTO `Storico` (`Numero_Ordine`, `Utente`, `Evento`, `Data_Ora`, `Numero_Biglietti`, `Modalita_Pagamento`) VALUES
(1, 'admin', 5, '2018-05-17 00:00:00', 1, 'visa'),
(2, 'rot', 5, '2018-05-08 00:00:00', 6, 'kjwvn');

-- --------------------------------------------------------

--
-- Table structure for table `Tipologia`
--

CREATE TABLE `Tipologia` (
  `Nome` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Tipologia`
--

INSERT INTO `Tipologia` (`Nome`) VALUES
(''),
('Cinema'),
('Mostra');

-- --------------------------------------------------------

--
-- Table structure for table `Utente`
--

CREATE TABLE `Utente` (
  `Username` varchar(20) COLLATE utf8_bin NOT NULL,
  `Password` varchar(10) COLLATE utf8_bin NOT NULL,
  `Nome` varchar(30) COLLATE utf8_bin NOT NULL,
  `Cognome` varchar(30) COLLATE utf8_bin NOT NULL,
  `Email` varchar(40) COLLATE utf8_bin NOT NULL,
  `Residenza` varchar(60) COLLATE utf8_bin NOT NULL,
  `Ruolo` varchar(20) COLLATE utf8_bin NOT NULL,
  `Descrizione` text COLLATE utf8_bin NOT NULL,
  `Missione` tinytext COLLATE utf8_bin NOT NULL,
  `Telefono` varchar(20) COLLATE utf8_bin NOT NULL,
  `Fax` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Sede` varchar(60) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Utente`
--

INSERT INTO `Utente` (`Username`, `Password`, `Nome`, `Cognome`, `Email`, `Residenza`, `Ruolo`, `Descrizione`, `Missione`, `Telefono`, `Fax`, `Sede`) VALUES
('admin', 'adsjk', 'jbhg', 'er', 'jubhwer@libero.it', 'uierw', 'organizzazione', 'erbgvweb erbwerb', 'we3rhuwf', '76765897546', '256732355', 'adjfkbjbsf'),
('rot', 'wefkuhbksd', 'reb3', 'ertbrb', 'feakjh@gmail.com', 'wefkjnhubfwe', 'utente', 'erbgrwewer3bwe3grewbg', 'w3egg4w', '4567867', NULL, 'juekjbvs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Evento`
--
ALTER TABLE `Evento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Tipologia` (`Tipologia`);

--
-- Indexes for table `FAQ`
--
ALTER TABLE `FAQ`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Partecipazione`
--
ALTER TABLE `Partecipazione`
  ADD PRIMARY KEY (`Utente`,`Evento`),
  ADD KEY `Evento` (`Evento`);

--
-- Indexes for table `Storico`
--
ALTER TABLE `Storico`
  ADD PRIMARY KEY (`Numero_Ordine`),
  ADD KEY `Utente` (`Utente`),
  ADD KEY `Evento` (`Evento`);

--
-- Indexes for table `Tipologia`
--
ALTER TABLE `Tipologia`
  ADD PRIMARY KEY (`Nome`);

--
-- Indexes for table `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Evento`
--
ALTER TABLE `Evento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `FAQ`
--
ALTER TABLE `FAQ`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Storico`
--
ALTER TABLE `Storico`
  MODIFY `Numero_Ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Evento`
--
ALTER TABLE `Evento`
  ADD CONSTRAINT `Evento_ibfk_1` FOREIGN KEY (`Tipologia`) REFERENCES `Tipologia` (`Nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Partecipazione`
--
ALTER TABLE `Partecipazione`
  ADD CONSTRAINT `Partecipazione_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `Utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Partecipazione_ibfk_3` FOREIGN KEY (`Evento`) REFERENCES `Evento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Storico`
--
ALTER TABLE `Storico`
  ADD CONSTRAINT `Storico_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `Utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Storico_ibfk_3` FOREIGN KEY (`Evento`) REFERENCES `Evento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
