-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/09/2026 às 17:48
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `3c_lojavirtual`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `descricao`, `data_cadastro`, `quantidade`, `foto`) VALUES
(16, 'Monitor LG 24\"', 576.00, 'Monitor Gamer LG 24MS500-B 24ms Ips Fullhd 100hz Ajuste de Inclinação Negro', '2026-09-16 17:24:47', 50, 'eaf240aef6dfedc022bbf455a6893d11.webp'),
(17, 'Teclado Mecanico', 64.90, 'TECLADO MECÂNICO GAMER RISE MODE NOVA 02, RGB, USB, SWITCH RISE CORE, 60%, PRETO', '2026-09-16 17:26:21', 55, '6c7920d0b08620fb56e6951cc8211329.webp'),
(18, ' Notebook Dell Latitude 3410', 2000.23, 'Notebook Dell Latitude 3410 Core i5 décima geração 16gb ram 240gb ssd cor cinza - Bom (Recondicionado)\r\nNotebook Dell Latitude 3410 Core i5 décima geração 16gb ram 240gb ssd cor cinza - Bom (Recondicionado)\r\nNotebook Dell Latitude 3410 Core i5 décima geração 16gb ram 240gb ssd cor cinza - Bom (Recondicionado)\r\nRecondicionado  |  +100 vendidos\r\nNotebook Dell Latitude 3410 Core i5 décima geração 16gb ram 240gb ssd cor cinza - Bom (Recondicionado)', '2026-09-16 19:07:09', 10, 'f6570b913ea4d50d4c5bf26e5d62b091.webp'),
(23, 'Cadeira Lite', 499.50, 'A LITE é uma cadeira que torna a qualidade e garantia Flexform acessível para qualquer tipo de ambiente e para se adaptar a qualquer jeito de trabalhar.', '2026-09-16 19:13:16', 10, '05ff0885170ec210c22647c1d64287e1.webp'),
(29, 'ss', 2.00, '', '2026-09-18 01:32:17', 3, '07616763d67dd9c6e0cf3630560e6a84.jpeg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(6, 'Davi Tavares de Siqueira', 'dvt.siqueira@gmail.com', '$2y$10$l5DjJdNFJfxi9BAHon0E/O.3n0LoOqF0.7XCH6DzXhYOj0XspZzlC');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
