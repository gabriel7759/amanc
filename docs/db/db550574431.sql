-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `newwindow` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `log_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `activity` (`id`, `state_id`, `title`, `summary`, `content`, `thumbnail`, `url`, `newwindow`, `position`, `status`, `is_deleted`, `log_id`) VALUES
(1,	5,	'Actividad uno mod',	'Resumen',	'<p>Actividad uno modificada</p>\n',	'547c059def32csmoke.jpg',	'',	0,	0,	1,	0,	67),
(2,	9,	'Actividad 2',	'Resumen de actividad 2',	'<p>Contenido de actividad 2</p>\n',	'547c0700a942cshakespeare.jpeg',	'',	0,	0,	1,	0,	69),
(3,	8,	'Actividad 3',	'',	'',	'',	'',	0,	0,	1,	0,	70),
(4,	20,	'Actividad 4',	'',	'',	'',	'',	0,	0,	1,	0,	71),
(5,	20,	'Actividad 6',	'Este es el resumen',	'',	'547c0861cfbd6shakespeare.jpeg',	'',	0,	0,	1,	0,	77);

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area_id` int(11) NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `contactdate` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(3) NOT NULL DEFAULT '0',
  `log_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `contactarea`;
CREATE TABLE `contactarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `log_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_abstract` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` text COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL DEFAULT '0',
  `in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `log_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content` (`id`, `id_parent`, `title`, `subtitle`, `url`, `content`, `seo_title`, `seo_keywords`, `seo_abstract`, `seo_description`, `link`, `status`, `position`, `in_menu`, `is_deleted`, `log_id`) VALUES
(1,	0,	'Lo que hacemos',	'',	'lo-que-hacemos',	'',	'',	'',	'',	'',	'',	1,	1,	0,	0,	17),
(2,	0,	'Quienes somos',	'',	'quienes-somos',	'',	'',	'',	'',	'',	'',	1,	11,	0,	0,	18),
(3,	0,	'Modelo de acompañamiento',	'',	'modelo-de-acompanamiento',	'',	'',	'',	'',	'',	'',	1,	12,	1,	0,	19),
(4,	1,	'Actividades',	'',	'actividades',	'',	'',	'',	'',	'',	'',	1,	2,	0,	0,	20),
(5,	1,	'Noticias',	'',	'noticias',	'',	'',	'',	'',	'',	'',	1,	3,	0,	0,	21),
(6,	1,	'Voluntariado',	'',	'voluntariado',	'',	'',	'',	'',	'',	'',	1,	4,	0,	0,	22),
(7,	1,	'Sistema Amanc',	'',	'sistema-amanc',	'',	'',	'',	'',	'',	'',	1,	5,	0,	0,	23),
(8,	1,	'Aliados',	'',	'aliados',	'',	'',	'',	'',	'',	'',	1,	6,	0,	0,	24),
(9,	1,	'Noticias',	'',	'noticias',	'',	'',	'',	'',	'',	'',	1,	7,	0,	0,	25),
(10,	1,	'Escuelas amigas',	'',	'escuelas-amigas',	'',	'',	'',	'',	'',	'',	1,	8,	0,	0,	26),
(11,	1,	'Maratón',	'',	'maraton',	'',	'',	'',	'',	'',	'',	1,	9,	0,	0,	27),
(12,	1,	'Nómina con causa',	'',	'nomina-con-causa',	'',	'',	'',	'',	'',	'',	1,	10,	0,	0,	29),
(13,	2,	'Amanc',	'',	'amanc',	'',	'',	'',	'',	'',	'',	1,	1,	0,	0,	30),
(14,	2,	'Nuestro centro',	'',	'nuestro-centro',	'',	'',	'',	'',	'',	'',	1,	2,	0,	0,	31),
(15,	2,	'Cancer infantíl',	'',	'cancer-infantil',	'',	'',	'',	'',	'',	'',	1,	3,	0,	0,	32),
(16,	2,	'Donativos',	'',	'donativos',	'',	'',	'',	'',	'',	'',	1,	4,	0,	0,	33),
(17,	2,	'Contacto',	'',	'contacto',	'',	'',	'',	'',	'',	'',	1,	5,	0,	0,	34),
(18,	3,	'Beneficios',	'',	'beneficios',	'',	'',	'',	'',	'',	'',	1,	1,	0,	0,	35),
(19,	3,	'Campaña Detección Oportuna',	'',	'campana-deteccion-oportuna',	'',	'',	'',	'',	'',	'',	1,	2,	0,	0,	37),
(20,	3,	'Comunidad de Supervivientes',	'',	'comunidad-de-supervivientes',	'',	'',	'',	'',	'',	'',	1,	3,	0,	0,	38),
(21,	3,	'Fomento al empleo',	'',	'fomento-al-empleo',	'',	'',	'',	'',	'',	'',	1,	4,	0,	0,	39);

DROP TABLE IF EXISTS `marathon`;
CREATE TABLE `marathon` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `google_map` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_marathon` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `date_creadted` int(11) NOT NULL,
  `last_modified` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `newwindow` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `newsdate` int(11) NOT NULL,
  `date_content` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `log_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `news` (`id`, `title`, `summary`, `content`, `thumbnail`, `url`, `newwindow`, `position`, `status`, `newsdate`, `date_content`, `is_deleted`, `log_id`) VALUES
(1,	'Noticia uno',	'dgfdfgdgf',	'<p>Noticia Uno</p>\n',	'547c11662b94esmoke.jpg',	'ryrtyrty',	0,	0,	1,	1417500000,	0,	0,	87),
(2,	'Noticia 2',	'',	'',	'',	'',	0,	0,	1,	1417586400,	0,	0,	88);

DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `newwindow` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `log_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `partner` (`id`, `title`, `url`, `picture`, `newwindow`, `position`, `status`, `is_deleted`, `log_id`) VALUES
(1,	'Seven',	'http://google.com',	'545865b34393ashakespeare.jpeg',	0,	1,	1,	0,	12);

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `newwindow` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `log_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `project` (`id`, `title`, `summary`, `content`, `thumbnail`, `url`, `newwindow`, `position`, `status`, `is_deleted`, `log_id`) VALUES
(1,	'fsdfsd',	'sdfsdf',	'sdfsdf',	'547c07aade6d5smoke.jpg',	'sdfsdf',	0,	0,	1,	0,	63);

DROP TABLE IF EXISTS `runner`;
CREATE TABLE `runner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birtday` date NOT NULL,
  `phone` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `last_modified` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `runner_marathon`;
CREATE TABLE `runner_marathon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `runner_id` int(11) NOT NULL,
  `marathon_id` int(11) NOT NULL,
  `number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kms` int(11) NOT NULL,
  `donative` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `siteconfig`;
CREATE TABLE `siteconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `var_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `var_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `var_value` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newwindow` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `log_id` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `slide` (`id`, `title`, `summary`, `url`, `picture`, `newwindow`, `position`, `status`, `is_deleted`, `log_id`) VALUES
(1,	'test',	'desc',	'http://test.com',	'54585c30bb6d8shakespeare.jpeg',	0,	1,	1,	0,	4),
(2,	'test2',	'desc',	'http://test.com',	'54585c1ac72a6smoke.jpg',	0,	2,	1,	0,	5);

DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `state` (`id`, `state`) VALUES
(1,	'Aguascalientes'),
(2,	'Baja California'),
(3,	'Baja California Sur'),
(4,	'Campeche'),
(5,	'Coahuila de Zaragoza'),
(6,	'Colima'),
(7,	'Chiapas'),
(8,	'Chihuahua'),
(9,	'Distrito Federal'),
(10,	'Durango'),
(11,	'Guanajuato'),
(12,	'Guerrero'),
(13,	'Hidalgo'),
(14,	'Jalisco'),
(15,	'México'),
(16,	'Michoacán de Ocampo'),
(17,	'Morelos'),
(18,	'Nayarit'),
(19,	'Nuevo León'),
(20,	'Oaxaca'),
(21,	'Puebla'),
(22,	'Querétaro'),
(23,	'Quintana Roo'),
(24,	'San Luis Potosí'),
(25,	'Sinaloa'),
(26,	'Sonora'),
(27,	'Tabasco'),
(28,	'Tamaulipas'),
(29,	'Tlaxcala'),
(30,	'Veracruz de Ignacio de la Llave'),
(31,	'Yucatán'),
(32,	'Zacatecas');

DROP TABLE IF EXISTS `survivor`;
CREATE TABLE `survivor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `marital_status` tinyint(1) NOT NULL,
  `childs` int(11) NOT NULL,
  `date_detection` int(11) NOT NULL,
  `treatment_time` int(11) NOT NULL,
  `cancer_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabilities` text COLLATE utf8_unicode_ci NOT NULL,
  `interest` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `sys_access_control`;
CREATE TABLE `sys_access_control` (
  `role_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `action` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`module_id`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_access_control` (`role_id`, `module_id`, `action`) VALUES
(3,	2,	1),
(3,	2,	2),
(3,	2,	3),
(3,	2,	4),
(3,	2,	5),
(3,	3,	1),
(3,	3,	2),
(3,	3,	3),
(3,	3,	4),
(3,	3,	5),
(3,	5,	1),
(3,	5,	2),
(3,	5,	3),
(3,	5,	4),
(3,	5,	5),
(3,	5,	6),
(3,	6,	1),
(3,	6,	2),
(3,	6,	3),
(3,	6,	4),
(3,	6,	5),
(3,	7,	1),
(3,	7,	2),
(3,	7,	3),
(3,	7,	4),
(3,	7,	5),
(3,	7,	6),
(3,	8,	1),
(3,	8,	2),
(3,	8,	3),
(3,	8,	4),
(3,	8,	5),
(3,	8,	6),
(3,	10,	1),
(3,	10,	3),
(3,	10,	4),
(3,	11,	1),
(3,	11,	2),
(3,	11,	3),
(3,	11,	4),
(3,	11,	5),
(3,	11,	6),
(3,	13,	1),
(3,	13,	2),
(3,	13,	3),
(3,	13,	4),
(3,	13,	5),
(3,	14,	1),
(3,	14,	2),
(3,	14,	3),
(3,	14,	4),
(3,	14,	5),
(3,	15,	1),
(3,	15,	2),
(3,	15,	3),
(3,	15,	4),
(3,	15,	5),
(3,	15,	6),
(4,	7,	1),
(4,	7,	3),
(6,	3,	1),
(6,	12,	1);

DROP TABLE IF EXISTS `sys_log_activity`;
CREATE TABLE `sys_log_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `action` tinyint(3) unsigned NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_log_activity` (`id`, `user_id`, `module_id`, `item_id`, `item_name`, `data`, `action`, `timestamp`) VALUES
(1,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"10\",\"0\":false}',	3,	1415075117),
(2,	6,	7,	2,	'test',	'{\"id\":2,\"status\":\"1\",\"title\":\"test\",\"summary\":\"desc\",\"url\":\"http:\\/\\/test.com\",\"newwindow\":\"0\",\"0\":false}',	2,	1415076890),
(3,	6,	7,	2,	'test2',	'{\"id\":\"2\",\"status\":\"1\",\"title\":\"test2\",\"summary\":\"desc\",\"url\":\"http:\\/\\/test.com\",\"newwindow\":\"0\",\"name\":\"test\",\"picture\":\"54585c1ac72a6smoke.jpg\",\"log_id\":\"2\",\"mode\":\"\",\"log_time\":\"1415076890\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null}',	3,	1415076900),
(4,	6,	7,	1,	'test',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"test\",\"summary\":\"desc\",\"url\":\"http:\\/\\/test.com\",\"newwindow\":\"0\",\"name\":\"test\",\"picture\":\"\",\"log_id\":\"0\",\"mode\":\"\",\"0\":false,\"date_created\":null}',	3,	1415076912),
(5,	6,	7,	2,	'test2',	'{\"id\":\"2\",\"status\":\"1\",\"title\":\"test2\",\"summary\":\"desc\",\"url\":\"http:\\/\\/test.com\",\"newwindow\":\"0\",\"name\":\"test2\",\"picture\":\"54585c1ac72a6smoke.jpg\",\"log_id\":\"3\",\"mode\":\"\",\"log_time\":\"1415076900\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null}',	3,	1415076922),
(6,	6,	5,	1,	'Amanc',	'{\"id\":1,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Amanc\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"amanc\"}',	2,	1415078276),
(7,	6,	5,	2,	'Nuestro centro',	'{\"id\":2,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Nuestro centro\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"nuestro-centro\"}',	2,	1415078293),
(8,	6,	5,	3,	'Cáncer infantil',	'{\"id\":3,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"C\\u00e1ncer infantil\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"cancer-infantil\"}',	2,	1415078306),
(9,	6,	5,	4,	'Donativos',	'{\"id\":4,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Donativos\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"donativos\"}',	2,	1415078317),
(10,	6,	5,	5,	'Contacto',	'{\"id\":5,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Contacto\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"contacto\"}',	2,	1415078328),
(11,	6,	13,	1,	'Seven',	'{\"id\":1,\"status\":\"1\",\"title\":\"Seven\",\"url\":\"http:\\/\\/seven.com\",\"newwindow\":\"0\",\"0\":false}',	2,	1415079347),
(12,	6,	13,	1,	'Seven',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"Seven\",\"url\":\"http:\\/\\/google.com\",\"newwindow\":\"0\",\"name\":\"Seven\",\"picture\":\"545865b34393ashakespeare.jpeg\",\"log_id\":\"11\",\"mode\":\"\",\"log_time\":\"1415079347\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null}',	3,	1415079419),
(13,	6,	5,	6,	'cont',	'{\"id\":6,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"cont\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"cont\"}',	2,	1415547115),
(14,	6,	5,	7,	'sub cont',	'{\"id\":7,\"parent_id\":\"6\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"sub cont\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"sub-cont\"}',	2,	1415547125),
(15,	6,	5,	8,	'art 1',	'{\"id\":8,\"parent_id\":\"7\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"art 1\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"art-1\"}',	2,	1415547138),
(16,	6,	5,	1,	'Lo que hacemos',	'{\"id\":\"1\",\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Lo que hacemos\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"id_parent\":\"0\",\"name\":\"Amanc\",\"url\":\"amanc\",\"log_id\":\"6\",\"log_time\":\"1415078276\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"slug\":\"lo-que-hacemos\"}',	3,	1415547231),
(17,	6,	5,	1,	'Lo que hacemos',	'{\"id\":1,\"parent_id\":\"0\",\"in_menu\":\"0\",\"status\":\"1\",\"title\":\"Lo que hacemos\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"lo-que-hacemos\"}',	2,	1415547274),
(18,	6,	5,	2,	'Quienes somos',	'{\"id\":2,\"parent_id\":\"0\",\"in_menu\":\"0\",\"status\":\"1\",\"title\":\"Quienes somos\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"quienes-somos\"}',	2,	1415547307),
(19,	6,	5,	3,	'Modelo de acompañamiento',	'{\"id\":3,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Modelo de acompa\\u00f1amiento\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"modelo-de-acompanamiento\"}',	2,	1415547328),
(20,	6,	5,	4,	'Actividades',	'{\"id\":4,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Actividades\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"actividades\"}',	2,	1415547344),
(21,	6,	5,	5,	'Noticias',	'{\"id\":5,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Noticias\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"noticias\"}',	2,	1415547353),
(22,	6,	5,	6,	'Voluntariado',	'{\"id\":6,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Voluntariado\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"voluntariado\"}',	2,	1415547364),
(23,	6,	5,	7,	'Sistema Amanc',	'{\"id\":7,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Sistema Amanc\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"sistema-amanc\"}',	2,	1415547378),
(24,	6,	5,	8,	'Aliados',	'{\"id\":8,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Aliados\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"aliados\"}',	2,	1415547391),
(25,	6,	5,	9,	'Noticias',	'{\"id\":9,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Noticias\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"noticias\"}',	2,	1415547402),
(26,	6,	5,	10,	'Escuelas amigas',	'{\"id\":10,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Escuelas amigas\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"escuelas-amigas\"}',	2,	1415547419),
(27,	6,	5,	11,	'Maratón',	'{\"id\":11,\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Marat\\u00f3n\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"maraton\"}',	2,	1415547432),
(28,	6,	5,	12,	'Nómina con causa',	'{\"id\":12,\"parent_id\":\"0\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"N\\u00f3mina con causa\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"nomina-con-causa\"}',	2,	1415547445),
(29,	6,	5,	12,	'Nómina con causa',	'{\"id\":\"12\",\"parent_id\":\"1\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"N\\u00f3mina con causa\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"id_parent\":\"0\",\"name\":\"N\\u00f3mina con causa\",\"url\":\"nomina-con-causa\",\"log_id\":\"28\",\"log_time\":\"1415547445\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"slug\":\"nomina-con-causa\"}',	3,	1415547473),
(30,	6,	5,	13,	'Amanc',	'{\"id\":13,\"parent_id\":\"2\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Amanc\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"amanc\"}',	2,	1415547533),
(31,	6,	5,	14,	'Nuestro centro',	'{\"id\":14,\"parent_id\":\"2\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Nuestro centro\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"nuestro-centro\"}',	2,	1415547559),
(32,	6,	5,	15,	'Cancer infantíl',	'{\"id\":15,\"parent_id\":\"2\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Cancer infant\\u00edl\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"cancer-infantil\"}',	2,	1415547571),
(33,	6,	5,	16,	'Donativos',	'{\"id\":16,\"parent_id\":\"2\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Donativos\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"donativos\"}',	2,	1415547584),
(34,	6,	5,	17,	'Contacto',	'{\"id\":17,\"parent_id\":\"2\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Contacto\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"contacto\"}',	2,	1415547593),
(35,	6,	5,	18,	'Beneficios',	'{\"id\":18,\"parent_id\":\"3\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Beneficios\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"beneficios\"}',	2,	1415547621),
(36,	6,	5,	19,	'Campaña detección oportuna',	'{\"id\":19,\"parent_id\":\"3\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Campa\\u00f1a detecci\\u00f3n oportuna\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"campana-deteccion-oportuna\"}',	2,	1415547648),
(37,	6,	5,	19,	'Campaña Detección Oportuna',	'{\"id\":\"19\",\"parent_id\":\"3\",\"in_menu\":\"0\",\"status\":\"1\",\"title\":\"Campa\\u00f1a Detecci\\u00f3n Oportuna\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"id_parent\":\"3\",\"name\":\"Campa\\u00f1a detecci\\u00f3n oportuna\",\"url\":\"campana-deteccion-oportuna\",\"log_id\":\"36\",\"log_time\":\"1415547648\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"slug\":\"campana-deteccion-oportuna\"}',	3,	1415547666),
(38,	6,	5,	20,	'Comunidad de Supervivientes',	'{\"id\":20,\"parent_id\":\"3\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Comunidad de Supervivientes\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"comunidad-de-supervivientes\"}',	2,	1415547686),
(39,	6,	5,	21,	'Fomento al empleo',	'{\"id\":21,\"parent_id\":\"3\",\"in_menu\":\"1\",\"status\":\"1\",\"title\":\"Fomento al empleo\",\"subtitle\":\"\",\"content\":\"\",\"link\":\"\",\"seo_title\":\"\",\"seo_keywords\":\"\",\"seo_abstract\":\"\",\"seo_description\":\"\",\"0\":false,\"slug\":\"fomento-al-empleo\"}',	2,	1415547700),
(40,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"6.1\",\"6.2\",\"6.3\",\"6.4\",\"6.5\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"1\",\"log_time\":\"1415075117\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\"}',	3,	1415561275),
(41,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"6.1\",\"6.2\",\"6.3\",\"6.4\",\"6.5\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"8.1\",\"8.2\",\"8.3\",\"8.4\",\"8.5\",\"8.6\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"40\",\"log_time\":\"1415561275\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\"}',	3,	1415568356),
(42,	6,	8,	1,	'Actividad uno',	'{\"id\":1,\"status\":\"1\",\"state_id\":\"3\",\"title\":\"Actividad uno\",\"content\":\"Actividad uno\",\"0\":false}',	2,	1415569507),
(43,	6,	6,	1,	'Noticia uno',	'{\"id\":1,\"status\":\"1\",\"title\":\"Noticia uno\",\"newsdate\":\"2014-11-11\",\"content\":\"Noticia Uno\",\"0\":false}',	2,	1415569530),
(44,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"Noticia uno\",\"newsdate\":\"2014-11-11\",\"content\":\"Noticia Uno\",\"name\":\"Noticia uno\",\"log_id\":\"43\",\"mode\":\"\",\"log_time\":\"1415569530\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null}',	3,	1415591248),
(45,	6,	6,	1,	'Noticia uno',	'{\"status\":\"0\"}',	5,	1415591302),
(46,	6,	6,	1,	'Noticia uno',	'{\"status\":\"1\"}',	5,	1415591313),
(47,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"6.1\",\"6.2\",\"6.3\",\"6.4\",\"6.5\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"8.1\",\"8.2\",\"8.3\",\"8.4\",\"8.5\",\"8.6\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"41\",\"log_time\":\"1415568356\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\"}',	3,	1415591353),
(48,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"6.1\",\"6.2\",\"6.3\",\"6.4\",\"6.5\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"8.1\",\"8.2\",\"8.3\",\"8.4\",\"8.5\",\"8.6\",\"15.1\",\"15.2\",\"15.3\",\"15.4\",\"15.5\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"47\",\"log_time\":\"1415591353\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\"}',	3,	1415806821),
(49,	6,	3,	3,	'Administrator',	'{\"id\":\"3\",\"status\":\"1\",\"name\":\"Administrator\",\"access_control\":[\"5.1\",\"5.2\",\"5.3\",\"5.4\",\"5.5\",\"5.6\",\"6.1\",\"6.2\",\"6.3\",\"6.4\",\"6.5\",\"7.1\",\"7.2\",\"7.3\",\"7.4\",\"7.5\",\"7.6\",\"8.1\",\"8.2\",\"8.3\",\"8.4\",\"8.5\",\"8.6\",\"15.1\",\"15.2\",\"15.3\",\"15.4\",\"15.5\",\"15.6\",\"10.1\",\"10.3\",\"10.4\",\"11.1\",\"11.2\",\"11.3\",\"11.4\",\"11.5\",\"11.6\",\"13.1\",\"13.2\",\"13.3\",\"13.4\",\"13.5\",\"14.1\",\"14.2\",\"14.3\",\"14.4\",\"14.5\",\"2.1\",\"2.2\",\"2.3\",\"2.4\",\"2.5\",\"3.1\",\"3.2\",\"3.3\",\"3.4\",\"3.5\"],\"log_id\":\"48\",\"log_time\":\"1415806821\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\"}',	3,	1415806923),
(50,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"log_id\":\"46\",\"mode\":\"\",\"log_time\":\"1415591313\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[]}',	3,	1415807865),
(51,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"directory_id\":[\"2\"],\"name\":\"Noticia uno\",\"log_id\":\"50\",\"mode\":\"\",\"log_time\":\"1415807865\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"1\",\"module_id\":\"0\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"2\",\"module_id\":\"0\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"3\",\"module_id\":\"0\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1415854593),
(52,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"log_id\":\"51\",\"mode\":\"\",\"log_time\":\"1415854593\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[]}',	3,	1415854631),
(53,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"\",\"url\":\"ryrtyrty\",\"thumbnail\":\"error_globo.png\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\",\"log_id\":\"52\",\"mode\":\"\",\"log_time\":\"1415854631\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"5\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"6\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"7\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1415951734),
(54,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"error_globo.png\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/error_globo.png\",\"log_id\":\"53\",\"mode\":\"\",\"log_time\":\"1415951734\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"8\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"9\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"10\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1415951744),
(55,	6,	8,	1,	'Actividad uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"state_id\":\"3\",\"title\":\"Actividad uno\",\"content\":\"Actividad uno\",\"summary\":\"ewwerwe\",\"url\":\"werwer\",\"thumbnail\":\"8167_IMG0000 (2).jpg\",\"directory_id\":[\"3\"],\"name\":\"Actividad uno\",\"src_picture\":\"\",\"log_id\":\"42\",\"mode\":\"\",\"log_time\":\"1415569507\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[]}',	3,	1416290590),
(56,	6,	8,	1,	'Actividad uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"state_id\":\"3\",\"title\":\"Actividad uno\",\"content\":\"Actividad uno\",\"summary\":\"ewwerwe\",\"url\":\"werwer\",\"thumbnail\":\"8167_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Actividad uno\",\"src_picture\":\"\\/assets\\/files\\/activity\\/8167_IMG0000 (2).jpg\",\"log_id\":\"55\",\"mode\":\"\",\"log_time\":\"1416290590\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[]}',	3,	1416290600),
(57,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/error_globo.png\",\"log_id\":\"54\",\"mode\":\"\",\"log_time\":\"1415951744\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"11\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"12\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"13\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"},{\"id\":\"14\",\"module_id\":\"18\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"15\",\"module_id\":\"18\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"16\",\"module_id\":\"18\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1416290633),
(58,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/IMG0000 (2).jpg\",\"log_id\":\"57\",\"mode\":\"\",\"log_time\":\"1416290633\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"17\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"18\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"19\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1416290744),
(59,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"1847_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/IMG0000 (2).jpg\",\"log_id\":\"58\",\"mode\":\"\",\"log_time\":\"1416290744\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"20\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"21\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"22\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1416290810),
(60,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"4727_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\",\"1\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/1847_IMG0000 (2).jpg\",\"log_id\":\"59\",\"mode\":\"\",\"log_time\":\"1416290810\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"23\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"24\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"25\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1416290925),
(61,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"4727_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/4727_IMG0000 (2).jpg\",\"log_id\":\"60\",\"mode\":\"\",\"log_time\":\"1416290925\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"26\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"27\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"},{\"id\":\"28\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"1\"}]}',	3,	1416290944),
(62,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"127\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/4727_IMG0000 (2).jpg\",\"log_id\":\"61\",\"mode\":\"\",\"log_time\":\"1416290944\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"29\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"30\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1416291370),
(63,	6,	15,	1,	'fsdfsd',	'{\"id\":1,\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"fsdfsd\",\"summary\":\"sdfsdf\",\"content\":\"sdfsdf\",\"url\":\"sdfsdf\",\"thumbnail\":\"2936_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"members\":[]}',	2,	1416291408),
(64,	6,	8,	1,	'Actividad uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"state_id\":\"3\",\"title\":\"Actividad uno\",\"content\":\"Actividad uno\",\"summary\":\"ewwerwe\",\"url\":\"werwer\",\"thumbnail\":\"8167_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Actividad uno\",\"src_picture\":\"\\/assets\\/files\\/activity\\/8167_IMG0000 (2).jpg\",\"log_id\":\"56\",\"mode\":\"\",\"log_time\":\"1416290600\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[]}',	3,	1416291920),
(65,	6,	8,	1,	'Actividad uno',	'{\"id\":\"1\",\"status\":\"1\",\"state_id\":\"3\",\"title\":\"Actividad uno\",\"summary\":\"ewwerwe\",\"content\":\"<p>Actividad uno modificada<\\/p>\\n\",\"url\":\"werwer\",\"newwindow\":\"0\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Actividad uno\",\"thumbnail\":\"547c05876bcacsmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c05876bcacsmoke.jpg\",\"log_id\":\"64\",\"mode\":\"\",\"log_time\":\"1416291920\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"35\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"36\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1417414045),
(66,	6,	8,	1,	'Actividad uno mod',	'{\"id\":\"1\",\"status\":\"1\",\"state_id\":\"5\",\"title\":\"Actividad uno mod\",\"summary\":\"Resumen\",\"content\":\"<p>Actividad uno modificada<\\/p>\\n\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Actividad uno\",\"thumbnail\":\"547c059def32csmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c059def32csmoke.jpg\",\"log_id\":\"65\",\"mode\":\"\",\"log_time\":\"1417414045\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"37\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"38\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1417414068),
(67,	6,	8,	1,	'Actividad uno mod',	'{\"id\":\"1\",\"status\":\"1\",\"state_id\":\"5\",\"title\":\"Actividad uno mod\",\"summary\":\"Resumen\",\"content\":\"<p>Actividad uno modificada<\\/p>\\n\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"2\"],\"name\":\"Actividad uno mod\",\"thumbnail\":\"547c059def32csmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c059def32csmoke.jpg\",\"log_id\":\"66\",\"mode\":\"\",\"log_time\":\"1417414068\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"39\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"40\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1417414232),
(68,	6,	8,	2,	'Actividad 2',	'{\"id\":2,\"status\":\"1\",\"state_id\":\"9\",\"title\":\"Actividad 2\",\"summary\":\"Resumen de actividad 2\",\"content\":\"<p>Contenido de actividad 2<\\/p>\\n\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"1\"],\"members\":[]}',	2,	1417414383),
(69,	6,	8,	2,	'Actividad 2',	'{\"id\":\"2\",\"status\":\"1\",\"state_id\":\"9\",\"title\":\"Actividad 2\",\"summary\":\"Resumen de actividad 2\",\"content\":\"<p>Contenido de actividad 2<\\/p>\\n\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"1\"],\"name\":\"Actividad 2\",\"thumbnail\":\"\",\"src_picture\":\"\",\"log_id\":\"68\",\"mode\":\"\",\"log_time\":\"1417414383\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"42\",\"module_id\":\"8\",\"content_id\":\"2\",\"tag_id\":\"1\"}]}',	3,	1417414400),
(70,	6,	8,	3,	'Actividad 3',	'{\"id\":3,\"status\":\"1\",\"state_id\":\"8\",\"title\":\"Actividad 3\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"3\"],\"members\":[]}',	2,	1417414448),
(71,	6,	8,	4,	'Actividad 4',	'{\"id\":4,\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 4\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"2\",\"1\"],\"members\":[]}',	2,	1417414514),
(72,	6,	8,	5,	'Actividad 6',	'{\"id\":5,\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"directory_id\":[\"1\"],\"members\":[]}',	2,	1417414570),
(73,	6,	8,	5,	'Actividad 6',	'{\"id\":\"5\",\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"1\"],\"name\":\"Actividad 6\",\"thumbnail\":\"547c07aade6d5smoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c07aade6d5smoke.jpg\",\"log_id\":\"72\",\"mode\":\"\",\"log_time\":\"1417414570\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"47\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"1\"}]}',	3,	1417414753),
(74,	6,	8,	5,	'Actividad 6',	'{\"id\":\"5\",\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"3\"],\"name\":\"Actividad 6\",\"thumbnail\":\"547c0861cfbd6shakespeare.jpeg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c0861cfbd6shakespeare.jpeg\",\"log_id\":\"73\",\"mode\":\"\",\"log_time\":\"1417414753\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"48\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"1\"}]}',	3,	1417415272),
(75,	6,	8,	5,	'Actividad 6',	'{\"id\":\"5\",\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"3\",\"1\"],\"name\":\"Actividad 6\",\"thumbnail\":\"547c0861cfbd6shakespeare.jpeg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c0861cfbd6shakespeare.jpeg\",\"log_id\":\"74\",\"mode\":\"\",\"log_time\":\"1417415272\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"49\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"3\"}]}',	3,	1417415746),
(76,	6,	8,	5,	'Actividad 6',	'{\"id\":\"5\",\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"2\",\"3\",\"1\"],\"name\":\"Actividad 6\",\"thumbnail\":\"547c0861cfbd6shakespeare.jpeg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c0861cfbd6shakespeare.jpeg\",\"log_id\":\"75\",\"mode\":\"\",\"log_time\":\"1417415746\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"50\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"3\"},{\"id\":\"51\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"1\"}]}',	3,	1417415755),
(77,	6,	8,	5,	'Actividad 6',	'{\"id\":\"5\",\"status\":\"1\",\"state_id\":\"20\",\"title\":\"Actividad 6\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"2\",\"3\",\"1\"],\"name\":\"Actividad 6\",\"thumbnail\":\"547c0861cfbd6shakespeare.jpeg\",\"src_picture\":\"\\/assets\\/files\\/activity\\/547c0861cfbd6shakespeare.jpeg\",\"log_id\":\"76\",\"mode\":\"\",\"log_time\":\"1417415755\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"52\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"2\"},{\"id\":\"53\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"3\"},{\"id\":\"54\",\"module_id\":\"8\",\"content_id\":\"5\",\"tag_id\":\"1\"}]}',	3,	1417415764),
(78,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newwindow\":\"0\",\"title\":\"Noticia uno\",\"newsdate\":\"2014-12-02\",\"content\":\"Noticia Uno\",\"summary\":\"dgfdfgdgf\",\"url\":\"ryrtyrty\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"directory_id\":[\"2\",\"3\"],\"name\":\"Noticia uno\",\"src_picture\":\"\\/assets\\/files\\/news\\/4609_IMG0000 (2).jpg\",\"log_id\":\"62\",\"mode\":\"\",\"log_time\":\"1416291370\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"members\":[{\"id\":\"31\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"2\"},{\"id\":\"32\",\"module_id\":\"6\",\"content_id\":\"1\",\"tag_id\":\"3\"}]}',	3,	1417415888),
(79,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"127\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/4609_IMG0000 (2).jpg\",\"log_id\":\"78\",\"mode\":\"\",\"log_time\":\"1417415888\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417416786),
(80,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"127\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/4609_IMG0000 (2).jpg\",\"log_id\":\"79\",\"mode\":\"\",\"log_time\":\"1417416786\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417416920),
(81,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"127\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/4609_IMG0000 (2).jpg\",\"log_id\":\"80\",\"mode\":\"\",\"log_time\":\"1417416920\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417416976),
(82,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"127\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"4609_IMG0000 (2).jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/4609_IMG0000 (2).jpg\",\"log_id\":\"81\",\"mode\":\"\",\"log_time\":\"1417416976\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417062),
(83,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"2014-12-01\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"547c11662b94esmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/547c11662b94esmoke.jpg\",\"log_id\":\"82\",\"mode\":\"\",\"log_time\":\"1417417062\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417542),
(84,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"2014-12-02\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"547c11662b94esmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/547c11662b94esmoke.jpg\",\"log_id\":\"83\",\"mode\":\"\",\"log_time\":\"1417417542\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417584),
(85,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"2014-12-02\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"547c11662b94esmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/547c11662b94esmoke.jpg\",\"log_id\":\"84\",\"mode\":\"\",\"log_time\":\"1417417584\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417596),
(86,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"2014-12-03\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"547c11662b94esmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/547c11662b94esmoke.jpg\",\"log_id\":\"85\",\"mode\":\"\",\"log_time\":\"1417417596\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417661),
(87,	6,	6,	1,	'Noticia uno',	'{\"id\":\"1\",\"status\":\"1\",\"newsdate\":\"2014-12-02\",\"title\":\"Noticia uno\",\"summary\":\"dgfdfgdgf\",\"content\":\"<p>Noticia Uno<\\/p>\\n\",\"url\":\"ryrtyrty\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"name\":\"Noticia uno\",\"thumbnail\":\"547c11662b94esmoke.jpg\",\"src_picture\":\"\\/assets\\/files\\/news\\/547c11662b94esmoke.jpg\",\"log_id\":\"86\",\"mode\":\"\",\"log_time\":\"1417417661\",\"log_user\":\"Gabriel Vel\\u00e1zquez R\\u00edos\",\"date_created\":null,\"tags_selected\":[{\"id\":\"41\",\"module_id\":\"8\",\"content_id\":\"1\",\"tag_id\":\"2\"}]}',	3,	1417417838),
(88,	6,	6,	2,	'Noticia 2',	'{\"id\":2,\"status\":\"1\",\"newsdate\":\"2014-12-03\",\"title\":\"Noticia 2\",\"summary\":\"\",\"content\":\"\",\"url\":\"\",\"newwindow\":\"0\",\"tag_id\":[\"2\"],\"tags_selected\":[]}',	2,	1417417854);

DROP TABLE IF EXISTS `sys_log_session`;
CREATE TABLE `sys_log_session` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `action` tinyint(3) unsigned NOT NULL,
  `remote_address` int(10) unsigned NOT NULL,
  `user_agent` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sys_log_session_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_log_session` (`id`, `user_id`, `action`, `remote_address`, `user_agent`, `timestamp`) VALUES
(1,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415073963),
(2,	6,	3,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415074496),
(3,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415074503),
(4,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415074625),
(5,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415074938),
(6,	6,	3,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415075120),
(7,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415075127),
(8,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415544525),
(9,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415558956),
(10,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415561248),
(11,	6,	3,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415561289),
(12,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415561291),
(13,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415568329),
(14,	6,	3,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415568360),
(15,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415568362),
(16,	6,	1,	3186009219,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415569489),
(17,	6,	1,	3186114038,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415591221),
(18,	6,	1,	3187235780,	'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415641111),
(19,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415806789),
(20,	6,	3,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415806930),
(21,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415806932),
(22,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415807518),
(23,	6,	3,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415807767),
(24,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415807769),
(25,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415807841),
(26,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415808027),
(27,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415808310),
(28,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415808461),
(29,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415808596),
(30,	6,	1,	3378995956,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415808922),
(31,	6,	1,	3149053016,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415810252),
(32,	6,	1,	1113982722,	'Mozilla/5.0 (Linux; Android 4.4.2; SGH-I337M Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.114 Mobile Safari/537.36',	1415841356),
(33,	6,	1,	3381236136,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415854395),
(34,	6,	1,	3381236136,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1415951277),
(35,	6,	1,	3381237335,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1416290257),
(36,	6,	1,	3381237335,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1416290486),
(37,	6,	1,	3381237335,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1416291355),
(38,	6,	1,	3381237335,	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',	1416291905),
(39,	6,	1,	1113982466,	'Mozilla/5.0 (Linux; Android 4.4.2; SGH-I337M Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.59 Mobile Safari/537.36',	1417332575),
(40,	6,	1,	3186106045,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36',	1417405517),
(41,	6,	1,	3186106045,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36',	1417411677),
(42,	6,	1,	2130706433,	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36',	1417657523);

DROP TABLE IF EXISTS `sys_lookup`;
CREATE TABLE `sys_lookup` (
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `code` tinyint(3) unsigned NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`type`,`code`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_lookup` (`type`, `code`, `name`, `position`) VALUES
('action',	1,	'View',	1),
('action',	2,	'Create',	2),
('action',	3,	'Edit',	3),
('action',	4,	'Delete',	4),
('action',	5,	'Status',	5),
('action',	6,	'Sort',	6),
('question',	1,	'Multiple choice',	1),
('question',	2,	'Free text',	2),
('request',	1,	'Solicitud recibida',	1),
('request',	2,	'Solicitud de recolección',	2),
('request',	3,	'Equipo recibido',	3),
('request',	4,	'Fallas cotizadas',	4),
('result',	0,	'Incorrect',	1),
('result',	1,	'Correct',	2),
('session',	1,	'Login',	1),
('session',	2,	'Autologin',	2),
('session',	3,	'Logout',	3),
('session',	4,	'Password',	4),
('status',	0,	'Inactive',	1),
('status',	1,	'Active',	2),
('status',	2,	'Rechazado',	2),
('yesno',	0,	'No',	1),
('yesno',	1,	'Yes',	2);

DROP TABLE IF EXISTS `sys_module`;
CREATE TABLE `sys_module` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `directory` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_module` (`id`, `parent_id`, `name`, `description`, `directory`, `model`, `message`, `position`) VALUES
(1,	NULL,	'Access',	'',	'access',	'',	NULL,	10),
(2,	1,	'Administradores',	'Administración de los usuarios del admin',	'admins',	'sys_user',	'El Administrador <strong>{item_name}</strong> ha sido {action}',	1),
(3,	1,	'Roles',	'Administración de los roles del sitio',	'roles',	'sys_role',	'El Rol <strong>{item_name}</strong> ha sido {action}',	2),
(4,	NULL,	'Manage',	'',	'manage',	'',	NULL,	1),
(5,	4,	'Contenido',	'Administración de páginas de contenido',	'content',	'content',	'El contenido {name} ha sido {action}',	1),
(6,	4,	'Noticias',	'Administración de las noticias',	'news',	'news',	'La noticia {name} ha sido {action}',	3),
(7,	4,	'Slider home',	'Administración de slides del home',	'slide',	'slide',	NULL,	4),
(8,	4,	'Actividades',	'Administración de las actividades del sitio',	'activity',	'activity',	'La actividad {name} ha sido {action}',	5),
(9,	NULL,	'Contacto',	'',	'contact',	'contact',	NULL,	2),
(10,	9,	'Contactos',	'Administración de contactos desde el sitio',	'contact',	'contact',	NULL,	1),
(11,	9,	'Areas de contacto',	'Administración de areas de contacto',	'contactarea',	'contactarea',	NULL,	2),
(12,	NULL,	'Catalogos',	'',	'catalog',	'',	NULL,	4),
(13,	12,	'Afiliados',	'Administración de los afiliados',	'partner',	'partner',	NULL,	1),
(14,	12,	'Licencias',	'Administración de las licencias',	'licence',	'licence',	NULL,	2),
(15,	4,	'Proyectos',	'Adminitracion de proyectos del sitio',	'project',	'project',	'El Proyecto {name} ha sido {action}',	5);

DROP TABLE IF EXISTS `sys_permissions`;
CREATE TABLE `sys_permissions` (
  `module_id` int(10) unsigned NOT NULL,
  `action` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`module_id`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_permissions` (`module_id`, `action`) VALUES
(2,	1),
(2,	2),
(2,	3),
(2,	4),
(2,	5),
(3,	1),
(3,	2),
(3,	3),
(3,	4),
(3,	5),
(5,	1),
(5,	2),
(5,	3),
(5,	4),
(5,	5),
(5,	6),
(6,	1),
(6,	2),
(6,	3),
(6,	4),
(6,	5),
(7,	1),
(7,	2),
(7,	3),
(7,	4),
(7,	5),
(7,	6),
(8,	1),
(8,	2),
(8,	3),
(8,	4),
(8,	5),
(8,	6),
(10,	1),
(10,	3),
(10,	4),
(11,	1),
(11,	2),
(11,	3),
(11,	4),
(11,	5),
(11,	6),
(12,	1),
(12,	2),
(12,	3),
(12,	4),
(12,	5),
(13,	1),
(13,	2),
(13,	3),
(13,	4),
(13,	5),
(14,	1),
(14,	2),
(14,	3),
(14,	4),
(14,	5),
(15,	1),
(15,	2),
(15,	3),
(15,	4),
(15,	5),
(15,	6),
(16,	1),
(16,	2),
(16,	3),
(16,	4),
(16,	5),
(17,	1),
(17,	2),
(17,	3),
(17,	4),
(17,	5),
(18,	1),
(18,	2),
(18,	3),
(18,	4),
(18,	5),
(19,	1),
(19,	2),
(19,	3),
(19,	4),
(19,	5),
(21,	1),
(21,	2),
(21,	3),
(21,	4),
(21,	5),
(23,	1),
(23,	2),
(23,	3),
(23,	4),
(23,	5),
(24,	1),
(24,	2),
(24,	3),
(24,	4),
(24,	5),
(24,	6);

DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `system` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_id` int(10) unsigned DEFAULT NULL,
  `last_modified` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_role` (`id`, `name`, `system`, `log_id`, `last_modified`, `date_created`, `status`, `is_deleted`) VALUES
(1,	'System',	1,	NULL,	0,	0,	1,	0),
(2,	'Guest',	1,	NULL,	0,	0,	1,	0),
(3,	'Administrator',	0,	49,	1415806923,	1334729707,	1,	0),
(4,	'Piloto',	0,	97,	1369248824,	1369248817,	1,	1),
(5,	'role test',	0,	99,	1375286860,	1375286860,	1,	1),
(6,	'role test',	0,	100,	1375286872,	1375286872,	1,	1);

DROP TABLE IF EXISTS `sys_setting`;
CREATE TABLE `sys_setting` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `var` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `slot` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_setting` (`id`, `name`, `description`, `var`, `value`, `slot`) VALUES
(1,	'Facebook page',	'',	'facebook_url',	'http://facebook.com',	1),
(2,	'Twitter page',	'',	'twitter_url',	'http://twitter.com',	2),
(3,	'Google analytics',	'UA-XXXXXXXX-X',	'google_analytics',	'',	3);

DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `logins` int(11) NOT NULL DEFAULT '0',
  `log_id` int(10) unsigned DEFAULT NULL,
  `last_modified` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sys_user` (`id`, `role_id`, `first_name`, `last_name`, `email`, `password`, `last_login`, `logins`, `log_id`, `last_modified`, `date_created`, `status`, `is_deleted`) VALUES
(3,	3,	'Jadiel',	'Flores',	'jadiel@jadiel.com',	'95730e6e7532632b790213b7f4c2d8b9b1b77b5d9f8ded836fe19229dfeb4b44',	1404757673,	106,	60,	1362423334,	1362423334,	1,	0),
(6,	3,	'Gabriel',	'Velázquez Ríos',	'gabriel7759@hotmail.com',	'd18d1ce14ccec473ef9f289065aa69f1d94148b20eaec26b7f3f93d5ac91e50e',	1417657523,	100,	NULL,	0,	0,	1,	0);

DROP TABLE IF EXISTS `sys_user_tokens`;
CREATE TABLE `sys_user_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tag` (`id`, `title`, `status`, `is_deleted`) VALUES
(1,	'tag uno',	1,	0),
(2,	'tag dos',	1,	0),
(3,	'tag tres',	1,	0);

DROP TABLE IF EXISTS `tag_content`;
CREATE TABLE `tag_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tag_content` (`id`, `module_id`, `content_id`, `tag_id`) VALUES
(14,	18,	1,	3),
(15,	18,	1,	2),
(16,	18,	1,	3),
(33,	0,	1,	2),
(34,	0,	1,	3),
(41,	8,	1,	2),
(43,	8,	2,	1),
(44,	8,	3,	3),
(45,	8,	4,	2),
(46,	8,	4,	1),
(55,	8,	5,	2),
(56,	8,	5,	3),
(57,	8,	5,	1),
(68,	6,	1,	2),
(69,	6,	2,	2);

DROP TABLE IF EXISTS `volunteer`;
CREATE TABLE `volunteer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `language` tinyint(1) NOT NULL,
  `cancer_related` tinyint(1) NOT NULL,
  `cancer_related_txt` text COLLATE utf8_unicode_ci NOT NULL,
  `hours` int(11) NOT NULL,
  `monday_hrs` int(11) NOT NULL,
  `tuesday_hrs` int(11) NOT NULL,
  `wednesday_hrs` int(11) NOT NULL,
  `thursday_hrs` int(11) NOT NULL,
  `friday_hrs` int(11) NOT NULL,
  `saturday_hrs` int(11) NOT NULL,
  `sunday_hrs` int(11) NOT NULL,
  `interest` text COLLATE utf8_unicode_ci NOT NULL,
  `why` text COLLATE utf8_unicode_ci NOT NULL,
  `datecreated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `volunteer_type`;
CREATE TABLE `volunteer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(11) NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2014-12-05 05:17:22
