-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 déc. 2024 à 22:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nexdegre`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `texte` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `texte`, `is_correct`) VALUES
(1, 1, 'X=13/7  \r\n​\r\n', 1),
(2, 1, 'X=0 ', 0),
(3, 1, 'y=4/7', 1),
(4, 1, 'y=0', 0),
(5, 2, 'Vrai ', 1),
(6, 2, 'Faux ', 0),
(7, 3, 'X= 7/5\r\n​\r\n ', 1),
(8, 3, 'X=1', 0),
(9, 3, 'Y=1/4', 0),
(10, 3, 'Y=6/5', 1),
(11, 5, '5', 1),
(15, 6, 'To produce energy (ATP)', 1),
(16, 6, 'To store genetic material', 0),
(17, 7, 'Vrai ', 1),
(18, 7, 'Faux ', 0),
(19, 6, 'To synthesize proteins', 0),
(20, 6, 'To regulate calcium levels', 1),
(21, 8, 'Interphase', 1),
(22, 8, 'G1 phase', 0),
(23, 8, 'S phase', 1),
(24, 8, 'M phase', 0),
(25, 9, '46', 1),
(26, 10, 'The quest for the Holy Grail', 0),
(27, 10, ' The search for true love', 1),
(28, 10, 'The creation of the world ', 0),
(29, 10, 'The fall of the Roman Empire ', 1),
(30, 11, 'Chrétien de Troyes ', 1),
(31, 11, 'Jean de La Fontaine ', 1),
(32, 11, 'Molière', 0),
(33, 11, 'Victor Hugo', 0),
(34, 12, 'Vrai', 0),
(35, 12, 'Faux ', 1),
(36, 13, 'Chrétien de Troyes', 1);

-- --------------------------------------------------------

--
-- Structure de la table `chapitre`
--

CREATE TABLE `chapitre` (
  `id_chapitre` int(11) NOT NULL,
  `id_matiere` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `objectif` text DEFAULT NULL,
  `activite` text DEFAULT NULL,
  `res_supp` text DEFAULT NULL,
  `evaluation_incluse` tinyint(1) DEFAULT 0,
  `type_de_evaluation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chapitre`
--

INSERT INTO `chapitre` (`id_chapitre`, `id_matiere`, `titre`, `contenu`, `date_debut`, `duree`, `objectif`, `activite`, `res_supp`, `evaluation_incluse`, `type_de_evaluation`) VALUES
(43, 1, ' Algebra Introduction', '67427788a6923.pdf', '2025-01-01', 40, 'L\'objectif de ce cours est d\'introduire les concepts fondamentaux de l\'algèbre, y compris les équations, les fonctions et les polynômes.\r\n', 'Activités principales : \r\n- Résoudre des équations de premier et deuxième degré\r\n- Analyser des fonctions linéaires et quadratiques\r\n- Résoudre des problèmes algébriques en groupe\r\n', '- Livres recommandés : \"Algebra for Beginners\" par John Doe\r\n- Tutoriels vidéo : Lien vers YouTube pour des leçons supplémentaires\r\n', 1, 'Quiz'),
(49, 1, 'Calcul Intégral', '674b07541421d.pdf', '2022-10-29', 21, 'Introduction aux intégrales et à leurs applications en géométrie.', 'Résolution d\'exercices pratiques sur les intégrales définies.', ' Liens vers des articles supplémentaires sur le calcul intégral', 1, 'Examen de fin de chapitre avec des questions pratiques sur les intégrales.'),
(50, 2, 'Les Lois de Newton', '674b17421f3e3.pdf', '2025-10-01', 10, 'Comprendre les lois fondamentales du mouvement', 'Expériences pratiques avec des objets en mouvement.', 'Articles sur la mécanique, vidéos explicatives.', 1, 'QUIZ'),
(51, 2, 'Étude du mouvement d\'une particule soumis à une force extérieure', '674b17ab78f2d.pdf', '2024-12-29', 15, 'Comprendre le concept de cour forcée et son application.', 'Démonstration pratique avec des simulations.\r\n', 'Vidéos, exercices pratiques.', 1, 'QCM, analyse de cas pratiques'),
(52, 10, 'Soudure de base', '674b184f66559.pdf', '2026-03-30', 8, 'Apprendre les bases de la soudure pour assembler des composants électroniques.\r\n', 'Réalisation d’un circuit imprimé avec soudure de composants.\r\n', 'Manuel de soudure, vidéo tutoriel\r\n', 1, 'Pratique - Réalisation d’un circuit imprimé fonctionnel.'),
(53, 6, 'Introduction à la programmation en Python', '674b1899c7c93.pdf', '2027-09-30', 6, 'Acquérir les bases de la programmation avec Python pour créer des scripts simples.', 'Rédaction de scripts Python pour résoudre des problèmes algorithmiques.\r\n', 'Documentation officielle Python, tutoriels vidéos\r\n', 1, 'Examen pratique - Créer un script Python pour automatiser une tâche.'),
(54, 2, 'TEST', '6760a97ce90a2.pdf', '2025-11-30', 22, '22', '222', '222', 1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id_enseignant` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `qualifications` varchar(100) DEFAULT NULL,
  `cv` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id_enseignant`, `utilisateur_id`, `qualifications`, `cv`, `image`) VALUES
(25, 56, 'Math', 'uploads/cvs/cv_6761eaa69fc62.pdf', 'uploads/images/teacher_6761eaa69fed0.jfif');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id_etudiant` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `image_profil` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id_etudiant`, `id_utilisateur`, `niveau`, `image_profil`) VALUES
(17, 55, '7eme', 'uploads/images/student_67619440979fb.png');

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `matiere` varchar(50) NOT NULL,
  `duree` int(11) NOT NULL,
  `noteMax` float NOT NULL,
  `date2` date NOT NULL,
  `quest1` text NOT NULL,
  `quest2` text NOT NULL,
  `quest3` text NOT NULL,
  `quest4` text NOT NULL,
  `quest5` text NOT NULL,
  `id_chapitre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le COLLATE=utf16le_general_ci;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `matiere`, `duree`, `noteMax`, `date2`, `quest1`, `quest2`, `quest3`, `quest4`, `quest5`, `id_chapitre`) VALUES
(63, 'Calcul Intégral', 4, 5, '2026-03-04', 'aaaa', 'aaa', 'aaa', 'aaa', 'aaaa', 49),
(65, 'Les Lois de Newton', 11, 11, '2023-11-30', 'tt', 'tt', 'tt', 'tt', 'tt', 50),
(66, ' Algebra Introduction', 111, 11, '2023-11-30', 'aa', 'aa', 'aa', 'aa', 'aa', 43),
(67, 'Calcul Intégral', 22, 22, '2222-02-22', 'zz', 'zzz', 'zz', 'zz', 'zz', 49);

-- --------------------------------------------------------

--
-- Structure de la table `face_id`
--

CREATE TABLE `face_id` (
  `user_id` int(11) NOT NULL,
  `face_image` longblob NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_matiere` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `sems` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `prerequis` text DEFAULT NULL,
  `nombre_chapitre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id_matiere`, `nom`, `description`, `credit`, `sems`, `niveau`, `prerequis`, `nombre_chapitre`) VALUES
(1, 'Mathématiques ', 'Ce cours de mathématiques pour la 9ème année couvre les bases de l\'algèbre, la géométrie, et l\'arithmétique avancée. Les élèves développeront leurs compétences en résolution de problèmes, analyse logique, et manipulation des équations, tout en explorant des concepts pratiques pour les études secondaires et la vie quotidienne.', 7, 1, 9, 'Maîtrise des opérations de base (addition, soustraction, multiplication, division), des fractions, des pourcentages, et des concepts élémentaires de géométrie (formes et mesures).', 5),
(2, 'Physique ', 'Le cours de physique pour la 9ème année explore les principes fondamentaux de la matière, de l\'énergie et des forces. Les élèves étudieront des concepts clés tels que le mouvement, les lois de la physique, l\'énergie, la lumière, et les sons, tout en appliquant la méthode scientifique pour résoudre des problèmes et mener des expériences.', 5, 2, 9, 'Connaissances de base en mathématiques, notamment en arithmétique, en géométrie, et en résolution d\'équations simples. Aucune expérience préalable en physique n\'est requise, mais une bonne compréhension des concepts mathématiques de base est recommandée.', 7),
(6, 'Informatique', 'Le cours d\'informatique pour la 9ème année introduit les concepts fondamentaux de l\'informatique, y compris la programmation, la logique, et l\'utilisation des outils numériques. Les élèves apprendront à coder, à résoudre des problèmes avec des algorithmes, et à utiliser les technologies de manière responsable et créative.', 4, 1, 9, 'Aucune connaissance préalable en programmation n\'est nécessaire. Cependant, une familiarité de base avec l\'utilisation des ordinateurs et des logiciels courants est utile', 4),
(10, 'Technique ', 'Le cours de technique pour la 9ème année permet aux élèves d\'explorer les principes de la technologie et de l\'ingénierie. Ils apprendront à utiliser des outils, à concevoir des projets, et à comprendre les systèmes mécaniques et électroniques de base. Ce cours combine théorie et pratique pour développer des compétences techniques et une approche méthodique de la résolution de problèmes.', 4, 2, 9, 'Aucune connaissance préalable n\'est requise. Une bonne compréhension des concepts mathématiques de base et des aptitudes en résolution de problèmes pratiques sont recommandées.', 4);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `texte` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `points` int(11) NOT NULL,
  `temps_limite` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `quiz_id`, `texte`, `type`, `points`, `temps_limite`) VALUES
(1, 1, '	What is the solution to the system of equations: x + 2y = 3, 3x - y = 5?', 'multiple', 5, '2024-11-25 10:00:00'),
(2, 1, 'Is the matrix A = [1 2; 3 4] invertible?', 'true_false', 4, '2024-11-25 20:00:00'),
(3, 1, 'Solve the system of equations: 2x + y = 4, x - 2y = -1.', 'multiple', 6, '2024-11-14 14:00:00'),
(5, 1, 'Calculate the determinant of matrix B = [2 1; 1 3].', 'input', 5, '2024-11-19 21:22:25'),
(6, 2, 'What is the primary function of mitochondria?', 'multiple', 2, '2024-11-13 09:15:02'),
(7, 2, 'Does the nucleus contain DNA?', 'true_false', 2, '2024-11-20 09:15:02'),
(8, 2, '	Which phase of the cell cycle is for DNA replication?', 'multiple', 1, '2024-11-05 09:19:11'),
(9, 2, 'How many chromosomes are there in a human somatic cell?', 'input', 3, '2024-11-08 09:19:11'),
(10, 3, 'What is the main theme of the Roman de la Rose? ', 'multiple', 2, '2024-11-11 10:05:04'),
(11, 3, 'Qui sont les auteurs des œuvres suivantes : \"La Chanson de Roland\" et \"Les Fables\" ?', 'multiple', 3, '2024-11-13 10:05:04'),
(12, 3, 'Victor Hugo est l\'auteur de \'Les Misérables\' et \'Le Rouge et le Noir', 'true_false', 1, '2024-11-22 10:08:25'),
(13, 3, 'What is the name of the French poet who wrote La Chanson de Roland?', 'input', 2, '2024-11-14 10:11:26');

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_chapitre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id`, `title`, `description`, `category`, `created_at`, `id_chapitre`) VALUES
(1, 'Algèbre Linéaire ', 'Cours sur les systèmes linéaires et les matrices ', 'Math', '2024-11-22 14:58:01', NULL),
(2, 'Biologie Cellulaire 	', ' Structure et fonction des cellules vivantes ', 'science', '2024-11-13 11:58:01', NULL),
(3, 'Littérature Française du Moyen Âge 	', 'Analyse des grands auteurs médiévaux français', 'literature', '2024-11-20 21:18:05', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `idrep` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `rep1` text NOT NULL,
  `rep2` text NOT NULL,
  `rep3` text NOT NULL,
  `rep4` text NOT NULL,
  `rep5` text NOT NULL,
  `note` float NOT NULL DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `statusnote` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le COLLATE=utf16le_general_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`idrep`, `id`, `iduser`, `rep1`, `rep2`, `rep3`, `rep4`, `rep5`, `note`, `remarque`, `statusnote`, `status`) VALUES
(42, 66, 55, 'zadazd', 'azdazdaz', 'dzazdazdaz', 'dazazdazd', 'azdazdazdaz', 20, 'tres bien\r\n', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `numtel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le COLLATE=utf16le_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `nom`, `mail`, `numtel`) VALUES
(1, 'hamza', 'hamza@esprit.tn', 20000000);

-- --------------------------------------------------------

--
-- Structure de la table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(64) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `device_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `session_token`, `ip_address`, `device_info`, `created_at`, `expires_at`) VALUES
(15, 55, '4b2990cd4affaab39aaddcdb267c38ac', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2024-12-17 15:10:00', '2024-12-18 16:10:00'),
(18, 56, '3586e41dd9d44d2ff2f00fd123db801b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2024-12-17 21:26:44', '2024-12-18 22:26:44'),
(19, 56, 'd23b3c42bc05ff692ef4b5fcd69a2492', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2024-12-17 21:28:05', '2024-12-18 22:28:05'),
(22, 55, '98540cfe945a1c9b0b2e16fee029e233', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2024-12-17 21:36:35', '2024-12-18 22:36:35');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `numero_telephone` varchar(15) NOT NULL,
  `role` enum('etudiant','enseignant') NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `cree_a` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `cree_a`, `statut`) VALUES
(55, 'mohamed chahbani', 'bob.martin@example.com', '92308572', 'etudiant', 'HamaEya12@', '2024-12-17 15:09:52', 'active'),
(56, 'Jon Doe', 'teste@exemplo.usmmm', '60195210', 'enseignant', '@Medchah12@', '2024-12-17 21:18:30', 'active');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD PRIMARY KEY (`id_chapitre`),
  ADD KEY `id_matiere` (`id_matiere`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id_enseignant`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Etrangère` (`id_chapitre`);

--
-- Index pour la table `face_id`
--
ALTER TABLE `face_id`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id_chapitre` (`id_chapitre`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`idrep`),
  ADD KEY `evaluation` (`id`),
  ADD KEY `user` (`iduser`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- Index pour la table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `chapitre`
--
ALTER TABLE `chapitre`
  MODIFY `id_chapitre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id_enseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `idrep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD CONSTRAINT `chapitre_ibfk_1` FOREIGN KEY (`id_matiere`) REFERENCES `matiere` (`id_matiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD CONSTRAINT `enseignants_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `fk_chapitre_eval` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitre` (`id_chapitre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `face_id`
--
ALTER TABLE `face_id`
  ADD CONSTRAINT `face_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateurs` (`email`) ON DELETE CASCADE;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `fk_quiz_chapitre` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitre` (`id_chapitre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `evaluation` FOREIGN KEY (`id`) REFERENCES `evaluation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reponse_iduser` FOREIGN KEY (`iduser`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
