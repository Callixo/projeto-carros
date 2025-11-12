-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 05/11/2025 às 23:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_web`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `acao` varchar(255) NOT NULL,
  `data_hora` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `logs`
--

INSERT INTO `logs` (`id`, `id_usuario`, `acao`, `data_hora`) VALUES
(1, 1, 'Login 2FA bem-sucedido com a pergunta \'nascimento\'.', '2025-10-27 14:00:04'),
(2, 1, 'Login 2FA bem-sucedido com a pergunta \'cep\'.', '2025-10-27 14:06:08'),
(3, 1, 'Login 2FA bem-sucedido com a pergunta \'cep\'.', '2025-10-27 14:08:08'),
(4, 1, 'Login 2FA bem-sucedido com a pergunta \'nascimento\'.', '2025-10-27 14:26:58'),
(5, 1, 'Login 2FA bem-sucedido com a pergunta \'nascimento\'.', '2025-10-27 14:28:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_seguranca`
--

CREATE TABLE `respostas_seguranca` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `pergunta` varchar(255) NOT NULL,
  `resposta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_seguranca`
--

INSERT INTO `respostas_seguranca` (`id`, `id_usuario`, `pergunta`, `resposta`) VALUES
(1, 1, 'pet', '$2y$10$Sxb1EWRII7JNC7MEO4IWO.popruXnuHF31yq520MXdJyNsRSi/2yO'),
(2, 1, 'nascimento', '$2y$10$rqRgpXiIUel4lTj0Yl7HHOM9zFjEJRHofhxFOY0Aox05SIqcYneI2'),
(3, 1, 'cep', '$2y$10$stGiuEOGVlyUs7WabH2CZOhh.mgzpXFF4yve4E62goa8jfhLJRDFu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(80) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `nome_materno` varchar(80) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone_celular` varchar(20) NOT NULL,
  `telefone_fixo` varchar(20) NOT NULL,
  `endereco_completo` varchar(255) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('comum','master') NOT NULL DEFAULT 'comum',
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_completo`, `data_nascimento`, `sexo`, `nome_materno`, `cpf`, `telefone_celular`, `telefone_fixo`, `endereco_completo`, `login`, `senha`, `perfil`, `data_cadastro`, `ativo`) VALUES
(1, 'renato santos calixto machado', '2001-12-18', 'Masculino', 'nilzete machado', '192.147.877-27', '(+55)21-969464013', '(+55)21-69464013', 'rua valdir pequeno de melo 185', 'renatocalixto', '$2y$10$wvTXxOoRunoc3C2ZYsHpfeI79moynFUSMexaFD9/L099rnWTVSTSm', 'master', '2025-10-27 13:53:43', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `respostas_seguranca`
--
ALTER TABLE `respostas_seguranca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `respostas_seguranca`
--
ALTER TABLE `respostas_seguranca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas_seguranca`
--
ALTER TABLE `respostas_seguranca`
  ADD CONSTRAINT `respostas_seguranca_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
