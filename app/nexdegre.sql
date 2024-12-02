
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `nexdegree` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `nexdegree`;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_logs_ibfk_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `activity_logs`
--

TRUNCATE TABLE `activity_logs`;
-- --------------------------------------------------------

--
-- Table structure for table `enseignants`
--

DROP TABLE IF EXISTS `enseignants`;
CREATE TABLE IF NOT EXISTS `enseignants` (
  `id_enseignant` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) NOT NULL,
  `qualifications` varchar(100) DEFAULT NULL,
  `cv` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_enseignant`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `enseignants`
--

TRUNCATE TABLE `enseignants`;
INSERT  INTO `enseignants` (`id_enseignant`, `utilisateur_id`, `qualifications`, `cv`, `image`) VALUES(1, 2, 'PhD in Mathematics', 'bob_cv.pdf', 'bob.png');
INSERT  INTO `enseignants` (`id_enseignant`, `utilisateur_id`, `qualifications`, `cv`, `image`) VALUES(2, 4, 'PhD in Physics', 'diane_cv.pdf', 'diane.png');
INSERT  INTO `enseignants` (`id_enseignant`, `utilisateur_id`, `qualifications`, `cv`, `image`) VALUES(3, 6, 'Masters in Computer Science', 'frank_cv.pdf', 'frank.png');
INSERT  INTO `enseignants` (`id_enseignant`, `utilisateur_id`, `qualifications`, `cv`, `image`) VALUES(12, 29, 'Science', 'uploads/cvs/cv_674cba6a937d8.pdf', 'uploads/images/teacher_674cba6a95d13.png');

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiant` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `image_profil` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_etudiant`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `etudiants`
--

TRUNCATE TABLE `etudiants`;
--
-- Dumping data for table `etudiants`
--

INSERT   INTO `etudiants` (`id_etudiant`, `id_utilisateur`, `niveau`, `image_profil`) VALUES(1, 1, 'Licence 1', 'alice.png');
INSERT   INTO `etudiants` (`id_etudiant`, `id_utilisateur`, `niveau`, `image_profil`) VALUES(2, 3, 'Licence 2', 'charlie.png');
INSERT   INTO `etudiants` (`id_etudiant`, `id_utilisateur`, `niveau`, `image_profil`) VALUES(3, 5, 'Master 1', 'eve.png');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

DROP TABLE IF EXISTS `login_logs`;
CREATE TABLE IF NOT EXISTS `login_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `login_logs_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `login_logs`
--

TRUNCATE TABLE `login_logs`;
--
-- Dumping data for table `login_logs`
--

INSERT   INTO `login_logs` (`id`, `user_id`, `ip_address`, `timestamp`) VALUES(1, 29, '1$', '2024-12-01 21:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `type` enum('info','warning','error','success') NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `notifications`
--

TRUNCATE TABLE `notifications`;
-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Truncate table before insert `password_resets`
--
TRUNCATE TABLE `password_resets`;
-- --------------------------------------------------------
--
-- Table structure for table `permissions`
--
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('etudiant','enseignant','admin') NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `permissions`
--

TRUNCATE TABLE `permissions`;
-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role` enum('etudiant','enseignant','admin') NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `role_permissions`
--

TRUNCATE TABLE `role_permissions`;
-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(64) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `device_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `user_sessions`
--

TRUNCATE TABLE `user_sessions`;
-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `numero_telephone` varchar(15) NOT NULL,
  `role` enum('etudiant','enseignant') NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `cree_a` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` varchar(20) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `utilisateurs`
--

TRUNCATE TABLE `utilisateurs`;
--
-- Dumping data for table `utilisateurs`
--

INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(1, 'Alice Dupont', 'alice.dupont@example.com', '1234567890', 'etudiant', 'password123', '2024-11-30 11:49:47', 'active');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(2, 'Bob Martin', 'bob.martin@example.com', '0987654321', 'enseignant', 'securepassword', '2024-11-30 11:49:47', 'active');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(3, 'Charlie Leroux', 'charlie.leroux@example.com', '1122334455', 'etudiant', 'mypassword', '2024-11-30 11:49:47', 'active');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(4, 'Diane Dubois', 'diane.dubois@example.com', '2233445566', 'enseignant', 'anotherpassword', '2024-11-30 11:49:47', 'active');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(5, 'Eve Lambert', 'eve.lambert@example.com', '3344556677', 'etudiant', 'secure123', '2024-11-30 11:49:47', 'inactive');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(6, 'Frank Simon', 'frank.simon@example.com', '4455667788', 'enseignant', 'password789', '2024-11-30 11:49:47', 'active');
INSERT   INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES(29, 'chahbani mohamed', 'medchah606@gmail.com', '23565400', 'enseignant', '$2y$10$hODECUhTOWwZ.evaDBj9BuG4OBrj.lE515pukTHl7TnGpItjehvAe', '2024-12-01 19:35:06', 'active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enseignants`
--
ALTER TABLE `enseignants`
  ADD CONSTRAINT `enseignants_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateurs` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
