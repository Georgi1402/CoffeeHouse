-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 08:55 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeehouse`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizeaza_stocul_produsului` (`in_id_produs` INT, `in_cantitate` INT)   BEGIN
    UPDATE Produse SET cantitate_stoc = cantitate_stoc - in_cantitate WHERE id_produs = in_id_produs;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `plaseaza_comanda_noua` (`in_id_client` INT, `in_id_angajat` INT, `in_data_comanda` DATE, `in_lista_produse` VARCHAR(255))   BEGIN
    DECLARE id_comanda INT;
    INSERT INTO Comenzi(id_client, id_angajat, data_comanda) 
    VALUES (in_id_client, in_id_angajat, in_data_comanda);
    SET id_comanda = LAST_INSERT_ID();
    INSERT INTO Comenzi_Produse(id_comanda, id_produs) 
    SELECT id_comanda, id_produs 
    FROM Produse 
    WHERE FIND_IN_SET(id_produs, in_lista_produse) > 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sterge_facturile_furnizorului` (`in_id_furnizor` INT)   BEGIN
    DELETE FROM Facturi WHERE id_furnizor = in_id_furnizor;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calculeaza_numar_comenzi_client` (`in_id_client` INT) RETURNS INT DETERMINISTIC BEGIN
    DECLARE numar_comenzi INT;
    SELECT COUNT(*) INTO numar_comenzi
    FROM Comenzi
    WHERE id_client = in_id_client;
    RETURN numar_comenzi;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calculeaza_valoare_totala_comanda` (`in_id_comanda` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE total DECIMAL(10,2);
    SELECT SUM(pret_unitar) INTO total
    FROM Produse
    INNER JOIN Comenzi_Produse ON Produse.id_produs = Comenzi_Produse.id_produs
    WHERE Comenzi_Produse.id_comanda = in_id_comanda;
    RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calculeaza_valoare_totala_facturi_furnizor` (`in_id_furnizor` INT, `in_data_inceput` DATE, `in_data_sfarsit` DATE) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE total DECIMAL(10,2);
    SELECT SUM(valoare_factura) INTO total
    FROM Facturi
    WHERE id_furnizor = in_id_furnizor AND data_factura BETWEEN in_data_inceput AND in_data_sfarsit;
    RETURN total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `angajati`
--

CREATE TABLE `angajati` (
  `id_angajat` int NOT NULL,
  `nume` varchar(255) NOT NULL,
  `prenume` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_angajare` date NOT NULL,
  `salariu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `angajati`
--

INSERT INTO `angajati` (`id_angajat`, `nume`, `prenume`, `adresa`, `telefon`, `email`, `data_angajare`, `salariu`) VALUES
(1, 'Popescu', 'Maria', 'pinului 45', '0765458912', 'pmaria@gmail.com', '2014-05-08', '2500'),
(2, 'Moldovan', 'Andrei', 'ghioceilor 12', '0789651234', 'mandrei@yahoo.com', '2018-11-14', '3000'),
(3, 'Carai', 'Toni', 'barsana 173', '0769199729', 'ctoni@uab.ro', '2016-04-14', '4500');

-- --------------------------------------------------------

--
-- Table structure for table `clienti`
--

CREATE TABLE `clienti` (
  `id_client` int NOT NULL,
  `nume` varchar(255) NOT NULL,
  `prenume` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `parola` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clienti`
--

INSERT INTO `clienti` (`id_client`, `nume`, `prenume`, `adresa`, `telefon`, `email`, `parola`) VALUES
(1, 'Petricean', 'Ioana', 'barsana 1073', '0784048464', 'ioana@gmail.com', 'pasare'),
(2, 'Tanase', 'Ciprian', 'panade 148', '0769199729', 'tanase@gmail.com', 'fbtn1zfb'),
(3, 'Covaci', 'Ramona', 'trandafirului 17', '0789236712', 'ramonacovaci@yahoo.com', 'hipopotam'),
(4, 'Mica', 'Georgi', 'ghioceilor', '0751118943', 'georgymitca@gmail.com', '$2y$10$jbOdsElhOIPDIeyBn9BqB.UEvdWfj/hrn5zUhvlPhZr61ZMJJ0saC'),
(5, '', '', '', '', '', '$2y$10$JH1uI.k8XRtN6k/D137.3.bqbgAgCN5wEVA0Wzfunf1QMS1QsZDWm'),
(6, '', '', '', '', 'pvasile@gmail.com', '$2y$10$jQxU7SzXImbP335uqwfDE.u.arT6unmk4BPPvTZEc.IiPafBN3T4.'),
(8, 'Boca', 'Maria', 'aa', '1234567890', 'boca@yahoo.com', '$2y$10$dgzNUAXZWHIBn4Iz2M4jDeXwer.Hnyq.bZpQEK4Eu9jcpO.G.K/9S'),
(9, 'Tanase', 'Sebi', 'panade 1', '0765199729', 'flavius@gmail.com', '$2y$10$ooHK.k8mfsnKN0o86cDlQuMBqsjE0J4lCkbiWe1ukrHhdgmE/euVm'),
(10, 'Ioana', 'Anca', 'aa', '1234567890', 'bb@gmail.com', '$2y$10$wSrwsuw.mVYGCY0.CcXvxuSAuG3CGb4cORiCA4fJzyNV6bfOeoJpS'),
(12, 'Flavius', 'Tanase', 'panade', '0751118945', 'f@gmail.com', '$2y$10$tmfLvjM2zXUQRxh/.qKkS...gTsU53ThBCGBEef7A18wQgzwWsA3y');

-- --------------------------------------------------------

--
-- Table structure for table `comenzi`
--

CREATE TABLE `comenzi` (
  `id_comanda` int NOT NULL,
  `id_client` int NOT NULL,
  `id_angajat` int NOT NULL,
  `id_produs` int NOT NULL,
  `data_comanda` date NOT NULL,
  `valoare_totala` double NOT NULL,
  `cantitate` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comenzi`
--

INSERT INTO `comenzi` (`id_comanda`, `id_client`, `id_angajat`, `id_produs`, `data_comanda`, `valoare_totala`, `cantitate`) VALUES
(1, 1, 1, 1, '2019-05-15', 50, 10),
(2, 2, 2, 2, '2020-08-19', 800, 100),
(3, 3, 3, 3, '2022-12-20', 24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int NOT NULL,
  `nume` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `mesaj` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id_contact`, `nume`, `email`, `subject`, `mesaj`) VALUES
(1, 'Georgiana', 'georgymitca@gmail.com', 'web', 'Super'),
(2, 'Sebi', 'sebi@gmail.com', 'web', 'aaaaa'),
(3, 'Cristi', 'cristi@gmail.com', 'general', 'aa'),
(4, 'Georgi', 'georgymitca@gmail.com', 'general', 'aa'),
(5, 'AA', 'f@gmail.com', 'general', 'good');

-- --------------------------------------------------------

--
-- Table structure for table `facturi`
--

CREATE TABLE `facturi` (
  `id_factura` int NOT NULL,
  `id_comanda` int NOT NULL,
  `id_furnizor` int NOT NULL,
  `data_factura` date NOT NULL,
  `valoare_factura` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `facturi`
--

INSERT INTO `facturi` (`id_factura`, `id_comanda`, `id_furnizor`, `data_factura`, `valoare_factura`) VALUES
(1, 1, 1, '2019-11-13', 1260),
(2, 2, 2, '2021-03-16', 5600),
(3, 3, 3, '2021-02-15', 2350);

-- --------------------------------------------------------

--
-- Table structure for table `furnizori`
--

CREATE TABLE `furnizori` (
  `id_furnizor` int NOT NULL,
  `nume_furnizor` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `furnizori`
--

INSERT INTO `furnizori` (`id_furnizor`, `nume_furnizor`, `adresa`, `telefon`) VALUES
(1, 'tehys.srl', 'bradului 45', '0751118943'),
(2, 'doncafe.srl', 'cuza 78', '0234896513'),
(3, 'juliusmeinl.srl', 'racovita 98', '0289653490');

-- --------------------------------------------------------

--
-- Table structure for table `produse`
--

CREATE TABLE `produse` (
  `id_produs` int NOT NULL,
  `nume_produs` varchar(255) NOT NULL,
  `descriere` text NOT NULL,
  `pret_unitar` float NOT NULL,
  `imagine_produs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produse`
--

INSERT INTO `produse` (`id_produs`, `nume_produs`, `descriere`, `pret_unitar`, `imagine_produs`) VALUES
(1, 'Espresso Italian', 'Italian espresso is an art, it is the result of an old tradition. A cup of drink obtained by passing ground coffee under pressure with hot water. By definition, Italian espresso is born from the mixture of different types of coffee from different parts of the world, which combine to create a rich and incomparable aroma.', 5, 'italian.png'),
(2, 'Cappuccino', 'Cappuccino is a very popular drink that contains a simple mixture of espresso, boiled milk and milk foam.Cappuccino has been around for over 100 years and has been well known in Europe since the espresso machine appeared on the market. When preparing a cappuccino, you have the opportunity to choose the amount of added milk, foam or the desired amount of espresso. If you want to make your cappuccino even tastier, you can add a little grated chocolate or cinnamon on top of the milk foam.', 8, 'cappuccino.png'),
(3, ' Macchiato', 'Caffé macchiato, sometimes also called espresso macchiato, is a drink that contains coffee and a small amount of milk. \"Macchiato\" means \"marked\" or \"stained\", and in the case of macchiato coffee, this literally means espresso stained/marked with milk. Traditionally, it is made from an espresso and a small amount of milk. However, later the \"mark\" or \"spot\" came to refer to the milk foam that was put on top to show that the drink has a little milk in it, usually a teaspoon. In fact, macchiato coffee in Portuguese is called \"cafe pingado\" which means coffee with a splash of milk.', 12, 'macchiato.png'),
(4, 'Frappe', 'Frappe coffee is a cold drink made from instant coffee. This drink originates from Greece, where it became popular after the Second World War, when the idea of going out to the city to drink coffee began to take shape. The Caffee Frappe has crossed the borders of Greece and Cyprus, being now one of the most loved drinks in the world.', 15, 'frappe.png'),
(5, 'Latte', 'Caffé latte is a mixture of espresso with warm milk, easy to make at home and with a delicious taste. In the USA, the difference between latte and cappuccino is the amount of milk that is put in the coffee.', 9, 'latte.png');

-- --------------------------------------------------------

--
-- Table structure for table `rezervari`
--

CREATE TABLE `rezervari` (
  `id_rezervare` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_rezervarii` date NOT NULL,
  `ora_rezervarii` time NOT NULL,
  `nr_persoane` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rezervari`
--

INSERT INTO `rezervari` (`id_rezervare`, `email`, `data_rezervarii`, `ora_rezervarii`, `nr_persoane`) VALUES
(29, 'georgymitca@gmail.com', '2023-05-04', '11:45:00', 45),
(33, 'georgymitca@gmail.com', '2023-05-01', '01:43:00', 20),
(34, 'georgymitca@gmail.com', '2023-05-01', '01:43:00', 12),
(46, 'f@gmail.com', '2023-05-01', '03:44:00', 1),
(48, 'georgymitca@gmail.com', '2023-05-02', '17:13:00', 19);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v1`
-- (See below for the actual view)
--
CREATE TABLE `v1` (
`nume` varchar(255)
,`prenume` varchar(255)
,`data_comanda` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v2`
-- (See below for the actual view)
--
CREATE TABLE `v2` (
`nume` varchar(255)
,`prenume` varchar(255)
,`total_vanzari` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v3`
-- (See below for the actual view)
--
CREATE TABLE `v3` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v4`
-- (See below for the actual view)
--
CREATE TABLE `v4` (
`client` varchar(511)
,`data_comanda` date
,`valoare_totala` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v5`
-- (See below for the actual view)
--
CREATE TABLE `v5` (
`luna` varchar(7)
,`furnizor` varchar(255)
,`valoare_totala` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v6`
-- (See below for the actual view)
--
CREATE TABLE `v6` (
`luna` varchar(7)
,`numar_comenzi` bigint
,`valoare_totala` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v1`
--
DROP TABLE IF EXISTS `v1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v1`  AS SELECT `angajati`.`nume` AS `nume`, `angajati`.`prenume` AS `prenume`, `comenzi`.`data_comanda` AS `data_comanda` FROM (`angajati` join `comenzi` on((`angajati`.`id_angajat` = `comenzi`.`id_angajat`))) WHERE (`comenzi`.`data_comanda` between '2020-01-01' and '2023-01-01')  ;

-- --------------------------------------------------------

--
-- Structure for view `v2`
--
DROP TABLE IF EXISTS `v2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v2`  AS SELECT `angajati`.`nume` AS `nume`, `angajati`.`prenume` AS `prenume`, sum((`produse`.`pret_unitar` * `c`.`cantitate`)) AS `total_vanzari` FROM ((`angajati` join `comenzi` `c` on((`angajati`.`id_angajat` = `c`.`id_angajat`))) join `produse` on((`c`.`id_produs` = `produse`.`id_produs`))) WHERE (`c`.`data_comanda` between '2020-01-01' and '2023-01-01') GROUP BY `angajati`.`id_angajat` ORDER BY `total_vanzari` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v3`
--
DROP TABLE IF EXISTS `v3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v3`  AS SELECT count(0) AS `Numar rezervari` FROM (`rezervari` `a` join `clienti` `b` on((`a`.`id_client` = `b`.`id_client`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v4`
--
DROP TABLE IF EXISTS `v4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v4`  AS SELECT concat_ws(' ',`clienti`.`nume`,`clienti`.`prenume`) AS `client`, `c`.`data_comanda` AS `data_comanda`, `calculeaza_valoare_totala_comanda`(`c`.`id_comanda`) AS `valoare_totala` FROM ((`clienti` join `comenzi` `c` on((`clienti`.`id_client` = `c`.`id_client`))) join `comenzi` `c1` on((`c`.`id_comanda` = `c1`.`id_comanda`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v5`
--
DROP TABLE IF EXISTS `v5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v5`  AS SELECT date_format(`facturi`.`data_factura`,'%Y-%m') AS `luna`, `furnizori`.`nume_furnizor` AS `furnizor`, sum(`facturi`.`valoare_factura`) AS `valoare_totala` FROM (`facturi` join `furnizori` on((`facturi`.`id_furnizor` = `furnizori`.`id_furnizor`))) GROUP BY date_format(`facturi`.`data_factura`,'%Y-%m'), `furnizori`.`nume_furnizor``nume_furnizor`  ;

-- --------------------------------------------------------

--
-- Structure for view `v6`
--
DROP TABLE IF EXISTS `v6`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v6`  AS SELECT date_format(`comenzi`.`data_comanda`,'%Y-%m') AS `luna`, count(`comenzi`.`id_comanda`) AS `numar_comenzi`, sum(`calculeaza_valoare_totala_comanda`(`comenzi`.`id_comanda`)) AS `valoare_totala` FROM `comenzi` GROUP BY date_format(`comenzi`.`data_comanda`,'%Y-%m')  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angajati`
--
ALTER TABLE `angajati`
  ADD PRIMARY KEY (`id_angajat`);

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `fk_clienti_comenzi` (`id_client`),
  ADD KEY `fk_angajati_comenzi` (`id_angajat`),
  ADD KEY `FK_Comenzi_Produse` (`id_produs`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Indexes for table `facturi`
--
ALTER TABLE `facturi`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `fk_comenzi_facturi` (`id_comanda`),
  ADD KEY `fk_furnizori_facturi` (`id_furnizor`);

--
-- Indexes for table `furnizori`
--
ALTER TABLE `furnizori`
  ADD PRIMARY KEY (`id_furnizor`);

--
-- Indexes for table `produse`
--
ALTER TABLE `produse`
  ADD PRIMARY KEY (`id_produs`);

--
-- Indexes for table `rezervari`
--
ALTER TABLE `rezervari`
  ADD PRIMARY KEY (`id_rezervare`),
  ADD KEY `fk_rezervari` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angajati`
--
ALTER TABLE `angajati`
  MODIFY `id_angajat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clienti`
--
ALTER TABLE `clienti`
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comenzi`
--
ALTER TABLE `comenzi`
  MODIFY `id_comanda` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facturi`
--
ALTER TABLE `facturi`
  MODIFY `id_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `furnizori`
--
ALTER TABLE `furnizori`
  MODIFY `id_furnizor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produse`
--
ALTER TABLE `produse`
  MODIFY `id_produs` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rezervari`
--
ALTER TABLE `rezervari`
  MODIFY `id_rezervare` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD CONSTRAINT `fk_angajati_comenzi` FOREIGN KEY (`id_angajat`) REFERENCES `angajati` (`id_angajat`),
  ADD CONSTRAINT `fk_clienti_comenzi` FOREIGN KEY (`id_client`) REFERENCES `clienti` (`id_client`),
  ADD CONSTRAINT `FK_Comenzi_Produse` FOREIGN KEY (`id_produs`) REFERENCES `produse` (`id_produs`);

--
-- Constraints for table `facturi`
--
ALTER TABLE `facturi`
  ADD CONSTRAINT `fk_comenzi_facturi` FOREIGN KEY (`id_comanda`) REFERENCES `comenzi` (`id_comanda`),
  ADD CONSTRAINT `fk_furnizori_facturi` FOREIGN KEY (`id_furnizor`) REFERENCES `furnizori` (`id_furnizor`);

--
-- Constraints for table `rezervari`
--
ALTER TABLE `rezervari`
  ADD CONSTRAINT `fk_rezervari` FOREIGN KEY (`email`) REFERENCES `clienti` (`email`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
