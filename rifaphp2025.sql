-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/12/2024 às 15:43
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
-- Banco de dados: `draccu_rifa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `type_raffle` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subname` varchar(255) NOT NULL,
  `image_raffle` text NOT NULL,
  `image_raffle_galery` text DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `progress_bar` tinyint(1) NOT NULL,
  `description` longtext NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `expiration_pix` int(11) NOT NULL,
  `qtd_numbers` bigint(20) NOT NULL,
  `favorite` tinyint(1) NOT NULL,
  `qtd_min` int(11) NOT NULL,
  `qtd_max` int(11) NOT NULL,
  `draw_date` varchar(255) DEFAULT NULL,
  `qtd_select` varchar(255) NOT NULL,
  `draw_titles` text DEFAULT NULL,
  `award_titles` text DEFAULT NULL,
  `winner` text DEFAULT NULL,
  `qtd_promo` text DEFAULT NULL,
  `price_promo` text DEFAULT NULL,
  `ranking` tinyint(1) NOT NULL,
  `ranking_phrase` varchar(255) DEFAULT NULL,
  `ranking_diary` tinyint(1) NOT NULL,
  `ranking_diary_phrase` varchar(255) DEFAULT NULL,
  `bigger_smaller_title` tinyint(1) NOT NULL,
  `bigger_smaller_title_diary` tinyint(1) NOT NULL,
  `numbers_file_path` varchar(255) DEFAULT NULL,
  `max_title_general` varchar(255) DEFAULT NULL,
  `min_title_general` varchar(255) DEFAULT NULL,
  `max_title_daily` varchar(255) DEFAULT NULL,
  `min_title_daily` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `campaigns`
--

INSERT INTO `campaigns` (`id`, `type_raffle`, `name`, `subname`, `image_raffle`, `image_raffle_galery`, `price`, `progress_bar`, `description`, `slug`, `status`, `expiration_pix`, `qtd_numbers`, `favorite`, `qtd_min`, `qtd_max`, `draw_date`, `qtd_select`, `draw_titles`, `award_titles`, `winner`, `qtd_promo`, `price_promo`, `ranking`, `ranking_phrase`, `ranking_diary`, `ranking_diary_phrase`, `bigger_smaller_title`, `bigger_smaller_title_diary`, `numbers_file_path`, `max_title_general`, `min_title_general`, `max_title_daily`, `min_title_daily`, `created_at`, `updated_at`) VALUES
(78, 'Automática', 'Rifa demonstração', 'Sua chance de mudar de vida chegou!', '6751aecf30140-image-01.png', '', '0,01', 0, 'Rifa demonstração', 'rifa-demonstra-o', 'Adquira já!', 10, 1000000, 1, 10, 20000, '27/10/24 às 19:00', '20, 40, 100, 200, 300, 500', '546175, 916107, 523652, 023836, 022747, 854621', 'R$3.000, R$3.000, R$3.000, R$3.000, R$3.000, R$3.000', NULL, '', '', 0, NULL, 0, NULL, 0, 0, 'campaign_rifa-demonstra-o_1733406415.txt', NULL, NULL, NULL, NULL, '2024-12-05 10:46:55', '2024-12-05 10:46:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `communications`
--

CREATE TABLE `communications` (
  `id` int(11) NOT NULL,
  `communication` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `gateways`
--

CREATE TABLE `gateways` (
  `id` int(11) NOT NULL,
  `client_id` text DEFAULT NULL,
  `client_secret` text DEFAULT NULL,
  `pix_key` text DEFAULT NULL,
  `pix_cert` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `api_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `gateways`
--

INSERT INTO `gateways` (`id`, `client_id`, `client_secret`, `pix_key`, `pix_cert`, `company_id`, `api_url`) VALUES
(1, NULL, NULL, NULL, '67378e29ed96c_producao-515175-Draccu CP.p12', NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_campaign` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `numbers` longtext DEFAULT NULL,
  `total` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `pix_url` text NOT NULL,
  `expiration_date` datetime NOT NULL,
  `hash_order` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name_website` varchar(255) NOT NULL,
  `support_wpp` varchar(255) DEFAULT NULL,
  `group_wpp` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `color_website` varchar(255) NOT NULL,
  `id_pixel_facebook` varchar(255) DEFAULT NULL,
  `tag_google` text DEFAULT NULL,
  `term_use` longtext DEFAULT NULL,
  `field_cpf` tinyint(1) NOT NULL,
  `field_email` tinyint(1) NOT NULL,
  `field_age` tinyint(1) NOT NULL,
  `field_address` tinyint(1) NOT NULL,
  `paggue` tinyint(1) NOT NULL DEFAULT 0,
  `efi_bank` tinyint(1) NOT NULL DEFAULT 0,
  `image_logo` varchar(255) NOT NULL,
  `image_icon` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `settings`
--

INSERT INTO `settings` (`id`, `name_website`, `support_wpp`, `group_wpp`, `instagram`, `tiktok`, `telegram`, `color_website`, `id_pixel_facebook`, `tag_google`, `term_use`, `field_cpf`, `field_email`, `field_age`, `field_address`, `paggue`, `efi_bank`, `image_logo`, `image_icon`, `created_at`, `updated_at`) VALUES
(1, 'Nome do seu site', '', '', '', '', '', '#00307a', '', '', '\r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    \r\n                                    <p style=\"margin-bottom: 1rem; font-size: 14.4px;\"><br></p><div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ', 0, 0, 0, 0, 1, 0, '674f5a6d7f821-logo-deafault.png', 'favicon.ico', '2024-12-05 15:09:41', '2024-12-05 15:09:41');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image_user` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `cpf`, `age`, `address`, `image_user`, `isAdmin`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@teste.com', '$2y$10$a76Q4ZDzLRowBodD0ozEkefYGQgo4pwplIH16wzgAgfkiI1YuxJRe', '', '', '', '                                                                                                                                                                                                                                                                                    ', '67336b335ebd7-Design sem nome (2).png', 1, '2024-11-01 22:27:08', '2024-12-05 15:40:46');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `communications`
--
ALTER TABLE `communications`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_campaign` (`id_campaign`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `communications`
--
ALTER TABLE `communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1103;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_campaign`) REFERENCES `campaigns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
