-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Ago-2021 às 04:45
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `web`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cd_cliente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` char(14) NOT NULL,
  `telefone` char(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cd_cliente`, `nome`, `cpf`, `telefone`, `email`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'Banana', '666.666.666-66', '(98) 9831-5515', 'banana@gmail.com', 'SANTA', 'saddsa', 'zzzz', 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra_produto`
--

CREATE TABLE `compra_produto` (
  `cd_produto` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `tipo` varchar(191) DEFAULT NULL,
  `marca` varchar(30) NOT NULL,
  `codigo_barra` char(15) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `tamanho` varchar(2) NOT NULL,
  `genero` char(1) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_compra` decimal(7,2) NOT NULL,
  `porcentagem_revenda` int(11) NOT NULL,
  `valor_revenda` decimal(7,2) NOT NULL,
  `data_compra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `compra_produto`
--

INSERT INTO `compra_produto` (`cd_produto`, `nome`, `tipo`, `marca`, `codigo_barra`, `cor`, `tamanho`, `genero`, `quantidade`, `valor_compra`, `porcentagem_revenda`, `valor_revenda`, `data_compra`) VALUES
(1, 'Camiseta', NULL, 'Polo Ralph Lauren', '1-213123-233232', 'Vinho', 'GG', 'M', 20, '50.00', 10, '55.00', '2021-08-07 23:42:56'),
(10, 'Calça', NULL, 'TOMMY HILFIGER', '5-555555-555555', 'Amarela', 'M', 'M', 14, '100.00', 10, '110.00', '2021-08-08 05:20:26'),
(11, 'Camiseta Listrada', 'Jaqueta', 'Lacoste', '4-544545-545454', 'Preta', 'P', 'M', 4, '15.00', 5, '15.75', '2021-08-11 17:04:58'),
(12, 'sadsaddasdsa', 'Camiseta', 'Lacoste', '1-421421-321442', 'Preta', 'P', 'M', 6, '100.00', 70, '170.00', '2021-08-12 04:15:38'),
(13, 'Baianinha', 'Calça', 'Hollister', '2-144214-242121', 'Branca', 'M', 'M', 18, '100.00', 10, '110.00', '2021-08-12 04:37:13'),
(16, 'RELOGIO TOP', 'Bermuda', 'Polo Ralph Lauren', '2-142144-142124', 'Preta', 'P', 'M', 16, '120.00', 20, '144.00', '2021-08-13 13:27:23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `devolucao`
--

CREATE TABLE `devolucao` (
  `cd_devolucao` int(11) NOT NULL,
  `data_devolucao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `devolucao`
--

INSERT INTO `devolucao` (`cd_devolucao`, `data_devolucao`) VALUES
(2, '2021-08-11 23:48:18'),
(3, '2021-08-12 06:58:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada`
--

CREATE TABLE `entrada` (
  `cd_entrada` int(11) NOT NULL,
  `cd_funcionario` int(11) NOT NULL,
  `cd_fornecedor` int(11) NOT NULL,
  `descricao` text DEFAULT 'Pagamento á vista',
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `entrada`
--

INSERT INTO `entrada` (`cd_entrada`, `cd_funcionario`, `cd_fornecedor`, `descricao`, `data_venda`) VALUES
(1, 1, 2, 'Compra de varias calçasxxxxxxx', '2021-08-13 06:40:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `cd_fornecedor` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cnpj` char(18) NOT NULL,
  `telefone` char(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `endereco` varchar(30) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`cd_fornecedor`, `nome`, `cnpj`, `telefone`, `email`, `estado`, `cidade`, `bairro`, `endereco`, `numero`) VALUES
(1, 'Chacal Roupasxz', '54.920.182/0820-94', '(45) 0218-3210', 'chacal.roupas@gmail.com', 'MA', 'Guanambi ', 'Bairro 64', 'Rua 42', 999),
(2, 'Calças Bahia', '57.309.242/7321-03', '(45) 0218-321', 'calcas.bahia@gmail.com', '', 'Cidade 5', 'Bairro 8', 'Rua 19', 5473),
(3, 'Oestex', '56.789.033/3221-11', '(77) 8143-4367', 'oeste@gothan.com', '', 'pindaiba', 'centro', 'rua do fundo', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `cd_funcionario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `cpf` char(14) NOT NULL,
  `telefone` char(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`cd_funcionario`, `nome`, `cargo`, `cpf`, `telefone`, `email`, `senha`) VALUES
(1, 'Batman', 'Atendente', '600.296.303-04', '(98) 9831-5515', 'batman@hotmail.com', '$2y$10$kGFrFur6va3conCH8ellT.U.c9ULdBs7BKUSu1xd.y4roNkTDV2m6'),
(2, 'Professor FabioX', 'Administrador', '222.222.222-22', '(90) 5426-1853', 'professor@professor.com.br', '$2y$10$XIlHAanq1KTwRm0jkV8AjuW.J37kf/ZExaQBNnWbrznDy2rrJZRRy'),
(3, 'Uenio Viana', 'Administrador', '333.333.333-33', '(06) 2731-8561', 'ueniomlh@gmail.com', '$2y$10$nxL9KhU7sIK7zGEHqS12gOQM792kge4MFb5unm62qi1dmIM/J8bsW');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_devolucao`
--

CREATE TABLE `produtos_devolucao` (
  `cd_produto_devolucao` int(11) NOT NULL,
  `cd_devolucao` int(11) NOT NULL,
  `cd_produto_venda` int(11) NOT NULL,
  `cd_produto` int(11) NOT NULL,
  `valor_item` decimal(7,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_devolucao` decimal(7,2) NOT NULL,
  `motivo_devolucao` varchar(50) NOT NULL,
  `data_devolucao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos_devolucao`
--

INSERT INTO `produtos_devolucao` (`cd_produto_devolucao`, `cd_devolucao`, `cd_produto_venda`, `cd_produto`, `valor_item`, `quantidade`, `valor_devolucao`, `motivo_devolucao`, `data_devolucao`) VALUES
(1, 3, 2, 11, '15.75', 1, '15.75', 'Tamanho errado', '2021-08-12 06:58:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_entrada`
--

CREATE TABLE `produtos_entrada` (
  `cd_produto_entrada` int(11) NOT NULL,
  `cd_entrada` int(11) NOT NULL,
  `cd_produto` int(11) NOT NULL,
  `valor_item` decimal(7,2) NOT NULL,
  `porcentagem_revenda` int(11) NOT NULL DEFAULT 0,
  `quantidade` int(11) NOT NULL,
  `data_entrada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos_entrada`
--

INSERT INTO `produtos_entrada` (`cd_produto_entrada`, `cd_entrada`, `cd_produto`, `valor_item`, `porcentagem_revenda`, `quantidade`, `data_entrada`) VALUES
(1, 1, 1, '50.00', 10, 1, '2021-08-14 02:43:11'),
(2, 1, 1, '50.00', 10, 3, '2021-08-14 02:44:33'),
(3, 1, 1, '50.00', 10, 8, '2021-08-14 02:44:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_venda`
--

CREATE TABLE `produtos_venda` (
  `cd_produto_venda` int(11) NOT NULL,
  `cd_venda` int(11) NOT NULL,
  `cd_produto` int(11) NOT NULL,
  `valor_item` decimal(7,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_venda` decimal(7,2) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos_venda`
--

INSERT INTO `produtos_venda` (`cd_produto_venda`, `cd_venda`, `cd_produto`, `valor_item`, `quantidade`, `valor_venda`, `data_venda`) VALUES
(7, 4, 10, '110.00', 1, '110.00', '2021-08-13 04:46:18'),
(10, 5, 1, '55.00', 1, '55.00', '2021-08-13 05:06:21'),
(12, 7, 1, '55.00', 1, '55.00', '2021-08-14 01:48:09'),
(13, 7, 12, '170.00', 1, '170.00', '2021-08-14 01:48:09'),
(16, 10, 11, '15.75', 3, '47.25', '2021-08-14 01:56:56'),
(17, 10, 13, '110.00', 1, '110.00', '2021-08-14 01:56:56'),
(29, 19, 1, '55.00', 1, '55.00', '2021-08-14 02:18:59'),
(30, 19, 11, '15.75', 1, '15.75', '2021-08-14 02:18:59'),
(31, 19, 12, '170.00', 1, '170.00', '2021-08-14 02:18:59'),
(34, 19, 12, '170.00', 1, '170.00', '2021-08-14 02:25:25'),
(39, 24, 10, '110.00', 1, '110.00', '2021-08-14 02:29:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `cd_venda` int(11) NOT NULL,
  `cd_funcionario` int(11) NOT NULL,
  `cd_cliente` int(11) NOT NULL,
  `tipo_pagamento` varchar(30) NOT NULL DEFAULT 'Pagamento á vista',
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`cd_venda`, `cd_funcionario`, `cd_cliente`, `tipo_pagamento`, `data_venda`) VALUES
(1, 1, 1, 'Pagamento á vista', '2021-08-12 06:50:42'),
(2, 1, 1, 'Pagamento á vista', '2021-08-13 02:37:22'),
(3, 1, 1, 'Pagamento á vista', '2021-08-13 03:57:28'),
(4, 1, 1, 'Pagamento á vista', '2021-08-13 04:46:18'),
(5, 1, 1, 'Pagamento á vista', '2021-08-13 05:06:21'),
(7, 1, 1, 'Pagamento á vista', '2021-08-14 01:48:09'),
(10, 1, 1, 'Pagamento á vista', '2021-08-14 01:56:56'),
(19, 1, 1, 'Pagamento á vista', '2021-08-14 02:18:59'),
(24, 1, 1, 'Pagamento á vista', '2021-08-14 02:29:03');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cd_cliente`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `compra_produto`
--
ALTER TABLE `compra_produto`
  ADD PRIMARY KEY (`cd_produto`);

--
-- Índices para tabela `devolucao`
--
ALTER TABLE `devolucao`
  ADD PRIMARY KEY (`cd_devolucao`);

--
-- Índices para tabela `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`cd_entrada`),
  ADD KEY `cd_funcionario` (`cd_funcionario`),
  ADD KEY `cd_cliente` (`cd_fornecedor`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`cd_fornecedor`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`cd_funcionario`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `produtos_devolucao`
--
ALTER TABLE `produtos_devolucao`
  ADD PRIMARY KEY (`cd_produto_devolucao`),
  ADD KEY `cd_devolucao` (`cd_devolucao`),
  ADD KEY `cd_produto_venda` (`cd_produto_venda`),
  ADD KEY `cd_produto` (`cd_produto`);

--
-- Índices para tabela `produtos_entrada`
--
ALTER TABLE `produtos_entrada`
  ADD PRIMARY KEY (`cd_produto_entrada`),
  ADD KEY `cd_produto` (`cd_produto`),
  ADD KEY `cd_entrada` (`cd_entrada`);

--
-- Índices para tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  ADD PRIMARY KEY (`cd_produto_venda`),
  ADD KEY `cd_produto` (`cd_produto`),
  ADD KEY `cd_venda` (`cd_venda`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`cd_venda`),
  ADD KEY `cd_funcionario` (`cd_funcionario`),
  ADD KEY `cd_cliente` (`cd_cliente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `compra_produto`
--
ALTER TABLE `compra_produto`
  MODIFY `cd_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `devolucao`
--
ALTER TABLE `devolucao`
  MODIFY `cd_devolucao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `cd_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `cd_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `cd_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos_devolucao`
--
ALTER TABLE `produtos_devolucao`
  MODIFY `cd_produto_devolucao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos_entrada`
--
ALTER TABLE `produtos_entrada`
  MODIFY `cd_produto_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  MODIFY `cd_produto_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `cd_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  ADD CONSTRAINT `produtos_venda_ibfk_1` FOREIGN KEY (`cd_produto`) REFERENCES `compra_produto` (`cd_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
