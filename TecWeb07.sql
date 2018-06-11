-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 11, 2018 alle 16:53
-- Versione del server: 10.1.31-MariaDB
-- Versione PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tecweb07`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Descrizione` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Luogo` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Data_Ora` datetime NOT NULL,
  `Programma` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Biglietti_Rimanenti` int(11) NOT NULL,
  `Organizzazione` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Sconto` int(11) DEFAULT NULL,
  `Data_Inizio_Sconto` date DEFAULT NULL,
  `Data_Fine_Acquisto` date NOT NULL,
  `Data_Inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Prezzo_Biglietto` float NOT NULL,
  `Locandina` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Mappa` text COLLATE utf8_unicode_ci NOT NULL,
  `Tipologia` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`Id`, `Nome`, `Descrizione`, `Luogo`, `Data_Ora`, `Programma`, `Biglietti_Rimanenti`, `Organizzazione`, `Sconto`, `Data_Inizio_Sconto`, `Data_Fine_Acquisto`, `Data_Inserimento`, `Prezzo_Biglietto`, `Locandina`, `Mappa`, `Tipologia`) VALUES
(1, 'Mostra di quadri', 'Esposizione di numerosi quadri nel museo cittadino', 'Roma', '2018-07-11 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 5, 'rot', NULL, NULL, '2018-05-28', '2018-06-11 08:52:00', 25, '1.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(2, 'Concerto Vasco', 'Concerto di Vasco Rossi', 'Bologna-roma-34', '2018-06-21 20:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 286, 'vasco1', 0, '2018-06-20', '2018-06-19', '2018-06-10 18:01:56', 120, '2.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(3, 'Tomb Raider', 'Film su Tomb Raider', 'Ancona', '2018-06-30 21:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 237, 'rot', 25, '2018-05-20', '2018-06-28', '2018-06-10 17:14:59', 25, '3.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(4, 'Mostra estiva', 'Grande mostra di quadri e sculture organizzata da Michelangelo', 'Pescara', '2018-08-01 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 0, 'Michelangelo', 20, '2018-08-28', '2018-07-31', '2018-06-10 17:14:59', 35, '4.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(12, 'Evento di prova', 'Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. ', 'Roma', '2018-07-31 08:00:00', 'Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. ', 2, 'azienda1', 30, '2018-05-23', '2018-06-12', '2018-06-10 17:11:13', 35, '5.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(13, 'Concerto stelle', 'Concerto serale molto bello ed entusiasmante!', 'Rimini-maggio-23', '2018-06-21 20:00:00', 'I cantanti inizieranno ad esibirsi dalle 20 per una notte di musica!', 130, 'vasco1', 20, '2018-06-16', '2018-06-20', '2018-06-03 09:57:49', 25.5, '6.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d45879.11938949925!2d12.53966754246735!3d44.05351968856158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132cc3a48fa6592b%3A0xc1f284db17f1449d!2sRimini+RN!5e0!3m2!1sit!2sit!4v1527851916955\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(15, 'Super Concerto', 'Concerto molto bello', 'Genova-milano-65', '2018-08-02 21:30:00', 'I cantanti canteranno per molto tempo', 82, 'vasco1', 0, '2018-07-29', '2018-08-02', '2018-06-03 13:21:58', 30.2, '7.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d91146.28728853996!2d8.820792035471769!3d44.44707885175662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d34152dcd49aad%3A0x236a84f11881620a!2sGenova+GE!5e0!3m2!1sit!2sit!4v1527885893689\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', NULL),
(21, 'fhgdsfgf', 'AFDSGHDJKLJUYTERFSDCX', 'fdsagd-dfsgfdf-1', '2018-07-01 20:00:00', 'FDGHJRYTUI7UYRGDFVCBGNHJ', 50, 'vasco1', 20, '2018-06-30', '2018-06-20', '2018-06-03 13:28:46', 25.5, '8.jpg', 'ferwt45ygf', NULL),
(22, 'dfgdhf', 'sadfghjk', 'dfsghfg-fdhgfg-3', '2018-07-01 20:00:00', 'sadfhgj', 50, 'vasco1', 20, '2018-06-30', '2018-06-29', '2018-06-03 13:33:56', 150, '9.jpg', 'dfgjhk', NULL),
(23, 'retyuy', 'jklÃ²iuyt', 'retyut-rteu-4', '2018-06-21 20:00:00', 'trehg', 50, 'vasco1', 20, '2018-06-20', '2018-06-29', '2018-06-03 13:34:46', 25.5, '10.jpg', '3retghjkiu76yt', NULL);

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
(2, 'Perché non riesco ad acquistare i biglietti?', 'Controllare di aver effettuato l\'accesso al sito; solo dopo aver effettuato l\'accesso si avrà la possibilità di acquistare biglietti.'),
(3, 'Come vengono spediti i biglietti?', 'Per posta o per mail'),
(4, 'Dopo quanto tempo arrivano i biglietti?', 'Dipende dalla spedizione, generalmente in 2 settimane.'),
(5, 'Se non ricevo un biglietto cosa faccio?', 'Ci puoi mandare una mail per chiedere informazioni'),
(6, 'Ci sono degli autobus organizzati da voi per gli eventi?', 'No, non forniamo questo tipo di servizio');

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
('biobio', 2),
('biobio', 12),
('cicciabella', 2),
('cicciabella', 3),
('mario1', 1),
('mario1', 2),
('mario1', 3),
('mario1', 12),
('mario1', 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `storico`
--

CREATE TABLE `storico` (
  `Numero_Ordine` int(11) NOT NULL,
  `Utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `Evento` int(11) NOT NULL,
  `Data_Ora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Numero_Biglietti` int(11) NOT NULL,
  `Modalita_Pagamento` varchar(20) COLLATE utf8_bin NOT NULL,
  `Totale` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `storico`
--

INSERT INTO `storico` (`Numero_Ordine`, `Utente`, `Evento`, `Data_Ora`, `Numero_Biglietti`, `Modalita_Pagamento`, `Totale`) VALUES
(11, 'mario1', 2, '2018-05-29 14:29:19', 2, 'Mastercard', 240),
(12, 'mario1', 12, '2018-05-29 14:30:46', 200, 'PayPal', 4900),
(13, 'mario1', 3, '2018-05-29 15:33:02', 3, 'Mastercard', 56.25),
(14, 'mario1', 3, '2018-05-29 16:19:16', 1, 'Mastercard', 18.75),
(15, 'mario1', 4, '2018-05-29 16:29:32', 400, 'Mastercard', 14000),
(16, 'Frank', 3, '2018-05-29 17:35:21', 2, 'Mastercard', 37.5),
(17, 'mario1', 3, '2018-05-31 07:21:24', 2, 'Mastercard', 37.5),
(18, 'mario1', 2, '2018-05-31 07:22:30', 1, 'Mastercard', 120),
(19, 'cicciabella', 2, '2018-05-31 12:42:25', 5, 'Visa', 600),
(20, 'mario1', 15, '2018-06-01 20:48:40', 3, 'Visa', 90.6);


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
('Concerto'),
('Mostra'),
('Mostra Di quadri');

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
('Frank', 'frank123', 'Francesco', 'Bruni', 'frank@gmail.com', 'Milano', 'liv2', '', '', '123456789', NULL, '', ''),
('Michelangelo', 'artisti1', 'Giorgio', 'Rossi', 'michelangelo@hotmail.com', 'Roma', 'liv3', 'Compagnia di artisti che organizzano mostre in tutto il territorio italiano.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', 'az4.png'),
('amministratore', 'amminis', 'Mario', 'Bruni', 'admin@gmail.com', 'Genova', 'liv4', '', '', '123456789', NULL, '', ''),
('azienda1', 'az1enda', 'Giuseppe', 'Verdi', 'azienda1@outlook.com', 'Roma', 'liv3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae diam venenatis, et blandit metus vehicula.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', 'az3.png'),
('biobio', 'bio1234', 'alfredo', 'colombo', 'alfredo@gmail.com', 'firenze-via roma-3', 'liv2', '', '', '324532324', NULL, '', ''),
('cicciabella', 'ciccia1', 'maria', 'bella', 'ciccia@libero.it', 'San Severo-Via D\'Annunzio-100', 'liv2', '', '', '666111254', NULL, '', ''),
('mario1', 'mario1', 'mariolino', 'rossi', 'mario@outlook.it', 'Roma-via roma-3a', 'liv2', '', '', '123456789', '123456789', '', ''),
('mariocc', '123456', 'mario', 'rossi', 'mario@rossi.it', 'roma-roma-23', 'liv2', '', '', '12354632', NULL, '', ''),
('rot', 'wefkuhbksd', 'reb3', 'ertbrb', 'feakjh@gmail.com', 'wefkjnhubfwe', 'liv3', 'erbgrwewer3bwe3grewbg', 'w3egg4w', '4567867', NULL, 'juekjbvs', 'az1.png'),
('utente123', '123456', 'giuseppe', 'bianchi', 'bianchi@giuseppe.it', 'ancona-garibaldi-12', 'liv2', '', '', '2324534532', NULL, '', ''),
('vasco1', 'vasco', 'vasco', 'rossi', 'vasco@gmail.com', 'Bologna', 'liv3', 'Cantautore', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', '123456789', 'Bologna', 'az2.png');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Evento_ibfk2` (`Organizzazione`),
  ADD KEY `Evento_ibfk1` (`Tipologia`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `faq`
--
ALTER TABLE `faq`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `storico`
--
ALTER TABLE `storico`
  MODIFY `Numero_Ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `Evento_ibfk1` FOREIGN KEY (`Tipologia`) REFERENCES `tipologia` (`Nome`) ON DELETE SET NULL ON UPDATE CASCADE,
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
  ADD CONSTRAINT `Storico_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Storico_ibfk_3` FOREIGN KEY (`Evento`) REFERENCES `evento` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
