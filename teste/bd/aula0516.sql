-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Maio-2023 às 23:41
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aula0516`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `salvar_categoria` (IN `var_id` INT, `var_nome` VARCHAR(50), `var_cor` VARCHAR(15), `var_descricao` VARCHAR(200))   BEGIN
  IF (EXISTS(SELECT id_cat FROM categoria WHERE id_cat = var_id)) THEN
    UPDATE categoria SET nome_cat = var_nome, cor_cat = var_cor, descricao_cat = var_descricao WHERE id_cat = var_id;
  ELSE
    INSERT INTO categoria VALUES (null, var_nome, var_cor, var_descricao);
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `salvar_evento` (IN `var_id` INT, `var_nome` VARCHAR(50), `var_data` DATE, `var_local` VARCHAR(60), `var_limite` INT, `var_id_cat` INT, `var_id_int` INT)   BEGIN
  IF (EXISTS(SELECT id_eve FROM evento WHERE id_eve = var_id)) THEN
    UPDATE evento SET nome_eve = var_nome, data_eve = var_data, local_eve = var_local,
                    limite_eve = var_limite, id_cat = var_id_cat, id_int = var_id_int  WHERE id_eve = var_id;
  ELSE
    INSERT INTO evento VALUES (null, var_nome, var_data,var_local, var_limite, var_id_cat, var_id_int);
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `salvar_ingresso` (IN `var_id` INT, `var_tipo` VARCHAR(50), `var_preco` DOUBLE(10,2), `var_id_usu` INT, `var_id_eve` INT)   BEGIN
  IF (EXISTS(SELECT id_ing FROM ingresso WHERE id_ing = var_id)) THEN
    UPDATE ingresso SET tipo_ing = var_tipo, preco_ing = var_preco, id_usu = var_id_usu, id_eve = var_id_eve WHERE id_ing = var_id;
  ELSE
    INSERT INTO ingresso VALUES (null, var_tipo, var_preco, var_id_usu, var_id_eve);
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `salvar_integrante` (IN `var_id` INT, `var_personagem` VARCHAR(50), `var_nome` VARCHAR(50), `var_data` DATE, `var_cpf` VARCHAR(11))   BEGIN
  IF (EXISTS(SELECT id_int FROM integrante WHERE id_int = var_id)) THEN
    UPDATE integrante SET personagem_int = var_personagem, nome_int = var_nome, data_int = var_data, cpf_int = var_cpf WHERE id_int = var_id;
  ELSE
    INSERT INTO integrante VALUES (null, var_personagem, var_nome, var_data, var_cpf);
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `salvar_usuario` (IN `var_id` INT, `var_cpf` VARCHAR(11), `var_nome` VARCHAR(50), `var_dataNasc` DATE)   BEGIN
  IF (EXISTS(SELECT id_usu FROM usuario WHERE id_usu = var_id)) THEN
    UPDATE usuario SET cpf_usu = var_cpf, nome_usu = var_nome, dataNasc_usu = var_dataNasc WHERE id_usu = var_id;
  ELSE
    INSERT INTO usuario VALUES (null, var_cpf, var_nome, var_dataNasc);
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_cat` int(11) NOT NULL,
  `nome_cat` varchar(80) DEFAULT NULL,
  `cor_cat` varchar(15) DEFAULT NULL,
  `descricao_cat` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_cat`, `nome_cat`, `cor_cat`, `descricao_cat`) VALUES
(1, 'Terror', 'preto', NULL),
(2, 'Terror', 'preto', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id_eve` int(11) NOT NULL,
  `nome_eve` varchar(50) DEFAULT NULL,
  `data_eve` date DEFAULT NULL,
  `local_eve` varchar(60) DEFAULT NULL,
  `limite_eve` int(11) DEFAULT NULL CHECK (`limite_eve` >= 0),
  `id_cat` int(11) NOT NULL,
  `id_int` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`id_eve`, `nome_eve`, `data_eve`, `local_eve`, `limite_eve`, `id_cat`, `id_int`) VALUES
(1, 'A calça do terror', '0000-00-00', 'Indaiaclube', 68, 1, 1),
(2, 'A calça do terror', '0000-00-00', 'Indaiaclube', 68, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ingresso`
--

CREATE TABLE `ingresso` (
  `id_ing` int(11) DEFAULT NULL,
  `tipo_ing` varchar(50) DEFAULT NULL,
  `preco_ing` double(10,2) DEFAULT NULL,
  `id_usu` int(11) NOT NULL,
  `id_eve` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ingresso`
--

INSERT INTO `ingresso` (`id_ing`, `tipo_ing`, `preco_ing`, `id_usu`, `id_eve`) VALUES
(NULL, 'Meia', 85.00, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `integrante`
--

CREATE TABLE `integrante` (
  `id_int` int(11) NOT NULL,
  `personagem_int` varchar(50) DEFAULT NULL,
  `nome_int` varchar(50) DEFAULT NULL,
  `data_int` date DEFAULT NULL,
  `cpf_int` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `integrante`
--

INSERT INTO `integrante` (`id_int`, `personagem_int`, `nome_int`, `data_int`, `cpf_int`) VALUES
(1, 'Arvore', 'Maria', '0000-00-00', '12345678906'),
(2, 'Arvore', 'Maria', '0000-00-00', '12345678906');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usu` int(11) NOT NULL,
  `cpf_usu` varchar(11) DEFAULT NULL,
  `nome_usu` varchar(50) DEFAULT NULL,
  `dataNasc_usu` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usu`, `cpf_usu`, `nome_usu`, `dataNasc_usu`) VALUES
(1, '12345678901', 'Dorate', '0000-00-00'),
(3, '12345678902', 'Alice', '0000-00-00'),
(5, '12345678907', 'Alice', '0000-00-00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_cat`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_eve`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_int` (`id_int`);

--
-- Índices para tabela `ingresso`
--
ALTER TABLE `ingresso`
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_eve` (`id_eve`);

--
-- Índices para tabela `integrante`
--
ALTER TABLE `integrante`
  ADD PRIMARY KEY (`id_int`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `cpf_usu` (`cpf_usu`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id_eve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `integrante`
--
ALTER TABLE `integrante`
  MODIFY `id_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`id_int`) REFERENCES `integrante` (`id_int`);

--
-- Limitadores para a tabela `ingresso`
--
ALTER TABLE `ingresso`
  ADD CONSTRAINT `ingresso_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`),
  ADD CONSTRAINT `ingresso_ibfk_2` FOREIGN KEY (`id_eve`) REFERENCES `evento` (`id_eve`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
