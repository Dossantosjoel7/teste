-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 09, 2023 at 10:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_hotelhome`
--
CREATE DATABASE IF NOT EXISTS `bd_hotelhome` DEFAULT CHARACTER SET utf16 COLLATE utf16_unicode_ci;
USE `bd_hotelhome`;

-- --------------------------------------------------------

--
-- Table structure for table `acesso`
--

CREATE TABLE `acesso` (
  `id` int(11) NOT NULL,
  `entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `saida` timestamp NOT NULL DEFAULT current_timestamp(),
  `nome_acesso` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `acesso`
--

INSERT INTO `acesso` (`id`, `entrada`, `saida`, `nome_acesso`) VALUES
(2, '2023-06-19 23:21:26', '2023-06-13 16:01:37', 'Admin'),
(8, '2023-06-19 23:20:18', '2023-06-19 23:23:31', 'User Joel');

-- --------------------------------------------------------

--
-- Table structure for table `acomadacao`
--

CREATE TABLE `acomadacao` (
  `id` int(11) NOT NULL,
  `icone` varchar(100) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `acomadacao`
--

INSERT INTO `acomadacao` (`id`, `icone`, `nome`, `descricao`) VALUES
(7, 'IMG_95744.svg', 'Climatizador(AC)', 'Os nossos quartos possuem um sistema de climatizaÃ§Ã£o ao seu dispor'),
(8, 'IMG_18189.svg', 'LigaÃ§Ãµes TelefÃ³nicas', 'Dispomos LigaÃ§Ãµes TelefÃ³nicas, seja nacional ou internacional, contacte a nossa recepÃ§Ã£o para saber mais'),
(9, 'IMG_49589.svg', 'Restaurante', 'Temos um Restaurante,para casos de almoÃ§o,pequeno-almoÃ§o e jantar.'),
(10, 'IMG_92218.svg', 'Tv a cabo', 'Temos disponÃ­vel TV a cabo sobre 24 horas, com diversos canais desde comunicaÃ§Ã£o, entretenimento, etc.'),
(11, 'IMG_96098.svg', 'Lava-Roupa', 'Temos uma lavandaria ao seu dispor, contacte a recepÃ§Ã£o para saber mais'),
(12, 'IMG_74642.svg', 'Wi-Fi', 'Temos internet via satÃ©lite, disponÃ­vel sobre 24 horas, para o acesso fale com a RecepÃ§Ã£o');

-- --------------------------------------------------------

--
-- Table structure for table `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `caracteristicas`
--

INSERT INTO `caracteristicas` (`id`, `nome`) VALUES
(9, 'WC Externo'),
(12, 'WC Interno'),
(13, '1 cama'),
(14, '1 sofa'),
(15, '1 cama de reserva');

-- --------------------------------------------------------

--
-- Table structure for table `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id_confg` int(11) NOT NULL,
  `site_titulo` varchar(50) NOT NULL,
  `site_sobre` varchar(332) NOT NULL,
  `Desligado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `configuracoes`
--

INSERT INTO `configuracoes` (`id_confg`, `site_titulo`, `site_sobre`, `Desligado`) VALUES
(1, 'Hotel HOME', 'Venha para o nosso hotel e desfrute de uma experiÃªncia Ãºnica! Aqui vocÃª encontra quartos ao preÃ§o acessÃ­vel, nossa equipe de atendimento ao cliente estÃ¡ sempre pronta para ajudar e garantir que sua estadia seja inesquecÃ­vel.  AlÃ©m disso, oferecemos uma variedade de serviÃ§os, como restaurante, wifi, e muito mais.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `email`, `tel`, `user`) VALUES
(1, 'admin@admin.com', '244', 1),
(16, 'dossantosjoel7@gmail.com', '915501500', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contactos_detalhes`
--

CREATE TABLE `contactos_detalhes` (
  `id_cont` int(11) NOT NULL,
  `endereco` varchar(132) NOT NULL,
  `gmap` varchar(132) NOT NULL,
  `pn1` varchar(30) NOT NULL,
  `pn2` varchar(30) NOT NULL,
  `email` varchar(132) NOT NULL,
  `fb` varchar(132) NOT NULL,
  `insta` varchar(132) NOT NULL,
  `wt` varchar(132) NOT NULL,
  `iframe` varchar(332) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `contactos_detalhes`
--

INSERT INTO `contactos_detalhes` (`id_cont`, `endereco`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `wt`, `iframe`) VALUES
(1, 'Avenida 21 de Janeiro , Cassequel de LourenÃ§o, Rua 11, casa NÂº150, Luanda-Angola', 'https://goo.gl/maps/w53aJ45CyGMBvm2R9', '+244 915501500', '+244 924467806', 'dossantosjoel7@gmail.com', 'https://www.facebook.com/hermanbook.book.5', 'https://api.whatsapp.com/send/?phone=244915501500', 'https://api.whatsapp.com/send/?phone=244915501500', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.835756097734!2d13.189707314877285!3d-8.894857693613954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f4c3f70f2803%3A0x4204168de494eed3!2sAv.%2021%20de%20Janeiro%2C%20Luanda!5e0!3m2!1spt-PT!2sao!4v1674490140727!5m2!1spt-PT!2sao');

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `tipo_funcionario` varchar(200) NOT NULL,
  `Yes_admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mensagem`
--

CREATE TABLE `mensagem` (
  `id_uc` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `assunto` varchar(200) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `visto` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pessoa`
--

CREATE TABLE `pessoa` (
  `id_pessoa` int(11) NOT NULL,
  `nome` varchar(430) NOT NULL,
  `sobrenome` varchar(430) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `endereco` varchar(120) NOT NULL,
  `data_nas` date NOT NULL,
  `n_ide` varchar(120) NOT NULL,
  `id_contacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `nome`, `sobrenome`, `genero`, `endereco`, `data_nas`, `n_ide`, `id_contacto`) VALUES
(1, 'admin', 'admin', 'masculino', 'Cassequel', '2001-10-15', '15545', 1),
(16, 'Joel', 'Luis dos Santos', 'Masculino', 'Camama - Jardim de Rosas', '2001-11-15', 'AG41855', 16);

-- --------------------------------------------------------

--
-- Table structure for table `quartos`
--

CREATE TABLE `quartos` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `adulto` int(11) NOT NULL,
  `crianca` int(11) NOT NULL,
  `descricao` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removido` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `quartos`
--

INSERT INTO `quartos` (`id`, `nome`, `area`, `preco`, `quant`, `adulto`, `crianca`, `descricao`, `status`, `removido`) VALUES
(1, 'Quarto Simples', 7, 7000, 5, 2, 0, 'Um Quarto Simples para um curto espaÃ§o de tempo de acomodaÃ§Ã£o com preÃ§o flexÃ­vel', 1, 0),
(2, 'Quarto Medio', 9, 10000, 15, 2, 2, 'Quarto Medio pra quem quer mais pouco de espaÃ§o e conforto', 1, 0),
(3, 'Quarto Vip', 12, 12000, 10, 3, 2, 'Quarto VIP pra quer mais conforto e luxo', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quartos_acomadacao`
--

CREATE TABLE `quartos_acomadacao` (
  `id` int(11) NOT NULL,
  `quartos_id` int(11) NOT NULL,
  `acomadacao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `quartos_acomadacao`
--

INSERT INTO `quartos_acomadacao` (`id`, `quartos_id`, `acomadacao_id`) VALUES
(1, 1, 7),
(2, 1, 10),
(3, 1, 12),
(4, 2, 7),
(5, 2, 8),
(6, 2, 10),
(7, 2, 12),
(8, 3, 7),
(9, 3, 8),
(10, 3, 10),
(11, 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `quartos_caracteristica`
--

CREATE TABLE `quartos_caracteristica` (
  `id` int(11) NOT NULL,
  `quartos_id` int(11) NOT NULL,
  `caracteristica_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `quartos_caracteristica`
--

INSERT INTO `quartos_caracteristica` (`id`, `quartos_id`, `caracteristica_id`) VALUES
(1, 1, 9),
(2, 1, 13),
(3, 2, 12),
(4, 2, 13),
(5, 2, 14),
(6, 3, 12),
(7, 3, 13),
(8, 3, 14),
(9, 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `quartos_imagem`
--

CREATE TABLE `quartos_imagem` (
  `id` int(11) NOT NULL,
  `quartos_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `quartos_imagem`
--

INSERT INTO `quartos_imagem` (`id`, `quartos_id`, `image`, `thumb`) VALUES
(1, 1, 'IMG_49033.png', 1),
(2, 2, 'IMG_57081.png', 1),
(3, 3, 'IMG_54023.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `id_rr` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `quarto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(250) NOT NULL,
  `visto` int(11) NOT NULL DEFAULT 0,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reserva_detalhes`
--

CREATE TABLE `reserva_detalhes` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `quarto_nome` varchar(100) NOT NULL,
  `preco` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `quarto_no` varchar(11) DEFAULT NULL,
  `user_nome` varchar(100) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `tipo_pag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reserva_pedido`
--

CREATE TABLE `reserva_pedido` (
  `reserva_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quarto_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `chegada` int(11) NOT NULL DEFAULT 0,
  `reembolso` int(11) DEFAULT NULL,
  `reserva_status` varchar(100) NOT NULL DEFAULT 'pendente',
  `ordem_id` varchar(64) NOT NULL,
  `pedido_status` varchar(100) NOT NULL DEFAULT 'pendente',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `invoice` mediumblob DEFAULT NULL,
  `rate_review` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `funcoes` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `funcoes`) VALUES
(1, 'Administrador'),
(2, 'Recepcionista');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_acesso` int(11) NOT NULL,
  `id_cont` int(11) NOT NULL DEFAULT 0,
  `id_config` int(11) NOT NULL DEFAULT 0,
  `id_pessoa` int(11) NOT NULL DEFAULT 0,
  `verif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `username`, `password`, `id_role`, `id_acesso`, `id_cont`, `id_config`, `id_pessoa`, `verif`) VALUES
(14, 'admin', '$2a$12$gGt/rVzmh1g8lXxfCR6aWuN4mfUDvqFQFRWHT0W27.Br9fSFJm1OS', 1, 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_home`
--

CREATE TABLE `user_home` (
  `id_user` int(11) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `id_acesso` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `se_verificado` int(11) NOT NULL DEFAULT 0,
  `id_pessoa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `user_home`
--

INSERT INTO `user_home` (`id_user`, `profile`, `pass`, `token`, `t_expire`, `status`, `id_acesso`, `datetime`, `se_verificado`, `id_pessoa`) VALUES
(3, '', '', 'e13a570f839dbc4b7750f8914cfa3abb', '2023-06-18', 1, 2, '2023-06-11 07:00:18', 1, 1),
(7, 'IMG_24828.jpeg', '$2y$10$Jh3VSRiv9JTB/FC2t.Urb.InvIDmI58bgNje.OZX/XDEkxs4LKwFK', '28ede836833a1e76e06c03b9960a161b', NULL, 1, 8, '2023-06-20 00:19:50', 1, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acesso`
--
ALTER TABLE `acesso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acomadacao`
--
ALTER TABLE `acomadacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id_confg`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactos_detalhes`
--
ALTER TABLE `contactos_detalhes`
  ADD PRIMARY KEY (`id_cont`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `user_admin` (`Yes_admin`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id_uc`);

--
-- Indexes for table `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id_pessoa`),
  ADD KEY `id_contacto` (`id_contacto`);

--
-- Indexes for table `quartos`
--
ALTER TABLE `quartos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quartos_acomadacao`
--
ALTER TABLE `quartos_acomadacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acomadacao id` (`acomadacao_id`),
  ADD KEY `qrt id` (`quartos_id`);

--
-- Indexes for table `quartos_caracteristica`
--
ALTER TABLE `quartos_caracteristica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caracteristica` (`caracteristica_id`),
  ADD KEY `quartos id` (`quartos_id`);

--
-- Indexes for table `quartos_imagem`
--
ALTER TABLE `quartos_imagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quartos_id` (`quartos_id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`id_rr`),
  ADD KEY `reserva_id` (`reserva_id`),
  ADD KEY `quarto_id` (`quarto_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reserva_detalhes`
--
ALTER TABLE `reserva_detalhes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`);

--
-- Indexes for table `reserva_pedido`
--
ALTER TABLE `reserva_pedido`
  ADD PRIMARY KEY (`reserva_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quarto_id` (`quarto_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role_idx` (`id_role`),
  ADD KEY `id_acesso` (`id_acesso`),
  ADD KEY `id_cont` (`id_cont`),
  ADD KEY `id_config` (`id_config`),
  ADD KEY `id_pessoa` (`id_pessoa`);

--
-- Indexes for table `user_home`
--
ALTER TABLE `user_home`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_pessoa` (`id_pessoa`),
  ADD KEY `id_acesso` (`id_acesso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acesso`
--
ALTER TABLE `acesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `acomadacao`
--
ALTER TABLE `acomadacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id_confg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contactos_detalhes`
--
ALTER TABLE `contactos_detalhes`
  MODIFY `id_cont` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `id_uc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quartos`
--
ALTER TABLE `quartos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quartos_acomadacao`
--
ALTER TABLE `quartos_acomadacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quartos_caracteristica`
--
ALTER TABLE `quartos_caracteristica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quartos_imagem`
--
ALTER TABLE `quartos_imagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `id_rr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reserva_detalhes`
--
ALTER TABLE `reserva_detalhes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserva_pedido`
--
ALTER TABLE `reserva_pedido`
  MODIFY `reserva_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_home`
--
ALTER TABLE `user_home`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Constraints for table `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `pessoa_ibfk_1` FOREIGN KEY (`id_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quartos_acomadacao`
--
ALTER TABLE `quartos_acomadacao`
  ADD CONSTRAINT `acomadacao id` FOREIGN KEY (`acomadacao_id`) REFERENCES `acomadacao` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `qrt id` FOREIGN KEY (`quartos_id`) REFERENCES `quartos` (`id`);

--
-- Constraints for table `quartos_caracteristica`
--
ALTER TABLE `quartos_caracteristica`
  ADD CONSTRAINT `caracteristica` FOREIGN KEY (`caracteristica_id`) REFERENCES `caracteristicas` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `quartos id` FOREIGN KEY (`quartos_id`) REFERENCES `quartos` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `quartos_imagem`
--
ALTER TABLE `quartos_imagem`
  ADD CONSTRAINT `quartos_imagem_ibfk_1` FOREIGN KEY (`quartos_id`) REFERENCES `quartos` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva_pedido` (`reserva_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`quarto_id`) REFERENCES `quartos` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_home` (`id_user`);

--
-- Constraints for table `reserva_detalhes`
--
ALTER TABLE `reserva_detalhes`
  ADD CONSTRAINT `reserva_detalhes_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva_pedido` (`reserva_id`);

--
-- Constraints for table `reserva_pedido`
--
ALTER TABLE `reserva_pedido`
  ADD CONSTRAINT `reserva_pedido_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_home` (`id_user`),
  ADD CONSTRAINT `reserva_pedido_ibfk_2` FOREIGN KEY (`quarto_id`) REFERENCES `quartos` (`id`);

--
-- Constraints for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD CONSTRAINT `user_admin_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`),
  ADD CONSTRAINT `user_admin_ibfk_2` FOREIGN KEY (`id_acesso`) REFERENCES `acesso` (`id`),
  ADD CONSTRAINT `user_admin_ibfk_3` FOREIGN KEY (`id_cont`) REFERENCES `contactos_detalhes` (`id_cont`),
  ADD CONSTRAINT `user_admin_ibfk_5` FOREIGN KEY (`id_config`) REFERENCES `configuracoes` (`id_confg`),
  ADD CONSTRAINT `user_admin_ibfk_6` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Constraints for table `user_home`
--
ALTER TABLE `user_home`
  ADD CONSTRAINT `id_pessoa` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id_pessoa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_home_ibfk_1` FOREIGN KEY (`id_acesso`) REFERENCES `acesso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
