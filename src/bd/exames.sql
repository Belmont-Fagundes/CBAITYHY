-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jun-2025 às 05:17
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `empresa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `exames`
--

CREATE TABLE `exames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unidade` varchar(100) DEFAULT NULL,
  `paciente` varchar(100) DEFAULT NULL,
  `pac_id` varchar(50) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `sexo` char(100) DEFAULT NULL,
  `modalidade` varchar(50) DEFAULT NULL,
  `exame` varchar(100) DEFAULT NULL,
  `data_estudo` date DEFAULT NULL,
  `medico` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `sla` int(11) DEFAULT NULL,
  `acoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `exames`
--

INSERT INTO `exames` (`id`, `unidade`, `paciente`, `pac_id`, `idade`, `sexo`, `modalidade`, `exame`, `data_estudo`, `medico`, `status`, `sla`, `acoes`) VALUES
(1, 'Unidade A', 'João da Silva', '0009703828', 45, 'M', 'RM', 'Crânio', '2025-06-03', 'Dr. Marcos Lima', 'Pendente', 24, 'Imagens: teste1, teste2, image-00000');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
