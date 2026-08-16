-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/01/2026 às 20:09
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
-- Banco de dados: `saas-templates`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `entity_type` varchar(255) NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `document`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cliente Demo', NULL, 'active', '2025-12-31 18:30:31', '2025-12-31 18:30:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `client_templates`
--

CREATE TABLE `client_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','revoked') NOT NULL DEFAULT 'active',
  `acquired_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `client_templates`
--

INSERT INTO `client_templates` (`id`, `client_id`, `template_id`, `status`, `acquired_at`, `deleted_at`) VALUES
(1, 1, 1, 'active', '2025-12-31 18:30:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `domains`
--

CREATE TABLE `domains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) NOT NULL,
  `status` enum('pending','active') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `domains`
--

INSERT INTO `domains` (`id`, `site_id`, `domain`, `status`, `created_at`, `deleted_at`) VALUES
(1, 1, 'demo.local', 'pending', '2025-12-31 15:30:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2025_12_31_000000_create_clients_table', 1),
(5, '2025_12_31_000001_create_users_table', 1),
(6, '2025_12_31_134024_create_templates_table', 1),
(7, '2025_12_31_134045_create_template_versions_table', 1),
(8, '2025_12_31_134103_create_sites_table', 1),
(9, '2025_12_31_134120_create_subscriptions_table', 1),
(10, '2025_12_31_134223_create_payments_table', 1),
(11, '2025_12_31_134234_create_publication_requests_table', 1),
(12, '2025_12_31_134247_create_client_templates_table', 1),
(13, '2025_12_31_134256_create_site_users_table', 1),
(14, '2025_12_31_134308_create_domains_table', 1),
(15, '2025_12_31_134700_create_webhook_logs_table', 1),
(16, '2025_12_31_134709_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(255) NOT NULL,
  `external_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('paid','pending','failed') NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `publication_requests`
--

CREATE TABLE `publication_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('requested','in_progress','published','rejected') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `publication_requests`
--

INSERT INTO `publication_requests` (`id`, `site_id`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'requested', NULL, '2026-01-03 21:49:32', '2026-01-03 21:49:32', NULL),
(2, 1, 'requested', NULL, '2026-01-03 22:04:54', '2026-01-03 22:04:54', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `template_version_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('draft','published','suspended') NOT NULL DEFAULT 'draft',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sites`
--

INSERT INTO `sites` (`id`, `client_id`, `template_version_id`, `name`, `slug`, `status`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Site Demo', 'site-demo', 'draft', '{\"hero\":{\"title\":\"T\\u00edtulo Demo teste\",\"subtitle\":\"Subt\\u00edtulo demo\"},\"about\":{\"description\":\"Descri\\u00e7\\u00e3o demo\"}}', '2025-12-31 18:30:31', '2026-01-03 21:07:09', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `site_users`
--

CREATE TABLE `site_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('owner','editor') NOT NULL DEFAULT 'editor',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `site_users`
--

INSERT INTO `site_users` (`id`, `site_id`, `user_id`, `role`, `deleted_at`) VALUES
(1, 1, 1, 'owner', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','canceled','overdue') NOT NULL,
  `started_at` date NOT NULL,
  `ended_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `templates`
--

INSERT INTO `templates` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Site Padrão', 'business', 'Template institucional padrão', 'active', '2025-12-31 18:30:31', '2025-12-31 18:30:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `template_versions`
--

CREATE TABLE `template_versions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `template_versions`
--

INSERT INTO `template_versions` (`id`, `template_id`, `version`, `path`, `is_active`, `created_at`) VALUES
(1, 1, '1.0.0', 'business/v1', 1, '2025-12-31 15:30:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `client_id`, `name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Admin Demo', 'admin@demo.com', '$2y$10$zskVjzOHwDQe3YJNornYg.SBJrY1HrWs4YRfc9bM2j5gZgXos/bwK', '2025-12-31 18:30:31', '2025-12-31 18:30:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `webhook_logs`
--

CREATE TABLE `webhook_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(255) NOT NULL,
  `event` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `client_templates`
--
ALTER TABLE `client_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_templates_client_id_template_id_unique` (`client_id`,`template_id`),
  ADD KEY `client_templates_template_id_foreign` (`template_id`);

--
-- Índices de tabela `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domains_domain_unique` (`domain`),
  ADD KEY `domains_site_id_foreign` (`site_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_subscription_id_foreign` (`subscription_id`),
  ADD KEY `payments_external_id_index` (`external_id`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `publication_requests`
--
ALTER TABLE `publication_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publication_requests_site_id_foreign` (`site_id`);

--
-- Índices de tabela `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sites_client_id_slug_unique` (`client_id`,`slug`),
  ADD KEY `sites_template_version_id_foreign` (`template_version_id`);

--
-- Índices de tabela `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_users_site_id_user_id_unique` (`site_id`,`user_id`),
  ADD KEY `site_users_user_id_foreign` (`user_id`);

--
-- Índices de tabela `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_client_id_foreign` (`client_id`),
  ADD KEY `subscriptions_site_id_foreign` (`site_id`);

--
-- Índices de tabela `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `templates_slug_unique` (`slug`);

--
-- Índices de tabela `template_versions`
--
ALTER TABLE `template_versions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `template_versions_template_id_version_unique` (`template_id`,`version`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_client_id_foreign` (`client_id`);

--
-- Índices de tabela `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `client_templates`
--
ALTER TABLE `client_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `domains`
--
ALTER TABLE `domains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `publication_requests`
--
ALTER TABLE `publication_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `site_users`
--
ALTER TABLE `site_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `template_versions`
--
ALTER TABLE `template_versions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `webhook_logs`
--
ALTER TABLE `webhook_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `client_templates`
--
ALTER TABLE `client_templates`
  ADD CONSTRAINT `client_templates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `client_templates_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`);

--
-- Restrições para tabelas `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `domains_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `publication_requests`
--
ALTER TABLE `publication_requests`
  ADD CONSTRAINT `publication_requests_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sites_template_version_id_foreign` FOREIGN KEY (`template_version_id`) REFERENCES `template_versions` (`id`);

--
-- Restrições para tabelas `site_users`
--
ALTER TABLE `site_users`
  ADD CONSTRAINT `site_users_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `site_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `template_versions`
--
ALTER TABLE `template_versions`
  ADD CONSTRAINT `template_versions_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`);

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
