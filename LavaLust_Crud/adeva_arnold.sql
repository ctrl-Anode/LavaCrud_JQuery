
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE database `adeva_arnold`
use `adeva_arnold`
CREATE TABLE `aza_users` (
  `id` int(11) NOT NULL,
  `aza_last_name` varchar(255) NOT NULL,
  `aza_first_name` varchar(255) NOT NULL,
  `aza_email` varchar(255) NOT NULL,
  `aza_gender` varchar(255) NOT NULL,
  `aza_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `aza_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `aza_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
