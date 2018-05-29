-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 29, 2018 alle 19:15
-- Versione del server: 10.1.31-MariaDB
-- Versione PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `Tipologia` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Organizzazione` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Sconto` int(11) DEFAULT NULL,
  `Data_Inizio_Sconto` date DEFAULT NULL,
  `Data_Fine_Acquisto` datetime NOT NULL,
  `Data_Inserimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Prezzo_Biglietto` float NOT NULL,
  `Locandina` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Mappa` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`Id`, `Nome`, `Descrizione`, `Luogo`, `Data_Ora`, `Programma`, `Biglietti_Rimanenti`, `Tipologia`, `Organizzazione`, `Sconto`, `Data_Inizio_Sconto`, `Data_Fine_Acquisto`, `Data_Inserimento`, `Prezzo_Biglietto`, `Locandina`, `Mappa`) VALUES
(1, 'Mostra di quadri', 'Esposizione di numerosi quadri nel museo cittadino', 'Roma', '2018-07-11 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 0, 'Mostra', 'rot', NULL, NULL, '2018-05-28 00:00:00', '2018-05-29 19:04:19', 25, 'ev1.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>'),
(2, 'Concerto Vasco', 'Concerto di Vasco Rossi', 'Bologna', '2018-06-21 20:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 292, 'Concerto', 'vasco1', NULL, NULL, '2018-06-19 00:00:00', '2018-05-29 19:04:19', 120, 'ev2.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>'),
(3, 'Tomb Raider', 'Film su Tomb Raider', 'Ancona', '2018-06-30 21:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 241, 'Cinema', 'rot', 25, '2018-05-20', '2018-06-28 00:00:00', '2018-05-29 19:04:19', 25, 'ev3.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>'),
(4, 'Mostra estiva', 'Grande mostra di quadri e sculture organizzata da Michelangelo', 'Pescara', '2018-08-01 10:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', 0, 'Mostra', 'Michelangelo', 20, '2018-08-28', '2018-07-31 00:00:00', '2018-05-29 19:04:19', 35, 'ev4.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>'),
(12, 'Evento di prova', 'Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. ', 'Roma', '2018-07-31 08:00:00', 'Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. Evento creato per prova. ', 2, 'Cinema', 'azienda1', 30, '2018-05-23', '2018-05-28 00:00:00', '2018-05-29 19:04:19', 35, 'ev5.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3225.436285525689!2d13.905171926031052!3d42.88892289537918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1331f4b543b0c575%3A0xbd91d83ad7ee7912!2s64014+Martinsicuro+TE!5e0!3m2!1sit!2sit!4v1527612353958\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>');

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
  `Modalita_Pagamento` varchar(20) COLLATE utf8_bin NOT NULL,
  `Totale` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `storico`
--

INSERT INTO `storico` (`Numero_Ordine`, `Utente`, `Evento`, `Data_Ora`, `Numero_Biglietti`, `Modalita_Pagamento`, `Totale`) VALUES
(11, 'mario1', 2, '2018-05-29 16:29:19', 2, 'Mastercard', 240),
(12, 'mario1', 12, '2018-05-29 16:30:46', 200, 'PayPal', 4900),
(13, 'mario1', 3, '2018-05-29 17:33:02', 3, 'Mastercard', 56.25),
(14, 'mario1', 3, '2018-05-29 18:19:16', 1, 'Mastercard', 18.75),
(15, 'mario1', 4, '2018-05-29 18:29:32', 400, 'Mastercard', 14000);

--
-- Trigger `storico`
--
DELIMITER $$
CREATE TRIGGER `SottraiBiglietti` BEFORE INSERT ON `storico` FOR EACH ROW IF ((SELECT Biglietti_Rimanenti FROM Evento WHERE Id=NEW.Evento) >= NEW.Numero_Biglietti) 
THEN UPDATE evento SET Biglietti_Rimanenti=Biglietti_Rimanenti-NEW.Numero_Biglietti WHERE Id=NEW.Evento; 
ELSE SIGNAL SQLSTATE VALUE '45000' ;
END IF
$$
DELIMITER ;

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
('Michelangelo', 'artisti1', 'Giorgio', 'Rossi', 'michelangelo@hotmail.com', 'Roma', 'organizzazione', 'Compagnia di artisti che organizzano mostre in tutto il territorio italiano.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', 'az4.png'),
('amministratore', 'amminis', 'Mario', 'Bruni', 'admin@gmail.com', 'Genova', 'admin', '', '', '123456789', NULL, '', ''),
('azienda1', 'az1enda', 'Giuseppe', 'Verdi', 'azienda1@outlook.com', 'Roma', 'organizzazione', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae diam venenatis, et blandit metus vehicula.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', NULL, 'Roma', 'az3.png'),
('mario1', 'mario', 'mario', 'rossi', 'mario@outlook.it', 'Roma', 'utente', '', '', '123456789', '123456789', '', ''),
('mariocc', '123456', 'mario', 'rossi', 'mario@rossi.it', 'roma-roma-23', 'utente', '', '', '12354632', NULL, '', ''),
('rot', 'wefkuhbksd', 'reb3', 'ertbrb', 'feakjh@gmail.com', 'wefkjnhubfwe', 'organizzazione', 'erbgrwewer3bwe3grewbg', 'w3egg4w', '4567867', NULL, 'juekjbvs', 'az1.png'),
('vasco1', 'vasco', 'vasco', 'rossi', 'vasco@gmail.com', 'Bologna', 'organizzazione', 'Cantautore', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultricies magna sem. Pellentesque ut sapien nec augue ornare vestibulum. Aliquam cursus id magna at vulputate. Aliquam a orci id sem scelerisque maximus eget non augue. Fusce eleifend purus vitae', '123456789', '123456789', 'Bologna', 'az2.png');

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `faq`
--
ALTER TABLE `faq`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `storico`
--
ALTER TABLE `storico`
  MODIFY `Numero_Ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
