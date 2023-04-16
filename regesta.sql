-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 16, 2023 alle 21:56
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `regesta`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `code` int(1) NOT NULL,
  `request` int(2) NOT NULL,
  `discount` int(11) NOT NULL
) ;

--
-- Dump dei dati per la tabella `discounts`
--

INSERT INTO `discounts` (`id`, `product`, `code`, `request`, `discount`) VALUES
(1, 1, 1, 5, 5),
(2, 2, 3, 4, 20);

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `supplier` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `model`, `supplier`, `price`) VALUES
(1, 'radio', 'BRAVIA', 6, 4),
(2, 'radio', 'BRAVIA', 5, 555.6),
(3, 'radio', 'BRAVIA', 1, 1000000);

-- --------------------------------------------------------

--
-- Struttura della tabella `restock`
--

CREATE TABLE `restock` (
  `id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `next` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `restock`
--

INSERT INTO `restock` (`id`, `stock`, `amount`, `next`) VALUES
(1, 1, 3, '2023-05-03');

-- --------------------------------------------------------

--
-- Struttura della tabella `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `stock`
--

INSERT INTO `stock` (`id`, `product`, `amount`) VALUES
(1, 1, 10),
(2, 2, 7),
(3, 3, 40);

-- --------------------------------------------------------

--
-- Struttura della tabella `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `delivery` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `delivery`) VALUES
(1, 'A', 3),
(5, 'B', 7),
(6, 'C', 5);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto` (`product`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produttore_2` (`supplier`);

--
-- Indici per le tabelle `restock`
--
ALTER TABLE `restock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock` (`stock`);

--
-- Indici per le tabelle `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto` (`product`),
  ADD KEY `prodotto_2` (`product`);

--
-- Indici per le tabelle `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `restock`
--
ALTER TABLE `restock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`);

--
-- Limiti per la tabella `restock`
--
ALTER TABLE `restock`
  ADD CONSTRAINT `restock_ibfk_1` FOREIGN KEY (`stock`) REFERENCES `stock` (`id`);

--
-- Limiti per la tabella `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
