-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 21, 2018 alle 14:10
-- Versione del server: 10.1.31-MariaDB
-- Versione PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tecweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
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
  `Prezzo_Biglietto` float NOT NULL,
  `Locandina` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`Id`, `Nome`, `Descrizione`, `Luogo`, `Data_Ora`, `Programma`, `Biglietti_Rimanenti`, `Tipologia`, `Organizzazione`, `Sconto`, `Data_Inizio_Sconto`, `Data_Fine_Acquisto`, `Data_Inserimento`, `Prezzo_Biglietto`, `Locandina`) VALUES
(1, 'Mostra di quadri', 'Esposizione di numerosi quadri nel museo cittadino', 'Roma', '2018-07-11 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 100, 'Mostra', 'rot', NULL, NULL, '2018-07-10 00:00:00', '2018-05-19 16:26:52', 25, ''),
(2, 'Concerto Vasco', 'Concerto di Vasco Rossi', 'Bologna', '2018-06-21 20:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 300, 'Concerto', 'vasco1', NULL, NULL, '2018-06-19 00:00:00', '2018-05-19 16:36:15', 120, ''),
(3, 'Tomb Raider', 'Film su Tomb Raider', 'Ancona', '2018-06-30 21:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 250, 'Cinema', 'rot', NULL, NULL, '2018-06-28 00:00:00', '2018-05-19 16:36:29', 25, ''),
(11, 'Mostra estiva', 'Grande mostra di quadri e sculture organizzata da Michelangelo', 'Pescara', '2018-08-01 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 400, 'Mostra', 'Michelangelo', 20, '2018-08-28', '2018-07-31 00:00:00', '2018-05-19 17:23:39', 35, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `faq`
--

CREATE TABLE `faq` (
  `Id` int(11) NOT NULL,
  `Domanda` tinytext COLLATE utf8_bin NOT NULL,
  `Risposta` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `faq`
--

INSERT INTO `faq` (`Id`, `Domanda`, `Risposta`) VALUES
(1, 'Come si acquistano i biglietti?', 'Bisogna registrarsi al sito, poi fare click su un evento e in seguito sarà possibile acquistare i biglietti.'),
(2, 'Perché non riesco ad acquistare i biglietti?', 'Controllare di aver effettuato l\'accesso al sito; solo dopo aver effettuato l\'accesso si avrà la possibilità di acquistare biglietti.');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipazione`
--

CREATE TABLE `partecipazione` (
  `Utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `Evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `partecipazione`
--

INSERT INTO `partecipazione` (`Utente`, `Evento`) VALUES
('Frank', 2),
('Frank', 3),
('mario1', 1),
('mario1', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `storico`
--

CREATE TABLE `storico` (
  `Numero_Ordine` int(11) NOT NULL,
  `Utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `Evento` int(11) NOT NULL,
  `Data_Ora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Numero_Biglietti` int(11) NOT NULL,
  `Modalita_Pagamento` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `storico`
--

INSERT INTO `storico` (`Numero_Ordine`, `Utente`, `Evento`, `Data_Ora`, `Numero_Biglietti`, `Modalita_Pagamento`) VALUES
(1, 'Frank', 2, '2018-05-20 00:00:00', 3, 'carta di credito'),
(3, 'Frank', 1, '2018-05-19 00:00:00', 1, 'carta di credito');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

CREATE TABLE `tipologia` (
  `Nome` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`Nome`) VALUES
('Cinema'),
('Concerto'),
('Mostra');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
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
  `Sede` varchar(60) COLLATE utf8_bin NOT NULL,
  `Logo` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`Username`, `Password`, `Nome`, `Cognome`, `Email`, `Residenza`, `Ruolo`, `Descrizione`, `Missione`, `Telefono`, `Fax`, `Sede`, `Logo`) VALUES
('Frank', 'frank123', 'Francesco', 'Bruni', 'frank@gmail.com', 'Milano', 'utente', '', '', '123456789', NULL, '', ''),
('Michelangelo', 'artisti1', 'Giorgio', 'Rossi', 'michelangelo@hotmail.com', 'Roma', 'organizzazione', 'Compagnia di artisti che organizzano mostre in tutto il territorio italiano.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', ''),
('amministratore', 'amminis', 'Mario', 'Bruni', 'admin@gmail.com', 'Genova', 'admin', '', '', '123456789', NULL, '', ''),
('azienda1', 'az1enda', 'Giuseppe', 'Verdi', 'azienda1@outlook.com', 'Roma', 'organizzazione', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae diam venenatis, et blandit metus vehicula.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', ''),
('mario1', 'mario', 'mario', 'rossi', 'mario@outlook.it', 'Roma', 'utente', '', '', '123456789', '123456789', '', ''),
('rot', 'wefkuhbksd', 'reb3', 'ertbrb', 'feakjh@gmail.com', 'wefkjnhubfwe', 'organizzazione', 'erbgrwewer3bwe3grewbg', 'w3egg4w', '4567867', NULL, 'juekjbvs', ''),
('vasco1', 'vasco', 'vasco', 'rossi', 'vasco@gmail.com', 'Bologna', 'organizzazione', 'Cantautore', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', '123456789', 'Bologna', '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Tipologia` (`Tipologia`),
  ADD KEY `Evento_ibfk2` (`Organizzazione`);

--
-- Indici per le tabelle `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `partecipazione`
--
ALTER TABLE `partecipazione`
  ADD PRIMARY KEY (`Utente`,`Evento`),
  ADD KEY `Evento` (`Evento`);

--
-- Indici per le tabelle `storico`
--
ALTER TABLE `storico`
  ADD PRIMARY KEY (`Numero_Ordine`),
  ADD KEY `Utente` (`Utente`),
  ADD KEY `Evento` (`Evento`);

--
-- Indici per le tabelle `tipologia`
--
ALTER TABLE `tipologia`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `faq`
--
ALTER TABLE `faq`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `storico`
--
ALTER TABLE `storico`
  MODIFY `Numero_Ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `Evento_ibfk1` FOREIGN KEY (`Tipologia`) REFERENCES `tipologia` (`Nome`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Evento_ibfk2` FOREIGN KEY (`Organizzazione`) REFERENCES `utente` (`Username`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `partecipazione`
--
ALTER TABLE `partecipazione`
  ADD CONSTRAINT `Partecipazione_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Partecipazione_ibfk_3` FOREIGN KEY (`Evento`) REFERENCES `evento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `storico`
--
ALTER TABLE `storico`
  ADD CONSTRAINT `Storico_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Storico_ibfk_3` FOREIGN KEY (`Evento`) REFERENCES `evento` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
