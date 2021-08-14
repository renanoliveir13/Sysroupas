-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Ago-2021 às 20:07
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.3.22

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
(1, 'Itachi', '430.982.131-28', '(43) 8512-0728', 'itachi@akatsuki.com', 'Guanambi', 'Bairro 5', 'Rua 10', 55),
(2, 'Konan', '894.321.908-12', '(54) 0430-3922', 'konan@akatsuki.com', 'Guanambi', 'Bairro 7', 'Rua 15', 42);

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
(1, 'Camiseta de fio 30.1', 'Camiseta', 'John John', '0-437523-909428', 'Vermelha', 'M', 'M', 30, '11.43', 50, '17.15', '2021-08-14 13:56:28'),
(2, 'Bermuda de fio 30.1', 'Bermuda', 'TOMMY HILFIGER', '5-409728-362137', 'Cinza', 'M', 'M', 31, '9.87', 80, '17.77', '2021-08-14 14:08:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `devolucao`
--

CREATE TABLE `devolucao` (
  `cd_devolucao` int(11) NOT NULL,
  `data_devolucao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada`
--

CREATE TABLE `entrada` (
  `cd_entrada` int(11) NOT NULL,
  `cd_funcionario` int(11) NOT NULL,
  `cd_fornecedor` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT '''Pagamento á vista''',
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `entrada`
--

INSERT INTO `entrada` (`cd_entrada`, `cd_funcionario`, `cd_fornecedor`, `descricao`, `data_venda`) VALUES
(1, 3, 2, 'Teste de nota', '2021-08-14 17:52:02');

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
(1, 'Trapos PHP', '54.793.082/8281-21', '(58) 7213-9018', 'trapos_php@gmail.com', 'BA', 'Guanambi', 'Bairro Web', 'Rua Hash', 81),
(2, 'Chacal Roupas', '54.964.092/1381-20', '(30) 2974-2309', 'chacal.roupas@gmail.com', 'MG', 'Uma cidade ai', 'Uma bairro ai', 'Uma rua ai', 47);

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
(1, 'Fábio', 'Administrador', '111.111.111-11', '(12) 3323-1894', 'professor@professor.com.br', '$2y$10$VcurDOdGNECBG/cNTFXLQOEl54Nu1WWwiGlCGtk4LHwd.C0Batigq'),
(2, 'Uenio Viana', 'Administrador', '222.222.222-22', '(24) 1823-1720', 'ueniomlh@gmail.com', '$2y$10$u/Sv5fj0VceLJ7ZMnOBbDucrusinrtbIQ.s2HnZaKUBJHgJHJDCMm'),
(3, 'Simon Belmont', 'Administrador', '333.333.333-33', '(90) 5872-0912', 'belmont@castlevania.com', '$2y$10$JCm0f9y8BpgsMSlJDvBQruMtZ9MY6zdKeqbgY1r/qC2imFJHwkgGG'),
(4, 'Convidado 1', 'Atendente', '430.982.392-31', '(39) 2484-3523', 'convidado1@convidado.com', '$2y$10$7M51CkLm8QlpGd9qWUYFn.Lqdp6dt13shNQBNb.usegQHR.EanAbe');

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
(1, 1, 2, '9.87', 80, 1, '2021-08-14 17:52:52');

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
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cd_cliente`);

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
  ADD KEY `cd_fornecedor` (`cd_fornecedor`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`cd_fornecedor`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`cd_funcionario`);

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
  ADD KEY `cd_entrada` (`cd_entrada`),
  ADD KEY `cd_produto` (`cd_produto`);

--
-- Índices para tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  ADD PRIMARY KEY (`cd_produto_venda`),
  ADD KEY `cd_venda` (`cd_venda`),
  ADD KEY `cd_produto` (`cd_produto`);

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
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `compra_produto`
--
ALTER TABLE `compra_produto`
  MODIFY `cd_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `devolucao`
--
ALTER TABLE `devolucao`
  MODIFY `cd_devolucao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `cd_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `cd_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `cd_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos_devolucao`
--
ALTER TABLE `produtos_devolucao`
  MODIFY `cd_produto_devolucao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos_entrada`
--
ALTER TABLE `produtos_entrada`
  MODIFY `cd_produto_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  MODIFY `cd_produto_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `cd_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`cd_funcionario`) REFERENCES `funcionario` (`cd_funcionario`),
  ADD CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`cd_fornecedor`) REFERENCES `fornecedor` (`cd_fornecedor`);

--
-- Limitadores para a tabela `produtos_devolucao`
--
ALTER TABLE `produtos_devolucao`
  ADD CONSTRAINT `produtos_devolucao_ibfk_1` FOREIGN KEY (`cd_devolucao`) REFERENCES `devolucao` (`cd_devolucao`),
  ADD CONSTRAINT `produtos_devolucao_ibfk_2` FOREIGN KEY (`cd_produto_venda`) REFERENCES `produtos_venda` (`cd_produto_venda`),
  ADD CONSTRAINT `produtos_devolucao_ibfk_3` FOREIGN KEY (`cd_produto`) REFERENCES `compra_produto` (`cd_produto`);

--
-- Limitadores para a tabela `produtos_entrada`
--
ALTER TABLE `produtos_entrada`
  ADD CONSTRAINT `produtos_entrada_ibfk_1` FOREIGN KEY (`cd_entrada`) REFERENCES `entrada` (`cd_entrada`),
  ADD CONSTRAINT `produtos_entrada_ibfk_2` FOREIGN KEY (`cd_produto`) REFERENCES `compra_produto` (`cd_produto`);

--
-- Limitadores para a tabela `produtos_venda`
--
ALTER TABLE `produtos_venda`
  ADD CONSTRAINT `produtos_venda_ibfk_1` FOREIGN KEY (`cd_venda`) REFERENCES `venda` (`cd_venda`),
  ADD CONSTRAINT `produtos_venda_ibfk_2` FOREIGN KEY (`cd_produto`) REFERENCES `compra_produto` (`cd_produto`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`cd_funcionario`) REFERENCES `funcionario` (`cd_funcionario`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`cd_cliente`) REFERENCES `cliente` (`cd_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
