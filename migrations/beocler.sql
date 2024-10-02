-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 06 mars 2024 à 04:55
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `beocler`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231115055857', '2023-11-15 06:35:27', 269),
('DoctrineMigrations\\Version20231127063056', '2023-11-27 06:31:08', 223);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `test_id` int NOT NULL,
  `status` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `end_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `score` int DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1323A5756B899279` (`patient_id`),
  KEY `IDX_1323A5751E5D0459` (`test_id`),
  KEY `FK_1323A575A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `patient_id`, `test_id`, `status`, `created_at`, `end_at`, `score`, `user_id`) VALUES
(17, 19, 2, 'Done', '2023-11-29 04:51:44', NULL, NULL, 22),
(18, 19, 1, 'Done', '2023-11-29 04:51:57', NULL, NULL, 22);

-- --------------------------------------------------------

--
-- Structure de la table `illustration`
--

DROP TABLE IF EXISTS `illustration`;
CREATE TABLE IF NOT EXISTS `illustration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D67B9A42126F525E` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `illustration`
--

INSERT INTO `illustration` (`id`, `item_id`, `path`, `type`) VALUES
(29, 70, '3934c68d68e5df85e3b7d80b606fb0f4.webp', 'image'),
(30, 71, '6aa7af601b521fc01490e5c9dea05fb7.webp', 'image'),
(32, 72, 'ac129245c5d98be41cf2836a6e0108c2.webp', 'image'),
(33, 73, '15173cb31224b28dc69d4c25a66080c5.webp', 'image'),
(34, 74, '7181fc1e1cf0b9eab03aa702f04402f6.webp', 'image'),
(35, 84, '8e44531a763f10df54a6950cbba61383.webp', 'image'),
(36, 85, '1837ea8cfef6f004529c6bc648e5fe03.webp', 'image'),
(37, 86, '42287d2930c7cdb38377963ff8a51f45.webp', 'image'),
(38, 87, '5b60f7a14851d673e4776fc22bb6bbb7.webp', 'image'),
(39, 93, '884e1e98a0f28e816683fe3d35e45587.webp', 'image'),
(40, 94, 'dce8c67c892a381bfb8e5e5c7d4bf3d4.webp', 'image'),
(41, 95, 'e6a7668f9032770fcc3319a5ce76db2c.webp', 'image'),
(42, 96, '03bd30efb55247325c4d9e8cbca92256.webp', 'image'),
(43, 102, '147d7ce4b7a136031d6536c62a64483e.webp', 'image'),
(44, 103, 'bd8ecbfb129774c5447f29c33dba51e5.webp', 'image'),
(45, 101, '064eb9983d914c1e0a5ce12d17251813.webp', 'image');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `test_id` int NOT NULL,
  `school_grade_id` int DEFAULT NULL,
  `name_cr` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_fr` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E1E5D0459` (`test_id`),
  KEY `IDX_1F1B251E5F95EC` (`school_grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `test_id`, `school_grade_id`, `name_cr`, `name_fr`, `active`, `slug`, `sequence`) VALUES
(66, 1, 1, 'laʀi', 'lari', 1, 'lari', 0),
(67, 1, 1, 'ʀisala', 'rissala', 1, 'rissala', 0),
(68, 1, 1, 'søteliʀa', 'seutélira', 1, 'seutelira', 0),
(69, 1, 1, 'petɛsøʀali / petesøʀali', 'pétaisseurali', 1, 'petaisseurali', 0),
(70, 2, 1, NULL, 'stylo', 1, 'stylo', 0),
(71, 2, 1, NULL, 'spaghettis', 1, 'spaghettis', 0),
(72, 2, 1, NULL, 'jupe', 1, 'jupe', 0),
(73, 2, 1, NULL, 'journal', 1, 'journal', 0),
(74, 2, 1, NULL, 'chapeau', 1, 'chapeau', 0),
(76, 3, 1, NULL, 'slip', 1, 'slip', 0),
(77, 3, 1, NULL, 'slalom', 1, 'slalom', 0),
(78, 3, 1, NULL, 'aspirateur', 1, 'aspirateur', 0),
(79, 3, 1, NULL, 'asticot', 1, 'asticot', 0),
(80, 5, 1, 'Done amoin... bann frui', 'Donne-moi... des fruits', 1, 'Donne-moi-des-fruits', 0),
(81, 5, 1, 'Minnan done amoin... bann zanimo', 'Maintenant donne-moi... des animaux', 1, 'Maintenant-donne-moi-des-animaux', 0),
(82, 5, 1, 'Minnan done amoin... bann parti du kor', 'Maintenant donne-moi... des parties du corps', 1, 'Maintenant-donne-moi-des-parties-du-corps', 0),
(83, 5, 1, 'Minnan done amoin... bann zinstruman pou fé la musik', 'Maintenant donne-moi... des instruments de musique', 1, 'Maintenant-donne-moi-des-instruments-de-musique', 0),
(84, 6, 1, NULL, 'linge', 1, 'linge', 0),
(85, 6, 1, 'bébèt', 'monstre', 1, 'monstre', 0),
(86, 6, 1, 'zano', 'boucle d\'oreilles', 1, 'boucle-d-oreilles', 0),
(87, 6, 1, 'zourit', 'poulpe', 1, 'poulpe', 0),
(88, 7, 1, NULL, 'voiture', 1, 'voiture', 0),
(89, 7, 1, NULL, 'item erroné', 1, 'item-errone', 0),
(90, 7, 1, NULL, 'moto', 1, 'moto', 0),
(91, 7, 1, NULL, 'pomme', 1, 'pomme', 0),
(92, 7, 1, NULL, 'banane', 1, 'banane', 0),
(93, 8, 1, NULL, 'dents- {la trann / la pou}', 1, 'dents-la-trann-la-pou', 0),
(94, 8, 1, NULL, 'dents-i {sa(r) / sava}', 1, 'dents-i-sa-r-sava', 0),
(95, 8, 1, NULL, 'Clementine- la {fine / fini}', 1, 'Clementine-la-fine-fini', 0),
(96, 8, 1, NULL, 'i sa(r)', 1, 'i-sa-r', 0),
(97, 9, 1, 'Kisa i fé : miaou ?', 'Qui fait miaou?', 1, 'Qui-fait-miaou', 0),
(98, 9, 1, 'Konbien dzieu nou nana ?', 'Combien d\'yeux tu as?', 1, 'Combien-d-yeux-tu-as', 0),
(99, 9, 1, 'Kèl linj i mèt pou dormi ?', 'Quel vêtements on met pour dormir?', 1, 'Quel-vetements-on-met-pour-dormir', 0),
(100, 9, 1, 'Kosa i fé la lumièr la nuit dann sièl ?', 'Qu\'est-ce qui fait de la lumière la nuit dans le ciel?', 1, 'Qu-est-ce-qui-fait-de-la-lumiere-la-nuit-dans-le-ciel', 0),
(101, 10, 1, 'kosa', 'c\'est quoi', 1, 'c-est-quoi', 0),
(102, 10, 1, 'Kèl', 'Quel', 1, 'Quel', 0),
(103, 10, 1, 'Koman', 'Comment', 1, 'Comment', 0),
(104, 11, 1, 'Mi yèm manj shokola', 'j\'aime manger du chocolat', 1, 'j-aime-manger-du-chocolat', 0),
(105, 11, 1, 'Mi néna deu sha', 'J\'ai deux chats', 1, 'J-ai-deux-chats', 0),
(106, 11, 1, 'Moin lé fatigé', 'je suis fatigué', 1, 'je-suis-fatigue', 0),
(107, 12, 1, 'Le mesieu i toush aèl', 'le monsieur la touche', 1, 'le-monsieur-la-touche', 0),
(108, 12, 1, 'La madam i karès ali', 'la madame le caresse', 1, 'la-madame-le-caresse', 0),
(109, 12, 1, NULL, 'Il lui donne le bonbon', 1, 'Il-lui-donne-le-bonbon', 0),
(110, 12, 1, 'La madam i port ali', 'la madame le porte', 1, 'la-madame-le-porte', 0),
(111, 13, 1, 'Ou toush aou', 'null', 1, 'null', 0),
(112, 13, 1, NULL, 'Tu te touches', 1, 'Tu-te-touches', 0),
(113, 13, 1, 'Ou toush ali', 'null', 1, 'null', 0),
(114, 13, 1, NULL, 'Il me touche', 1, 'Il-me-touche', 0),
(115, 14, 1, 'Sé listoir Nana.', 'c\'est l\'histoire de Nana', 1, 'c-est-l-histoire-de-Nana', 0),
(116, 14, 1, 'Nana sé inn fiy.', 'Nana est une fille', 1, 'Nana-est-une-fille', 0),
(117, 14, 1, 'Li viv èk son bann paran.', 'elle vit avec ses parents', 1, 'elle-vit-avec-ses-parents', 0),
(118, 14, 1, 'Li néna in joli kaz.', 'elle a une jolie maison', 1, 'elle-a-une-jolie-maison', 0),
(119, 14, 1, 'Li yèm joué é li sava lékol.', 'il a joué et il va a l\'ecole', 1, 'il-a-joue-et-il-va-a-l-ecole', 0),
(120, 16, 1, 'Le sha i pa dor D', 'null', 1, 'null', 0),
(121, 16, 1, 'I fo boir pa lalkol D', 'null', 1, 'null', 0),
(122, 16, 1, 'Mi lé katr an S', 'null', 1, 'null', 0),
(123, 16, 1, 'Mi lala in joli soulié S', 'null', 1, 'null', 0),
(124, 17, 1, NULL, 'C\'est un garçon grand D', 1, 'C-est-un-garcon-grand-D', 0),
(125, 17, 1, NULL, 'La fille sont gentille M', 1, 'La-fille-sont-gentille-M', 0),
(126, 17, 1, NULL, 'Je suis mangé une glace M', 1, 'Je-suis-mange-une-glace-M', 0),
(127, 17, 1, NULL, 'Je vais dors S', 1, 'Je-vais-dors-S', 0),
(128, 18, 1, 'Mi yèm dansé', 'J\'aime danser', 1, 'J-aime-danser', 0),
(129, 18, 1, 'Moin la fé in desin', 'J\'ai fait un dessin', 1, 'J-ai-fait-un-dessin', 0),
(130, 18, 1, 'Li lé antrinn dormi', 'Il est en train de dormir', 1, 'Il-est-en-train-de-dormir', 0),
(131, 18, 1, 'Li bros son dan', 'Il se brosse les dents', 1, 'Il-se-brosse-les-dents', 0),
(132, 19, 1, 'Mi yèm kouri(r)', 'J\'aime courir', 1, 'J-aime-courir', 0),
(133, 19, 1, 'Mi manj pa piman', 'Je ne mange pas de piment', 1, 'Je-ne-mange-pas-de-piment', 0),
(134, 19, 1, 'Il a joué au ballon hier', 'Li la joué balon ièr', 1, 'Li-la-joue-balon-ier', 0),
(135, 19, 1, 'Li {sa / sar / sava} pran son bin', 'Il va prendre son bain', 1, 'Il-va-prendre-son-bain', 0);

-- --------------------------------------------------------

--
-- Structure de la table `option_response`
--

DROP TABLE IF EXISTS `option_response`;
CREATE TABLE IF NOT EXISTS `option_response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `template_value_id` int NOT NULL,
  `name` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1E0C7A5F1E27F6BF` (`question_id`),
  KEY `IDX_1E0C7A5FA6768BD1` (`template_value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_response`
--

INSERT INTO `option_response` (`id`, `question_id`, `template_value_id`, `name`) VALUES
(91, 143, 16, 'voiture'),
(92, 143, 17, 'moto'),
(93, 143, 17, 'bus'),
(94, 143, 17, 'camion'),
(95, 143, 17, 'avion'),
(96, 143, 17, 'vélo'),
(97, 146, 16, 'moto'),
(98, 146, 17, 'voiture'),
(99, 146, 17, 'bus'),
(100, 146, 17, 'camion'),
(101, 146, 17, 'avion'),
(102, 146, 17, 'vélo'),
(103, 147, 16, 'pomme'),
(104, 147, 17, 'banane'),
(105, 147, 17, 'orange'),
(106, 147, 17, 'ananas'),
(107, 147, 17, 'poire'),
(108, 147, 17, 'raisin'),
(109, 148, 16, 'banane'),
(110, 148, 17, 'pomme'),
(111, 148, 17, 'orange'),
(112, 148, 17, 'ananas'),
(113, 148, 17, 'poire'),
(114, 148, 17, 'raisin');

-- --------------------------------------------------------

--
-- Structure de la table `option_response_media`
--

DROP TABLE IF EXISTS `option_response_media`;
CREATE TABLE IF NOT EXISTS `option_response_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_response_media`
--

INSERT INTO `option_response_media` (`id`, `path`, `type`) VALUES
(1, '93378cfae912e9f4b3188abbdef56549.webp', 'image'),
(2, 'd5fc373b0c8cf71086105e2b147bc467.webp', 'image'),
(3, 'cbf9b271333808575eaeaa035fdd1437.webp', 'image'),
(4, 'fb008576076fc610afd231261f37cc04.webp', 'image'),
(5, 'cdfb6fc13a4c5818738b1c9120f4894b.webp', 'image'),
(6, '8c2c6a2fc768b7538eb7d33af8a1f433.webp', 'image'),
(7, 'c6b164b5a703d2e85b6c925b88e8edab.webp', 'image'),
(8, 'd2c6430d2396a9149798178744c11bd4.webp', 'image'),
(9, '0fbb309af272ddc4be85e2d3b41cdb51.webp', 'image'),
(10, 'c03e1375721029288eceef26b759a85a.webp', 'image'),
(11, '64341e9808725d245934b8b4c1ba5a49.webp', 'image'),
(12, '245eec31050914ee4e4fdc4ffaeff1c0.webp', 'image'),
(13, '6e4ebd59427961d8d7c8f320c7adec2c.webp', 'image'),
(14, '16e3988251af1d3fadaf312036b99738.webp', 'image'),
(15, '21817203960d8689e83e61b6b351bce7.webp', 'image'),
(16, '16e7d9b0574defb2ab077ef06870c6b7.webp', 'image'),
(17, '44ba016014773db1bc5955d8e122e4db.webp', 'image'),
(18, '2c8c5b726a83a0af664f190d867f611d.webp', 'image'),
(19, '9b023f197faa74474905f755b2ae6c85.webp', 'image'),
(20, '522d5d984f7c68c0c7653b63e2879de6.webp', 'image'),
(21, '6ab405adb58d4605c610829589dff86b.webp', 'image'),
(22, 'f30098430519aef0c4553e626ac3bd00.webp', 'image'),
(23, '599fdf2b87901134913cc46e867e966b.webp', 'image'),
(24, '4cbfd574953f5114d43d64b5f05d7417.webp', 'image');

-- --------------------------------------------------------

--
-- Structure de la table `option_response_media_option_response`
--

DROP TABLE IF EXISTS `option_response_media_option_response`;
CREATE TABLE IF NOT EXISTS `option_response_media_option_response` (
  `option_response_media_id` int NOT NULL,
  `option_response_id` int NOT NULL,
  PRIMARY KEY (`option_response_media_id`,`option_response_id`),
  KEY `IDX_3CAE18E9AA589275` (`option_response_media_id`),
  KEY `IDX_3CAE18E9DDC771F4` (`option_response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_response_media_option_response`
--

INSERT INTO `option_response_media_option_response` (`option_response_media_id`, `option_response_id`) VALUES
(1, 91),
(2, 92),
(3, 93),
(4, 95),
(5, 94),
(6, 96),
(7, 97),
(8, 98),
(9, 99),
(10, 100),
(11, 101),
(12, 102),
(13, 103),
(14, 104),
(15, 105),
(16, 106),
(17, 107),
(18, 108),
(19, 109),
(20, 110),
(21, 111),
(22, 112),
(23, 113),
(24, 114);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_grade_id` int DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_1ADAD7EB5F95EC` (`school_grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `school_grade_id`, `name`, `last_name`, `birth_date`, `gender`, `active`, `created_at`) VALUES
(19, 3, 'Correntin', 'bidule', '2019-01-01', 'H', 0, '2023-11-29 04:51:09'),
(20, 4, 'Alexandre', 'Dupont', '2018-12-02', 'H', 0, '2023-11-29 05:16:24'),
(21, 7, 'Pauline', 'Wong', '2016-08-07', 'F', 0, '2023-11-29 05:17:08'),
(22, 5, 'Julien', 'Tavot', '2017-09-04', 'H', 0, '2023-11-29 05:18:09'),
(23, 6, 'Beriche', 'Nguyen', '2017-06-05', 'H', 0, '2023-11-29 05:19:27');

-- --------------------------------------------------------

--
-- Structure de la table `patient_user`
--

DROP TABLE IF EXISTS `patient_user`;
CREATE TABLE IF NOT EXISTS `patient_user` (
  `patient_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`patient_id`,`user_id`),
  KEY `IDX_4029B816B899279` (`patient_id`),
  KEY `IDX_4029B81A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient_user`
--

INSERT INTO `patient_user` (`patient_id`, `user_id`) VALUES
(19, 22),
(20, 22),
(21, 22),
(22, 22),
(23, 22);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `template_question_id` int NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494E126F525E` (`item_id`),
  KEY `IDX_B6F7494E15DEE2DB` (`template_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `item_id`, `template_question_id`, `active`) VALUES
(90, 66, 1, 1),
(91, 67, 1, 1),
(92, 68, 1, 1),
(93, 69, 1, 1),
(94, 70, 1, 1),
(95, 70, 2, 1),
(96, 70, 3, 1),
(97, 70, 4, 1),
(98, 71, 1, 1),
(100, 71, 2, 1),
(101, 71, 3, 1),
(102, 71, 4, 1),
(103, 72, 1, 1),
(104, 73, 1, 1),
(105, 74, 1, 1),
(106, 72, 2, 1),
(107, 72, 3, 1),
(108, 72, 4, 1),
(109, 73, 2, 1),
(110, 73, 3, 1),
(111, 73, 4, 1),
(112, 74, 2, 1),
(113, 74, 3, 1),
(114, 74, 4, 1),
(115, 76, 7, 1),
(116, 76, 6, 1),
(117, 76, 5, 1),
(118, 77, 7, 1),
(119, 77, 6, 1),
(120, 77, 5, 1),
(121, 78, 7, 1),
(122, 78, 6, 1),
(123, 78, 5, 1),
(124, 79, 1, 1),
(125, 79, 5, 1),
(126, 79, 6, 1),
(127, 79, 7, 1),
(128, 80, 10, 0),
(129, 81, 10, 0),
(130, 82, 10, 0),
(131, 83, 1, 1),
(132, 83, 10, 0),
(133, 84, 14, 0),
(134, 84, 13, 0),
(135, 85, 1, 1),
(136, 85, 13, 0),
(137, 85, 14, 0),
(138, 86, 14, 0),
(139, 86, 13, 0),
(140, 87, 1, 1),
(141, 87, 13, 0),
(142, 87, 14, 0),
(143, 88, 15, 1),
(144, 89, 1, 1),
(145, 89, 15, 0),
(146, 90, 15, 0),
(147, 91, 15, 0),
(148, 92, 15, 0),
(149, 93, 16, 0),
(150, 94, 1, 1),
(151, 95, 16, 0),
(152, 94, 16, 0),
(153, 96, 16, 0),
(154, 97, 18, 0),
(155, 97, 17, 0),
(156, 98, 18, 0),
(157, 98, 17, 0),
(158, 99, 18, 0),
(159, 99, 17, 0),
(160, 100, 1, 1),
(161, 100, 17, 0),
(162, 100, 18, 0),
(163, 102, 1, 1),
(164, 103, 22, 0),
(165, 103, 21, 0),
(166, 103, 20, 0),
(167, 103, 19, 0),
(168, 102, 19, 0),
(169, 102, 20, 0),
(170, 102, 21, 0),
(171, 102, 22, 0),
(176, 104, 25, 0),
(177, 104, 24, 0),
(178, 104, 23, 0),
(179, 105, 1, 1),
(180, 106, 1, 1),
(181, 107, 27, 0),
(182, 107, 26, 0),
(183, 108, 27, 0),
(184, 108, 26, 0),
(185, 109, 1, 1),
(186, 110, 27, 0),
(187, 110, 26, 0),
(188, 109, 26, 0),
(189, 109, 27, 0),
(190, 105, 23, 0),
(191, 105, 24, 0),
(192, 105, 25, 0),
(195, 106, 23, 0),
(196, 106, 24, 0),
(197, 106, 25, 0),
(198, 111, 1, 1),
(199, 112, 29, 0),
(200, 112, 28, 0),
(201, 113, 29, 0),
(202, 113, 28, 0),
(203, 111, 28, 0),
(204, 111, 29, 0),
(205, 114, 1, 1),
(208, 114, 28, 0),
(209, 114, 29, 0),
(210, 115, 31, 0),
(211, 115, 30, 0),
(212, 116, 31, 0),
(213, 116, 30, 0),
(214, 117, 1, 1),
(215, 118, 31, 0),
(216, 118, 30, 0),
(217, 119, 31, 0),
(218, 119, 30, 0),
(219, 117, 30, 0),
(220, 117, 31, 0),
(221, 120, 35, 0),
(222, 120, 34, 0),
(223, 120, 33, 0),
(224, 121, 35, 0),
(225, 121, 34, 0),
(226, 121, 33, 0),
(227, 122, 35, 0),
(228, 122, 34, 0),
(229, 122, 33, 0),
(230, 123, 1, 1),
(231, 123, 33, 0),
(232, 123, 34, 0),
(233, 123, 35, 0),
(234, 124, 38, 0),
(235, 124, 37, 0),
(236, 124, 36, 0),
(237, 125, 38, 0),
(238, 125, 37, 0),
(239, 125, 36, 0),
(240, 126, 38, 0),
(241, 126, 37, 0),
(242, 126, 36, 0),
(243, 127, 38, 0),
(244, 127, 37, 0),
(245, 127, 36, 0),
(246, 128, 40, 0),
(247, 128, 39, 0),
(248, 129, 40, 0),
(249, 129, 39, 0),
(250, 130, 40, 0),
(251, 130, 39, 0),
(252, 131, 40, 0),
(253, 131, 39, 0),
(254, 132, 42, 0),
(255, 132, 41, 0),
(256, 133, 42, 0),
(257, 133, 41, 0),
(258, 134, 42, 0),
(259, 134, 41, 0),
(260, 135, 1, 1),
(261, 135, 41, 0),
(262, 135, 42, 0);

-- --------------------------------------------------------

--
-- Structure de la table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE IF NOT EXISTS `response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evaluation_id` int NOT NULL,
  `patient_id` int NOT NULL,
  `item_id` int NOT NULL,
  `text` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_3E7B0BFB456C5646` (`evaluation_id`),
  KEY `IDX_3E7B0BFB6B899279` (`patient_id`),
  KEY `IDX_3E7B0BFB126F525E` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `response`
--

INSERT INTO `response` (`id`, `evaluation_id`, `patient_id`, `item_id`, `text`, `audio`, `created_at`) VALUES
(209, 18, 19, 66, NULL, NULL, '2023-11-29 05:26:37'),
(210, 18, 19, 67, NULL, NULL, '2023-11-29 05:26:40'),
(211, 18, 19, 68, NULL, NULL, '2023-11-30 04:41:29');

-- --------------------------------------------------------

--
-- Structure de la table `school_grade`
--

DROP TABLE IF EXISTS `school_grade`;
CREATE TABLE IF NOT EXISTS `school_grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `school_grade`
--

INSERT INTO `school_grade` (`id`, `name`) VALUES
(1, 'PS'),
(2, 'MS'),
(3, 'GS'),
(4, 'CP'),
(5, 'CE1'),
(6, 'CE2'),
(7, 'CM1'),
(8, 'CM2'),
(9, '6e'),
(10, '5e'),
(11, '4e'),
(12, '3e');

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `response_id` int NOT NULL,
  `points` int NOT NULL,
  `value_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_included_in_total_score` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_329937511E27F6BF` (`question_id`),
  KEY `IDX_32993751FBF32840` (`response_id`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `score`
--

INSERT INTO `score` (`id`, `question_id`, `response_id`, `points`, `value_name`, `response_name`, `is_included_in_total_score`) VALUES
(279, 90, 209, 2, 'Correct', NULL, 1),
(280, 91, 210, 1, 'Transformation', NULL, 1),
(281, 92, 211, 2, 'Correct', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `template_question`
--

DROP TABLE IF EXISTS `template_question`;
CREATE TABLE IF NOT EXISTS `template_question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `test_id` int NOT NULL,
  `requires_audio` tinyint(1) NOT NULL,
  `requires_text` tinyint(1) NOT NULL,
  `is_included_in_total_score` tinyint(1) NOT NULL,
  `is_mcq` tinyint(1) NOT NULL,
  `is_custom_score` tinyint(1) NOT NULL,
  `instructions_fr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions_cr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E9A1793D1E5D0459` (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `template_question`
--

INSERT INTO `template_question` (`id`, `test_id`, `requires_audio`, `requires_text`, `is_included_in_total_score`, `is_mcq`, `is_custom_score`, `instructions_fr`, `instructions_cr`) VALUES
(1, 1, 0, 0, 1, 1, 0, 'Répétition du mot', ''),
(2, 2, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(3, 2, 0, 0, 0, 1, 0, 'Aide', NULL),
(4, 2, 0, 0, 1, 1, 0, 'Cotation', NULL),
(5, 3, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(6, 3, 0, 0, 0, 1, 0, 'Aide', NULL),
(7, 3, 0, 0, 1, 1, 0, 'Cotation', NULL),
(10, 5, 0, 1, 0, 0, 0, 'production de l\'enfant', NULL),
(13, 6, 0, 1, 0, 0, 0, 'productions', NULL),
(14, 6, 0, 0, 0, 1, 0, '1er item', NULL),
(15, 7, 0, 0, 0, 1, 0, 'Réussite/échec', NULL),
(16, 8, 0, 0, 0, 1, 0, 'points', NULL),
(17, 9, 0, 1, 0, 0, 0, 'Réponse du sujet', NULL),
(18, 9, 0, 0, 0, 0, 1, 'Point', NULL),
(19, 10, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(20, 10, 0, 0, 0, 0, 1, 'Reprise terme inter.', NULL),
(21, 10, 0, 0, 0, 0, 1, 'Placement correct', NULL),
(22, 10, 0, 0, 0, 0, 1, 'Enoncé adapté', NULL),
(23, 11, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(24, 11, 0, 0, 0, 0, 1, 'négation', NULL),
(25, 11, 0, 0, 0, 0, 1, 'temps', NULL),
(26, 12, 0, 1, 0, 0, 0, 'Réalisation de l\'enfant / observations', NULL),
(27, 12, 0, 0, 0, 0, 1, 'Réussite', NULL),
(28, 13, 0, 1, 0, 0, 0, 'Production du sujet', NULL),
(29, 13, 0, 0, 0, 0, 1, 'Correct', NULL),
(30, 14, 0, 1, 0, 0, 0, 'Production', NULL),
(31, 14, 0, 0, 0, 1, 0, 'point', NULL),
(32, 15, 0, 0, 0, 1, 0, 'cocher la bonne réponse', NULL),
(33, 16, 0, 1, 0, 0, 0, 'Correction / justification', NULL),
(34, 16, 0, 0, 0, 0, 1, 'Détection', NULL),
(35, 16, 0, 0, 0, 0, 1, 'Correction', NULL),
(36, 17, 0, 1, 0, 0, 0, 'Correction / justification', NULL),
(37, 17, 0, 0, 0, 0, 1, 'Détection', NULL),
(38, 17, 0, 0, 0, 0, 1, 'Correction', NULL),
(39, 18, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(40, 18, 0, 0, 0, 0, 1, 'Points', NULL),
(41, 19, 0, 1, 0, 0, 0, 'Production de l\'enfant', NULL),
(42, 19, 0, 0, 0, 0, 1, 'Points', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `template_value`
--

DROP TABLE IF EXISTS `template_value`;
CREATE TABLE IF NOT EXISTS `template_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_question_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complete_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2EA18BFB15DEE2DB` (`template_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `template_value`
--

INSERT INTO `template_value` (`id`, `template_question_id`, `name`, `complete_name`, `score`) VALUES
(1, 1, 'Correct', 'Item intégralement et correctement répété', 2),
(2, 1, 'Transformation', 'Transformation (substitution, inversion, ajout, omission de phonèmes ou syllabes)', 1),
(3, 1, 'Incorrect', 'Au moins deux transformations', 0),
(4, 3, 'A', 'Aide', 1),
(5, 3, 'EO', 'Ebauche orale', 1),
(6, 3, 'R', 'Répétition', 1),
(7, 4, 'FS', 'Production en français standard', 2),
(8, 4, 'VP', 'Production fait partie des variantes attendues', 1),
(9, 4, 'A', 'La production fait partie des variantes non attendues, erreurs phonologiques', 0),
(10, 6, 'A', 'Aide', 1),
(11, 6, 'EO', 'Ebauche orale', 1),
(12, 6, 'R', 'Répétition', 1),
(13, 7, 'FS', 'Production en français standard', 2),
(14, 7, 'VP', 'Production fait partie des variantes attendues', 1),
(15, 7, 'A', 'Fait partie des variantes non attendues, erreurs phonologiques', 0),
(16, 15, '+', 'réussite', 1),
(17, 15, '-', 'echec', 0),
(18, 16, 'i sa(r) / sava', 'i sa(r) / sava', 1),
(19, 16, 'la trann / la pou', 'la trann / la pou', 2),
(20, 16, 'la fine / fini', 'la fine / fini', 3),
(21, 31, 'IR', 'intégralement répété', 2),
(22, 31, 'PR', 'partiellement répété, si l\'énoncé n\'est pas correctement répété mais que les segments en gras le sont.', 1),
(23, 31, 'I', 'Incorrect', 0);

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_test_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_timed` tinyint(1) NOT NULL,
  `timer` int DEFAULT NULL,
  `instructions_fr` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions_cr` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `implementation_advice` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D87F7E0C367C6BAC` (`type_test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `test`
--

INSERT INTO `test` (`id`, `type_test_id`, `name`, `is_timed`, `timer`, `instructions_fr`, `instructions_cr`, `implementation_advice`, `slug`, `active`) VALUES
(1, 1, 'Épreuve de répétition de non-mots', 0, NULL, 'Je vais te dire des mots ; ce sont tous des mots qui ne veulent rien dire. Toi, tu dois seulement les répéter exactement comme je dis. Si tu n\'as pas bien entendu, tu me dis, et je répèterai. Tu es prêt ?', 'Mi sava dir aou bann mo ; bann mo la sé rienk mo i ve rien dir. I fo just ou répèt sèt mi di, parèy mèm sèt mi di. Si ou la pa bien antann, ou di amoin, é ma ardir aou. Lé bon ? Nou komans.', 'Chaque item peut être présenté deux fois. Arrêt de l\'épreuve au bout de 4 échecs consécutifs', '', 1),
(2, 1, 'Épreuve de dénomination', 0, NULL, 'Maintenant, on va regarder des images. Tu dois me dire ce que tu vois à chaque fois, comment ça s\'appelle. Tu es prêt ? Alors, qu\'est-ce c\'est ?', 'Minnan, nou sava regard in ta dzimaj. Ou doi dir amoin kosa ou voi, koman i apèl. Ou lé pré ? Alor nou komans. Kosa i lé ?', 'Si difficulté de dénomination, aider l\'enfant (phrase lacunaire ; définition ; explication et proposition de contextes). Si échec : le mot est donné, il est demandé à l\'enfant de répéter', '', 1),
(3, 1, 'Épreuve de répétition de mots complexes', 0, NULL, 'Maintenant, je vais te dire d\'autres mots ; ce sont des mots qui veulent dire quelque chose, mais des mots compliqués. Il y en a certains que tu ne vas pas connaître. Tu dois répéter exactement comme je dis. Si tu n\'as pas bien entendu, tu me dis, et je r', 'Minnan, mi sava dir aou dot mo ; sé bann mo i èksis, i ve dir in nafèr, selman sé bann mo konpliké. Riskab ou koné pa kosa i ve dir. I fo ou répèt sak mi di, parèy mèm. Si ou la pa bien antann, ou di amoin, ma ardir aou. Lé bon ? Nou komans.', 'Chaque item peut être proposé deux fois. Il n\'y a pas de seuil d\'arrêt', '', 1),
(5, 2, 'Epreuve de fluence verbale', 1, 60, 'On va faire autre chose. Maintenant, je vais te demander de me donner le plus de mots possibles, tous les mots que tu connais dans une famille de mots. Par exemple, toutes les couleurs que tu connais... Tu me dis tout ce que tu peux, et moi je te dirai stop au bout d\'un moment. Tu vois, je te chronomètre pour pouvoir dire stop. C\'est bon, tu as compris ?', '« Nou sava fé in not zafèr. Minnan i fo ou done amoin in ta in ta dmo, tout sèt ou koné, par eksanp tout le bann koulèr ou koné. Ou di amoin plin plin, é moin ma dir aou stop apré. Mi sa kronomèt aou é sé le kronomèt va dir kan nou arèt. Lé bon, ou la konpri ?', 'Lancer le chronomètre dès que l\'enfant a donné le premier mot. Expliquer la catégorie si nécessaire sans donner d\'exemple.', 'Epreuve-de-fluence-verbale', 1),
(6, 2, 'Epreuve de dénomination étendue', 0, NULL, 'On va regarder des images maintenant ; tu dois dire à chaque fois ce que tu vois, comment ça s\'appelle. Mais attention : à chaque fois, on peut dire de plusieurs façons différentes. Par exemple, si je te montre cette image [item exemple], qu\'est-ce que c\'est ? Oui, c\'est [...], mais on aurait aussi pu dire : un paletot, un linge, une veste... A chaque fois, tu dois me dire toutes les façons de dire. Tu es prêt ?', 'Minnan nou sa regard in ta dzimaj ; ou doi dir amoin shak foi kosa ou voi, koman i apèl. Selman, nou pe dir pluzièr fason ; par eksanp, si mi mont aou sèl-la [item exemple], kosa i lé ? Oui, sé [...], mé nou pouré di osi in palto, in linj, in vèst... Ou doi dir amoin tout le bann manièr nou pe apèl shak zafèr. Lé bon, ou lé pré ?', 'Proposer une aide sémantique ou phonologique en cas de difficulté de dénomination.', 'Epreuve-de-denomination-etendue', 1),
(7, 2, 'Epreuve de désignation', 0, NULL, 'On va regarder d\'autres images. Je vais te dire un mot, et toi, tu vas me montrer ce que j\'ai dis. C\'est bon, tu as compris ? Montre-moi...', '« Nou sava regard dot zimaj. Mi sa dir aou in mo, é ou, ou sava mont amoin kosa moin la di. Lé bon, ou la konpri ? Mont amoin...', 'Pas d\'item exemple ; pas de deuxième essai accepté. Cotation : cocher + si réussite ; entourer l\'item désigné à tort.', 'Epreuve-de-designation', 1),
(8, 3, 'Système verbal - compréhension', 0, NULL, 'Maintenant, on va regarder ces images. Ce sont des petites histoires : tu vois ici, c\'est l\'histoire d\'un monsieur qui joue avec un ballon. Tu peux me raconter l\'histoire ? Oui, c\'est ça : ici, on voit qu\'il va jouer ; on pourrait dire aussi qu\'il n\'a pas encore joué au début de l\'histoire. Là, à la fin, il a fini de jouer. Tu peux me montrer où le monsieur va lancer le ballon ? Où il n\'a pas encore lancé le ballon ? Où il a lancé le ballon ? D\'accord ! Maintenant, je vais te demander à chaque fois de montrer l\'image, comme on vient de faire. On commence.', 'Minnan, nou sa regard bann foto la. Sa sé bann ti zistoir : ou voi isi, sa zistoir in mesieu i joué èk in balon. Ou pe rakont amoin kosa i spas ? Sé sa mèm : isi, nou voi ali i sa joué ; nou pouré dir osi ke li la pankor joué. La, sé la fin, li la fine joué. Ou pe mont amoin ousa le mesieu i sa lans le balon ? Ousa li la pankor lans le balon ? Ousa li la fine lans le balon ? Lé bon ! Alé, minnan, mi demann aou shak foi mont amoin in zimaj, kom nou vien dfé. Lé bon ? Nou komans.', 'Chaque item peut être proposé deux fois.', 'Systeme-verbal-comprehension', 1),
(9, 3, 'Compréhension de questions', 0, NULL, 'Maintenant, on va jouer aux devinettes : tu sais ce que c\'est, une devinette ? Par exemple, si je te dis : c\'est quelque chose pour s\'assoir dessus, tu dois deviner ce que c\'est. Qu\'est-ce que tu me réponds ?', 'Minnan, nou sava joué devinèt : ou koné kosa i lé in devinèt ? Ou doi deviné kosa i lé. Par eksanp si mi di aou : sa in shoz nou asiz desu, kosa ou réponn amoin ?', NULL, 'Comprehension-de-questions', 0),
(10, 3, 'Production de questions', 0, NULL, 'Tout à l\'heure, je t\'ai posé plein de questions, maintenant, c\'est à toi de poser des questions. Tu vois ici, il y a plein d\'objets. On doit inventer une question pour chaque objet. Par exemple avec celui-là (le verre), qu\'est-ce qu\'on pourrait poser comme question ? Si je dis : qu\'est-ce... ». Réponse possible de l\'enfant : « Qu\'est-ce que c\'est ?', 'Moin la poz aou in ta kèstion taler, astèr sé out tour poz amoin dé kèstion. Ou voi isi, nana in ta zafèr. Nou doi invant in kèstion pou shak lobjé. Par eksanp èk sèl la (le vèr), kosa nou pouré pozé kom kèstion ? Si mi di : kosa... ». Réponse possible de l\'enfant : « Kosa i lé ? ». Lé bon, ou la konpri ? Nou komans alor.', 'Les termes interrogatifs peuvent être présentés deux fois. Le mime peut être utilisé pour aider l\'enfant. Cotation : 1 point si le terme interrogatif est repris ; 1 point s\'il est correctement placé dans l\'énoncé ; 1 point si l\'énoncé est sémantiquement adapté à la question.', 'Production-de-questions', 0),
(11, 3, 'Expression de la négation', 0, NULL, 'On va faire un jeu. Moi je te dis quelque chose, et toi tu dois me dire le contraire. Par exemple, si je dis \"Je m\'appelle X\", toi tu vas dire \"Non, je ne m\'appelle pas X\". C\'est bon ? Tu as compris ?', 'Nou sava fé in ti jeu : moin mi di aou in zafèr, é ou ou doi dir amoin le kontrèr. Par eksanp, si mi di \"Mi apèl X\", ou ou di \"Non, mi apèl pa X\". Lé bon ? Ou la konpri ?', 'Chaque énoncé peut être répété une fois. Cotation : + si la forme négative est produite (première colonne) ; + si le temps de l\'énoncé est respecté (deuxième colonne).', 'Expression-de-la-negation', 0),
(12, 3, 'Pronoms personnels – compréhension', 0, NULL, 'On va faire un jeu. Tu écoutes bien ce que je vais te dire et tu vas faire ce que je dis avec les petits bonhommes.', 'Nou sa fé in jeu. Ou ékout bien kosa mi di é ou fé sak mi di èk le bann ti bonom.', 'L\'énoncé n\'est proposé qu\'une fois. Si besoin, transcrire la réalisation de l\'enfant.', 'Pronoms-personnels-comprehension', 0),
(13, 3, 'Pronoms personnels - expression', 0, NULL, 'A toi maintenant ! Moi je fais et toi tu racontes ce que je fais. Préciser pour chaque item : « est-ce que tu peux aussi dire en français / en créole ?', 'Astèr sé out tour ! Amoin mi fé é sé ou ki rakont kosa mi fé.  Préciser pour chaque item :  Eske ou gingn rakont osi an fransé / an kréol ?', NULL, 'Pronoms-personnels-expression', 0),
(14, 3, 'Répétition d\'énoncés', 0, NULL, 'Je vais te raconter une histoire, l\'histoire d\'une petite fille qui s\'appelle Nana. Je vais te demander de répéter chaque phrase que je vais dire. C\'est bon, tu as compris ?', 'Mi sa rakont aou in zistoir, listoir inn ti fiy i apèl Nana. Mi sa demann aou répèt sak fraz ke mi sa di. Lé bon, ou la konpri ?', 'Chaque énoncé peut être répété deux fois. Arrêt de l\'épreuve au bout de 4 échecs consécutifs. Cotation : 2 points si l\'énoncé est intégralement répété ; 1 point si l\'énoncé n\'est pas correctement répété mais que les segments en gras le sont.', 'Repetition-d-enonces', 0),
(15, 4, 'Discrimination linguistique', 0, NULL, 'On va faire un jeu : je vais dire une phrase, et tu vas devoir trouver si c\'est du français, du créole, ou si c\'est une autre langue, autre chose. Pour t\'aider, voici des images (décrire les images et les laisser devant l\'enfant). Tu peux dire quelle langue c\'est ou me montrer sur les images à quoi ça te fait penser.', 'Nou sa fé in jeu. Mi sar dir aou in fraz, é ou doi dir amoin si mi koz an fransé, an kréol sinonsa dann in not lang. Ou peu dir amoin kèl lang i lé, ou ou gingn mont amoin in zimaj isi (décrire les images et les laisser devant l\'enfant). Ou mont amoin le zimaj ou mazine i va bien èk sak ou antann', 'Tous les items peuvent être répétés deux fois.', 'Discrimination-linguistique', 0),
(16, 4, 'Détection d\'erreurs en créole', 0, NULL, 'Maintenant on va écouter des phrases. Tu vas me dire si les phrases sont correctes, ou s\'il y a une erreur. S\'il y a une erreur, tu dois me dire comment il faut dire ». Faire l\'item exemple.', 'Astèr nou sa ékout bann fraz. Ou sa dir amoin si le bann fraz lé bien di, oubien sa si nana in lérer. Si le fraz lé mal di, ou va dir amoin koman i fo dir. Faire l\'item exemple avec l\'enfant.', 'Cotation : 1ère colonne : 1 point si erreur remarquée ; 2e colonne : 1 point si erreur correctement corrigée.', 'Detection-d-erreurs-en-creole', 0),
(17, 4, 'Détection d\'erreurs en français', 0, NULL, 'On continue : maintenant je vais te dire des phrases en français, et tu vas me dire si c\'est bien dit ou s\'il y a des erreurs, comme on vient de faire', 'Aster, mi sar dir aou bann fraz an fransé, ou sa dir amoin si lé bien di oubien sa si néna fot anndan. Lé kom nou vienn fé.', 'Cotation : 1ère colonne : 1 point si erreur remarquée ; 2e colonne : 1 point si erreur correctement corrigée.', 'Detection-d-erreurs-en-francais', 0),
(18, 5, 'Traduction créole → français', 0, NULL, '« Je te présente X. X habite à La Réunion, et il/elle ne parle que créole. Il/elle ne sait pas parler français, mais X a vraiment envie d\'apprendre. Alors il/elle va te dire des phrases en créole, et toi tu vas lui dire comment on dit en français, pour qu\'il / elle apprenne. Je te donne un exemple : en créole on dit \"in brinjèl\". X va te demander comment on dit \"in brinjèl\" en français. Et toi tu dois lui répondre : en français, on dit \"une aubergine\". C\'est bon, tu as compris ? ». (faire les items exemples avec l\'enfant)', 'Mi présant aou X. X i abit La Rénion, é li koz rienk kréol. Li koné pa koz fransé, mé li ve aprann. Alor X i sa dir aou bann fraz an kréol, é ou ou va dir ali koman i di an fransé, komsa li gingn aprann. Mi done aou in lèksanp : an kréol nou di \"in brinjèl\". X va demann aou koman i di \"in brinjèl\" an fransé. É ou doi réponn ali : an fransé, i di \"une aubergine\". Lé bon, ou la konpri ? (faire les items exemples avec l\'enfant)', 'Epreuve arrêtée après les items exemples si l\'enfant est en trop grande difficulté. Répétition des énoncés possible une fois ; amorcer la réponse en guide d\'aide si besoin.', 'Traduction-creole-francais', 0),
(19, 5, 'Traduction français → créole', 0, NULL, '« Je te présente X. X habite à La Réunion, et il/elle ne parle que français. Il/elle ne sait pas parler créole, mais X a vraiment envie d\'apprendre. Alors il/elle va te dire des phrases en français, et toi tu vas lui dire comment on dit en créole, pour qu\'il / elle apprenne. Je te donne un exemple : en français on dit \"comment ça va\". X va te demander comment on dit \"comment ça va\" en créole. Et toi tu vas lui répondre : en créole, on dit \"koman i lé\". C\'est bon, tu as compris ? ». (faire les items exemples avec l\'enfant)', '« Mi présant aou X. X i abit La Rénion, é li koz rienk fransé. Li koné pa koz kréol, mé li ve aprann. Alor X i sa dir aou bann fraz an fransé, é ou ou va dir ali koman i di an kréol, komsa li gingn aprann. Mi done aou in lèksanp : an fransé nou di \"comment ça va\". X va demann aou koman i di \"comment ça va\" an kréol. É ou doi réponn ali : an kréol, i di \"koman i lé\". Lé bon, ou la konpri ? » (faire les items exemples avec l\'enfant)', 'Epreuve arrêtée après les items exemples si l\'enfant est en trop grande difficulté. Répétition des énoncés possible une fois ; amorcer la réponse en guide d\'aide si besoin.', 'Traduction-francais-creole', 0);

-- --------------------------------------------------------

--
-- Structure de la table `test_type`
--

DROP TABLE IF EXISTS `test_type`;
CREATE TABLE IF NOT EXISTS `test_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `test_type`
--

INSERT INTO `test_type` (`id`, `name`) VALUES
(1, 'Phonologie'),
(2, 'Lexique'),
(3, 'Morphosyntaxe'),
(4, 'Métalinguistique'),
(5, 'Bilingue');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `no_adeli` int NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` int DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inscription_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `reset_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` smallint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649834921FB` (`no_adeli`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `last_name`, `name`, `phone`, `create_at`, `no_adeli`, `status`, `address`, `zipcode`, `city`, `inscription_status`, `is_verified`, `reset_token`, `active`) VALUES
(12, 'admin@demo.fr', '[\"ROLE_ADMIN\"]', '$2y$13$lUQr4yHx2Wx/AgzGrqJaYu0o17D/sIvq9Oao0.0oBWx5nuKqPzX9a', 'Admin', 'Admin', NULL, '2023-11-15 05:36:24', 0, 'null', '7 Rue jean Moulin', 97440, 'Saint denis', 'valide', 1, '123131531', 0),
(13, 'utilisateur@gmail.com', '[\"ROLE_PATIENT_ADMIN\"]', '$2y$13$/r7ZwhoXY.a/oW0DVbmRN.TY/7ws30bNDHWfR5flhCL9xGXecuwHy', 'Utilisateur', 'Profesionnel', '0693004809', '2023-11-15 06:11:50', 985632, 'Etudiant', 'Rue jean bob', 97419, 'Posession', 'valide', 1, '', 0),
(15, 'beriche@gmail.com', '[]', '$2y$13$3AYMqs1io.6onawBHXVH6.DVV64MC.Jsru3wQeeMNo.4Sz.LMGChq', 'Chahalane', 'Beriche', '0693004801', '2023-11-15 11:16:50', 98653296, 'Etudiant', '3 rue des jacques', 97480, 'saint louis', 'valide', 1, '', 1),
(22, 'alex@gmail.com', '[]', '$2y$13$AHSEazzoh5dDIu..8ZVCW.qtJjITW2BGIauDuwJM.4cxXaZkh8QFS', 'Tam-Hui', 'Alexandre', '0695803204', '2023-11-28 06:20:53', 236598745, 'Etudiant', 'ST DENIS', 97400, 'Saint-Denis', 'valide', 1, '', 1),
(23, 'bebeto@gmail.com', '[]', '$2y$13$fH.Hn3ULSRkHzM1WtDnRoObe7yX0cgTvDSoeeHgKRQgF0OI2iJvVO', 'Beriche', 'Chahalane', '06925899631', '2023-11-30 04:44:21', 987456123, 'Etudiant', '10 A Rue Saint Denis', 97450, 'Saint Louis', 'valide', 0, NULL, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `FK_1323A5751E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `FK_1323A5756B899279` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `FK_1323A575A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `illustration`
--
ALTER TABLE `illustration`
  ADD CONSTRAINT `FK_D67B9A42126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E1E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `FK_1F1B251E5F95EC` FOREIGN KEY (`school_grade_id`) REFERENCES `school_grade` (`id`);

--
-- Contraintes pour la table `option_response`
--
ALTER TABLE `option_response`
  ADD CONSTRAINT `FK_1E0C7A5F1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `FK_1E0C7A5FA6768BD1` FOREIGN KEY (`template_value_id`) REFERENCES `template_value` (`id`);

--
-- Contraintes pour la table `option_response_media_option_response`
--
ALTER TABLE `option_response_media_option_response`
  ADD CONSTRAINT `FK_3CAE18E9AA589275` FOREIGN KEY (`option_response_media_id`) REFERENCES `option_response_media` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3CAE18E9DDC771F4` FOREIGN KEY (`option_response_id`) REFERENCES `option_response` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `FK_1ADAD7EB5F95EC` FOREIGN KEY (`school_grade_id`) REFERENCES `school_grade` (`id`);

--
-- Contraintes pour la table `patient_user`
--
ALTER TABLE `patient_user`
  ADD CONSTRAINT `FK_4029B816B899279` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4029B81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494E126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_B6F7494E15DEE2DB` FOREIGN KEY (`template_question_id`) REFERENCES `template_question` (`id`);

--
-- Contraintes pour la table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `FK_3E7B0BFB126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_3E7B0BFB456C5646` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation` (`id`),
  ADD CONSTRAINT `FK_3E7B0BFB6B899279` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`);

--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `FK_329937511E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `FK_32993751FBF32840` FOREIGN KEY (`response_id`) REFERENCES `response` (`id`);

--
-- Contraintes pour la table `template_question`
--
ALTER TABLE `template_question`
  ADD CONSTRAINT `FK_E9A1793D1E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);

--
-- Contraintes pour la table `template_value`
--
ALTER TABLE `template_value`
  ADD CONSTRAINT `FK_2EA18BFB15DEE2DB` FOREIGN KEY (`template_question_id`) REFERENCES `template_question` (`id`);

--
-- Contraintes pour la table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `FK_D87F7E0C367C6BAC` FOREIGN KEY (`type_test_id`) REFERENCES `test_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
