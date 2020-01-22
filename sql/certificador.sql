/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.5-10.0.31-MariaDB : Database - certificador
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cert_admin` */

DROP TABLE IF EXISTS `cert_admin`;

CREATE TABLE `cert_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cert_admin` */

insert  into `cert_admin`(`id_admin`,`nome`,`login`,`email`,`pass`,`status`) values (1,'Fábio','fabio.akira','fabio.akira@ufabc.edu.br','123',1),(2,'Gustavo','gustavo.castilho','gustavo.castilho@ufabc.edu.br','123',1);

/*Table structure for table `cert_alunocurso` */

DROP TABLE IF EXISTS `cert_alunocurso`;

CREATE TABLE `cert_alunocurso` (
  `id_alunocurso` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_certificado` int(11) DEFAULT NULL,
  `conceito` varchar(255) DEFAULT NULL,
  `cod_validacao` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `downloads` int(11) DEFAULT '0',
  `download_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_alunocurso`),
  KEY `idAluno` (`id_aluno`),
  KEY `idCurso` (`id_curso`),
  KEY `id_certificado` (`id_certificado`),
  CONSTRAINT `cert_alunocurso_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `cert_alunos` (`id_aluno`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cert_alunocurso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cert_cursos` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cert_alunocurso_ibfk_3` FOREIGN KEY (`id_certificado`) REFERENCES `cert_certificados` (`id_certificado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=410 DEFAULT CHARSET=utf8;

/*Data for the table `cert_alunocurso` */

/*Table structure for table `cert_alunos` */

DROP TABLE IF EXISTS `cert_alunos`;

CREATE TABLE `cert_alunos` (
  `id_aluno` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `statusEmail` int(11) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_aluno`),
  UNIQUE KEY `UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

/*Data for the table `cert_alunos` */

/*Table structure for table `cert_certificados` */

DROP TABLE IF EXISTS `cert_certificados`;

CREATE TABLE `cert_certificados` (
  `id_certificado` int(11) NOT NULL AUTO_INCREMENT,
  `nome_certificado` varchar(255) DEFAULT NULL,
  `template_certificado` varchar(255) DEFAULT NULL,
  `texto_certificado` varchar(255) DEFAULT NULL,
  `created_certificado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_certificado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cert_certificados` */

insert  into `cert_certificados`(`id_certificado`,`nome_certificado`,`template_certificado`,`texto_certificado`,`created_certificado`) values (1,'Padrao-bd','templates/cert_padrao.php',NULL,'2018-07-10 14:51:38'),(2,'REA-bd','templates/cert_rea.php',NULL,'2018-07-10 14:52:07');

/*Table structure for table `cert_cursos` */

DROP TABLE IF EXISTS `cert_cursos`;

CREATE TABLE `cert_cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCurso` varchar(255) NOT NULL,
  `edital` varchar(255) DEFAULT NULL,
  `dataIni` varchar(255) NOT NULL,
  `dataFim` varchar(255) NOT NULL,
  `cargaHoraria` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8;

/*Data for the table `cert_cursos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
