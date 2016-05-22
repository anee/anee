-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Počítač: wm85.wedos.net:3306
-- Vygenerováno: Ned 25. říj 2015, 17:58
-- Verze serveru: 5.6.23
-- Verze PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `d98237_main`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) DEFAULT NULL,
  `track_id` int(11) DEFAULT NULL,
  `file_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file_path` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14B78418DA6A219` (`place_id`),
  KEY `IDX_14B784185ED23C43` (`track_id`),
  KEY `IDX_14B78418A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Vypisuji data pro tabulku `photo`
--

INSERT INTO `photo` (`id`, `place_id`, `track_id`, `file_name`, `file_path`, `date`, `user_id`) VALUES
(1, 5, 41, 'Photo-28.06.14-17-25-09.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-28.06.14-17-25-09.jpg', '2014-06-28 14:23:09', 1),
(5, 3, NULL, 'Photo-06.06.14-23-09-42.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-06.06.14-23-09-42.jpg', '2014-06-06 23:09:42', 1),
(6, 3, NULL, 'Photo-13.05.14-18-31-51.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-13.05.14-18-31-51.jpg', '2014-05-13 18:31:51', 1),
(7, 3, NULL, 'Photo-15.04.14-18-14-36.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-15.04.14-18-10-17.jpg', '2014-04-15 18:14:36', 1),
(8, 3, NULL, 'Photo-15.06.14-19-44-57.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-15.06.14-19-44-57.jpg', '2014-06-15 19:44:57', 1),
(9, 3, NULL, 'Photo-20.05.14-16-07-54.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-20.05.14-16-07-54.jpg', '2014-05-20 16:07:54', 1),
(10, 3, NULL, 'Photo-20.05.14-16-35-11.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-20.05.14-16-35-11.jpg', '2014-05-20 16:35:11', 1),
(11, 3, NULL, 'Photo-22.04.14-17-13-24.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-22.04.14-17-13-24.jpg', '2014-04-22 17:13:24', 1),
(12, 7, 41, 'Photo-22.06.14-20-45-20.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-22.06.14-20-45-20.jpg', '2014-06-22 20:45:20', 1),
(13, NULL, 41, 'Photo-24.06.14-16-18-59.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-24.06.14-16-18-59.jpg', '2014-06-24 16:18:59', 1),
(14, NULL, 41, 'Photo-24.06.14-20-08-42.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-24.06.14-20-08-42.jpg', '2014-06-24 20:08:42', 1),
(15, NULL, 41, 'Photo-27.06.14-14-27-48.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-27.06.14-14-27-48.jpg', '2014-06-27 14:27:48', 1),
(16, 3, NULL, 'Photo-28.05.14-20-09-21.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-28.05.14-20-09-21.jpg', '2014-05-28 20:09:21', 1),
(17, 5, 41, 'Photo-28.06.14-17-25-34.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-28.06.14-17-25-34.jpg', '2014-06-28 17:25:34', 1),
(18, 6, 41, 'Photo-29.06.14-10-15-14.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-29.06.14-10-15-14.jpg', '2014-06-29 10:15:14', 1),
(19, 6, 41, 'Photo-29.06.14-10-16-33.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/Photo-29.06.14-10-16-33.jpg', '2014-06-29 10:16:33', 1),
(21, 12, 51, '2015-02-08-17.32.08.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-08-17.32.08.jpg', '2015-02-08 17:30:13', 1),
(22, 11, 51, '2015-02-10-13.58.41.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-10-13.58.41.jpg', '2015-02-10 09:45:00', 1),
(23, 11, 51, '2015-02-10-15.26.22.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-10-15.26.22.jpg', '2015-02-10 15:00:00', 1),
(24, 11, 51, '2015-02-11-10.54.02.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-11-10.54.02.jpg', '2015-02-11 23:50:01', 1),
(26, 11, 51, '2015-02-11-11.00.56.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-11-11.00.56.jpg', '2015-02-11 23:58:53', 1),
(27, 11, 51, '2015-02-11-11.01.58.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-11-11.01.58.jpg', '2015-02-11 23:55:00', 1),
(28, 11, 51, '2015-02-12-18.45.47.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-12-18.45.47.jpg', '2015-02-12 17:00:00', 1),
(29, 11, 51, '2015-02-14-15.47.22.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-15.47.22.jpg', '2015-02-14 20:30:28', 1),
(30, 11, 51, '2015-02-14-15.56.37.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-15.56.37.jpg', '2015-02-14 20:32:17', 1),
(31, 11, 51, '2015-02-14-16.01.17.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-16.01.17.jpg', '2015-02-14 20:39:50', 1),
(32, 11, 51, '2015-02-14-16.14.05.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-16.14.05.jpg', '2015-02-14 20:41:20', 1),
(33, 11, 51, '2015-02-14-16.24.36.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-16.24.36.jpg', '2015-02-14 21:19:49', 1),
(34, 11, 51, '2015-02-14-16.42.06.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-16.42.06.jpg', '2015-02-14 21:20:40', 1),
(35, 11, 51, '2015-02-14-16.46.33.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-14-16.46.33.jpg', '2015-02-14 21:21:51', 1),
(37, 11, 51, '2015-02-19-12.27.58.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-02-19-12.27.58.jpg', '2015-02-19 13:50:06', 1),
(39, 11, 51, '2015-03-31-18.51.21.jpg', '/data/web/virtuals/53977/virtual/www/subdom/anee/app/data/users/1/photos/2015-03-31-18.51.21.jpg', '2015-03-31 19:00:00', 1),
(43, 11, NULL, '2015-04-04-23.52.00.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-04-23.52.00.jpg', '2015-04-04 23:20:00', 1),
(44, 13, NULL, '2015-04-04-12.57.57.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-04-12.57.57.jpg', '2015-04-04 13:20:00', 1),
(45, 11, NULL, 'image.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/image.jpg', '2015-04-07 14:00:00', 1),
(46, 11, NULL, '2015-04-21-00.06.56.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-21-00.06.56.jpg', '2015-04-20 23:30:00', 1),
(47, 11, NULL, '2015-04-21-00.31.43.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-21-00.31.43.jpg', '2015-04-21 01:00:00', 1),
(50, 14, NULL, '2015-04-22-16.38.46.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-22-16.38.46.jpg', '2015-04-22 15:30:00', 1),
(53, 14, NULL, '2015-04-22-16.46.49.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-04-22-16.46.49.jpg', '2015-04-22 15:30:00', 1),
(60, 11, NULL, '2015-05-09-23.07.16.jpg', '/data/web/virtuals/98237/virtual/www/app/data/users/1/photos/2015-05-09-23.07.16.jpg', '2015-05-09 23:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `place`
--

CREATE TABLE IF NOT EXISTS `place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_741D53CDA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Vypisuji data pro tabulku `place`
--

INSERT INTO `place` (`id`, `name`, `user_id`, `name_url`) VALUES
(1, 'Nová Bystřice', 1, 'nova-bystrice'),
(3, 'Brno', 1, 'brno'),
(4, 'Jindřichův Hradec', 1, 'jindrichuv-hradec'),
(5, 'Rijeka', 1, 'rijeka'),
(6, 'Salzburk', 1, 'salzburk'),
(7, 'Wien', 1, 'wien'),
(8, 'Bla bla', 10, 'bla-bla'),
(9, 'Nova Bystrice', 10, 'nova-bystrice'),
(10, 'Hradec', 10, 'hradec'),
(11, 'Sevilla', 1, 'sevilla'),
(12, 'Prague', 1, 'prague'),
(13, 'Huelva', 1, 'huelva'),
(14, 'Sanlucar De Barrameda', 1, 'sanlucar-de-barrameda');

-- --------------------------------------------------------

--
-- Struktura tabulky `track`
--

CREATE TABLE IF NOT EXISTS `track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transport_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `place_to_id` int(11) DEFAULT NULL,
  `distance` double NOT NULL,
  `time_in_seconds` double NOT NULL,
  `max_speed` double NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pinned` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D6E3F8A69909C13F` (`transport_id`),
  KEY `IDX_D6E3F8A6DA6A219` (`place_id`),
  KEY `IDX_D6E3F8A699435146` (`place_to_id`),
  KEY `IDX_D6E3F8A6A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=92 ;

--
-- Vypisuji data pro tabulku `track`
--

INSERT INTO `track` (`id`, `transport_id`, `place_id`, `place_to_id`, `distance`, `time_in_seconds`, `max_speed`, `date`, `user_id`, `pinned`) VALUES
(1, 1, 1, 1, 48.84, 7620, 63.84, '2014-08-26 18:00:00', 1, 0),
(2, 1, 1, 1, 57.47, 8110, 57.81, '2014-08-25 18:00:00', 1, 0),
(3, 1, 1, 1, 29.44, 4521, 55.21, '2014-08-24 18:00:00', 1, 0),
(4, 1, 1, 1, 43.32, 6194, 60.67, '2014-08-23 18:00:00', 1, 0),
(5, 1, 1, 1, 31.94, 4594, 54.23, '2014-08-12 18:00:00', 1, 0),
(6, 1, 1, 1, 45.92, 6228, 56.74, '2014-08-10 18:00:00', 1, 0),
(7, 1, 1, 1, 43.58, 6145, 59.5, '2014-08-06 18:00:00', 1, 0),
(8, 1, 1, 1, 24.19, 3286, 59.5, '2014-08-04 18:00:00', 1, 0),
(9, 1, 1, 1, 28.04, 4266, 47.45, '2014-08-02 18:00:00', 1, 0),
(10, 1, 1, 1, 25.08, 3874, 49.65, '2014-08-01 18:00:00', 1, 0),
(11, 1, 1, 1, 59.9, 9290, 60.67, '2014-07-25 18:00:00', 1, 0),
(12, 1, 1, 1, 23.49, 3615, 58.92, '2014-07-23 18:00:00', 1, 0),
(13, 1, 1, 1, 24.02, 3601, 47.88, '2014-07-16 18:00:00', 1, 0),
(14, 1, 1, 1, 22.82, 3529, 53.62, '2014-07-06 18:00:00', 1, 0),
(15, 1, 1, 1, 23.16, 3521, 51.56, '2014-06-15 18:00:00', 1, 0),
(16, 1, 1, 1, 36.18, 6563, 53.62, '2014-06-07 18:00:00', 1, 0),
(17, 1, 1, 1, 71.33, 9764, 62.67, '2014-08-28 18:00:00', 1, 0),
(18, 1, 1, 1, 27.99, 4262, 53.09, '2014-08-30 18:00:00', 1, 0),
(19, 1, 1, 1, 27.82, 3682, 59.5, '2014-08-31 18:00:00', 1, 0),
(20, 1, 1, 1, 84.54, 11563, 61.28, '2014-09-03 18:00:00', 1, 0),
(21, 1, 1, 1, 46.25, 6496, 61.28, '2014-09-06 18:00:00', 1, 0),
(22, 1, 1, 1, 11.27, 1307, 58.92, '2014-09-07 18:00:00', 1, 0),
(23, 1, 1, 1, 109.97, 15676, 66.93, '2014-09-09 15:00:00', 1, 0),
(24, 1, 1, 1, 78.7, 10659, 53.62, '2014-09-12 15:00:00', 1, 0),
(25, 1, 1, 1, 38.94, 5260, 50.11, '2014-09-13 16:00:00', 1, 0),
(26, 1, 1, 1, 82.99, 11082, 51.07, '2014-09-15 15:00:00', 1, 0),
(27, 1, 1, 1, 52.52, 7129, 60.08, '2014-09-19 16:00:00', 1, 0),
(28, 2, 1, 1, 5.63, 2274, 16, '2014-09-16 15:00:00', 1, 0),
(29, 1, 3, 3, 62.98, 10341, 61.28, '2014-09-21 11:00:00', 1, 0),
(30, 1, 3, 3, 27.64, 4301, 58.92, '2014-09-23 14:00:00', 1, 0),
(31, 1, 3, 3, 31.44, 4533, 56.74, '2014-09-25 16:00:00', 1, 0),
(32, 2, 1, 1, 5.38, 3127, 17.3, '2014-09-27 16:00:00', 1, 0),
(33, 2, 1, 1, 6.8, 2445, 26.7, '2014-09-28 16:00:00', 1, 0),
(34, 1, 3, 3, 27.39, 3768, 59.5, '2014-09-30 16:00:00', 1, 0),
(35, 1, 1, 1, 48.23, 6916, 61.28, '2014-10-02 16:00:00', 1, 0),
(36, 2, 1, 1, 9.14, 2993, 17.8, '2014-10-04 17:00:00', 1, 0),
(38, 2, 1, 1, 9.14, 3143, 22.4, '2014-10-05 16:00:00', 1, 0),
(39, 1, 3, 3, 57.23, 7783, 60.67, '2014-10-07 13:00:00', 1, 0),
(40, 1, 3, 3, 26.44, 3477, 60.67, '2014-10-09 16:00:00', 1, 0),
(41, 1, 1, 5, 847.78, 604800, 0, '2014-06-28 18:00:00', 1, 1),
(42, 1, 1, 3, 147.43, 20484, 60.64, '2014-10-12 09:00:00', 1, 0),
(43, 1, 3, 3, 66.14, 9064, 57.27, '2014-10-14 15:00:00', 1, 0),
(44, 1, 3, 3, 43.84, 5474, 60.67, '2014-10-16 16:00:00', 1, 0),
(45, 2, 1, 1, 9.8, 2220, 0, '2014-10-18 17:00:00', 1, 0),
(46, 2, 1, 1, 6.64, 2406, 0, '2014-11-22 16:00:00', 1, 0),
(47, 1, 1, 1, 9.49, 1406, 45.06, '2014-12-21 16:00:00', 1, 0),
(48, 3, 9, 10, 45645, 183050, 64, '2014-12-27 00:45:12', 10, 1),
(49, 2, 1, 1, 7.38, 2922, 23.6, '2015-01-10 16:00:00', 1, 0),
(50, 1, 1, 1, 12.7, 2167, 44.19, '2015-01-25 14:00:00', 1, 0),
(51, 4, 11, 11, 0, 0, 0, '2015-02-08 17:00:00', 1, 1),
(52, 2, 11, 11, 2.6, 1442, 11, '2015-03-08 23:57:45', 1, 0),
(53, 2, 11, 11, 3.78, 2090, 0, '2015-03-10 21:30:00', 1, 0),
(54, 2, 11, 11, 8.35, 2915, 0, '2015-03-12 21:00:00', 1, 0),
(55, 2, 11, 11, 7.6, 2296, 0, '2015-03-14 21:00:00', 1, 0),
(56, 2, 11, 11, 3.59, 2280, 32.7, '2015-03-23 22:00:00', 1, 0),
(57, 2, 11, 11, 4.21, 2460, 31.4, '2015-03-25 22:00:00', 1, 0),
(58, 2, 11, 11, 6.15, 2892, 32.6, '2015-04-08 22:25:00', 1, 0),
(59, 2, 11, 11, 4.66, 2491, 24.6, '2015-04-15 22:00:00', 1, 0),
(60, 2, 11, 11, 7.85, 3418, 30.8, '2015-04-24 22:00:00', 1, 0),
(61, 1, 11, 11, 5.15, 2518, 0, '2015-04-26 22:00:00', 1, 0),
(62, 2, 11, 11, 6.05, 2394, 20.5, '2015-05-08 23:00:00', 1, 0),
(63, 2, 11, 11, 5.06, 1831, 0, '2015-05-23 22:00:00', 1, NULL),
(64, 2, 11, 11, 4.89, 2329, 22.2, '2015-06-18 22:00:00', 1, 0),
(65, 1, 1, 1, 23.46, 3577, 56.22, '2015-07-09 18:00:00', 1, NULL),
(66, 1, 1, 1, 23.65, 3275, 55.71, '2015-07-10 18:00:00', 1, NULL),
(67, 1, 1, 1, 16.81, 2590, 52.06, '2015-07-11 17:00:00', 1, NULL),
(68, 1, 1, 1, 59.26, 8251, 65.66, '2015-07-18 17:00:00', 1, NULL),
(69, 1, 1, 1, 21.41, 2950, 62.11, '2015-07-19 19:00:00', 1, NULL),
(70, 1, 1, 1, 9.35, 1312, 50.59, '2015-07-20 19:00:00', 1, NULL),
(71, 1, 1, 1, 73.99, 11751, 58.36, '2015-07-22 15:00:00', 1, NULL),
(72, 1, 1, 1, 75.62, 11678, 55.71, '2015-07-25 14:00:00', 1, NULL),
(73, 1, 1, 1, 65.28, 9537, 62.67, '2015-07-28 15:00:00', 1, NULL),
(74, 1, 1, 1, 31.73, 4139, 53.09, '2015-08-01 18:00:00', 1, NULL),
(75, 1, 1, 1, 55.07, 7815, 56.22, '2015-08-09 15:00:00', 1, NULL),
(76, 1, 1, 1, 22.64, 3683, 52.57, '2015-08-18 19:00:00', 1, NULL),
(77, 1, 1, 1, 14.42, 1782, 57.2, '2015-08-20 18:00:00', 1, NULL),
(78, 1, 1, 1, 8.23, 1022, 51.56, '2015-08-20 19:00:00', 1, NULL),
(79, 1, 1, 1, 18.67, 2306, 57.27, '2015-08-21 19:00:00', 1, NULL),
(80, 1, 1, 1, 34.52, 4575, 57.81, '2015-08-22 18:00:00', 1, NULL),
(81, 1, 1, 1, 22, 2988, 54.23, '2015-08-23 18:00:00', 1, NULL),
(82, 1, 1, 1, 33.46, 4100, 56.74, '2015-08-24 19:00:00', 1, NULL),
(84, 1, 1, 1, 13.52, 2152, 51.56, '2015-08-27 18:00:00', 1, NULL),
(85, 1, 1, 1, 32.11, 4040, 62.67, '2015-08-28 18:00:00', 1, NULL),
(86, 1, 1, 1, 17.2, 3284, 50.59, '2015-08-29 19:00:00', 1, NULL),
(87, 1, 1, 1, 29.08, 4329, 50.59, '2015-09-24 17:00:00', 1, NULL),
(88, 2, 1, 1, 9, 3600, 0, '2015-09-25 10:00:00', 1, NULL),
(89, 1, 1, 1, 20.36, 2724, 54.72, '2015-10-03 17:00:00', 1, NULL),
(90, 1, 1, 1, 43.83, 6293, 62.11, '2015-10-17 16:00:00', 1, NULL),
(91, 1, 1, 1, 20.88, 2834, 52.06, '2015-10-25 16:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `track_user`
--

CREATE TABLE IF NOT EXISTS `track_user` (
  `user_id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`track_id`),
  KEY `IDX_10C5FE4CA76ED395` (`user_id`),
  KEY `IDX_10C5FE4C5ED23C43` (`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_66AB212EA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `transport`
--

INSERT INTO `transport` (`id`, `name`, `user_id`) VALUES
(1, 'cycling', 1),
(2, 'running', 1),
(3, 'Bla', 10),
(4, 'erasmus', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL,
  `forename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_visited_home` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `username`, `username_url`, `email`, `password`, `public`, `forename`, `surname`, `profile_image`, `background_image`, `last_login`, `last_visited_home`) VALUES
(1, 'ldrahnik', 'ldrahnik', 'L.Drahnik@gmail.com', '$2y$10$MHnn4exi9.RKhzOpbEhYvuHD17Sv/p/FyIfAXqN8bcLMo9rKHGDES', 1, 'Lukáš', 'Drahník', 'Photo-28.06.14-17-25-34.jpg', 'Anee-redesign-bg.png', '2015-10-03 19:05:06', '2015-10-03 19:04:45'),
(10, 'Scrash', 'scrash', 'jirka.wb@gmail.com', '$2y$10$0i2L.y8aa/5rm8Hwb6lQtOtPB7o.JZqNHii1rFdPxHX9ep.PiMCfa', 0, 'Bla', 'BlaBla', NULL, NULL, '2014-12-27 00:46:33', '2014-12-27 00:44:09'),
(12, 'Hyncus', 'hyncus', 'bajzany@seznam.cz', '$2y$10$S1Y8f.0ohyQn9W0E1ajyuekDbvhb5GIgJnXyb317HSvVzHTqVfM5C', 1, 'Hyncus', 'Hyncus', NULL, NULL, '2015-04-09 23:11:11', '2015-04-09 22:57:03');

-- --------------------------------------------------------

--
-- Struktura tabulky `user_user`
--

CREATE TABLE IF NOT EXISTS `user_user` (
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`follower_id`),
  KEY `IDX_F7129A80A76ED395` (`user_id`),
  KEY `IDX_F7129A80AC24F853` (`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B784185ED23C43` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`),
  ADD CONSTRAINT `FK_14B78418A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_14B78418DA6A219` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);

--
-- Omezení pro tabulku `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `FK_741D53CDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omezení pro tabulku `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `FK_D6E3F8A69909C13F` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`),
  ADD CONSTRAINT `FK_D6E3F8A699435146` FOREIGN KEY (`place_to_id`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `FK_D6E3F8A6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D6E3F8A6DA6A219` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);

--
-- Omezení pro tabulku `track_user`
--
ALTER TABLE `track_user`
  ADD CONSTRAINT `FK_10C5FE4C5ED23C43` FOREIGN KEY (`track_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10C5FE4CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `track` (`id`);

--
-- Omezení pro tabulku `transport`
--
ALTER TABLE `transport`
  ADD CONSTRAINT `FK_66AB212EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omezení pro tabulku `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `FK_F7129A80A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F7129A80AC24F853` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
