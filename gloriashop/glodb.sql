-- phpMyAdmin SQL Dump
-- version 2.9.0.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 14, 2014 at 07:12 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.0
-- 
-- Database: `glo_db`
-- 
CREATE DATABASE `glo_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `glo_db`;

-- --------------------------------------------------------

-- 
-- Table structure for table `client`
-- 

CREATE TABLE `client` (
  `telclt` int(11) NOT NULL,
  `nomclt` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  PRIMARY KEY  (`telclt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `client`
-- 

INSERT INTO `client` (`telclt`, `nomclt`, `credit`) VALUES 
(5789, 'frezrezrzefdg', 0),
(987987, 'tetetezzt', 0),
(98979694, 'jean dupont', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `faclist`
-- 

CREATE TABLE `faclist` (
  `idfaclist` int(11) NOT NULL auto_increment,
  `facture` varchar(255) NOT NULL,
  `prodfac` int(11) NOT NULL,
  `qtfac` int(11) NOT NULL,
  `mtfac` int(11) NOT NULL,
  PRIMARY KEY  (`idfaclist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `faclist`
-- 

INSERT INTO `faclist` (`idfaclist`, `facture`, `prodfac`, `qtfac`, `mtfac`) VALUES 
(1, '20141212203326', 2, 30, 12000),
(2, '20141212203326', 1, 1, 5000);

-- --------------------------------------------------------

-- 
-- Table structure for table `facture`
-- 

CREATE TABLE `facture` (
  `idfac` varchar(255) NOT NULL,
  `cltfac` int(11) NOT NULL,
  `dtfac` date NOT NULL,
  PRIMARY KEY  (`idfac`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `facture`
-- 

INSERT INTO `facture` (`idfac`, `cltfac`, `dtfac`) VALUES 
('20141212203326', 98979694, '2014-12-12');

-- --------------------------------------------------------

-- 
-- Table structure for table `produit`
-- 

CREATE TABLE `produit` (
  `idprod` int(11) NOT NULL auto_increment,
  `libprod` varchar(255) NOT NULL,
  `qtprod` int(11) NOT NULL,
  `mtprod` int(11) NOT NULL,
  `taxe` int(11) NOT NULL default '1',
  `seuilprod` int(11) NOT NULL,
  PRIMARY KEY  (`idprod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `produit`
-- 

INSERT INTO `produit` (`idprod`, `libprod`, `qtprod`, `mtprod`, `taxe`, `seuilprod`) VALUES 
(1, 'pommade', 49, 5000, 1, 5),
(2, 'chaussure', 0, 12000, 1, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `provision`
-- 

CREATE TABLE `provision` (
  `idprov` int(11) NOT NULL auto_increment,
  `prodprov` int(11) NOT NULL,
  `qtprov` int(11) NOT NULL,
  `dtprov` date NOT NULL,
  PRIMARY KEY  (`idprov`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `provision`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `reglement`
-- 

CREATE TABLE `reglement` (
  `idreg` int(11) NOT NULL auto_increment,
  `cltreg` int(11) NOT NULL,
  `dtreg` date NOT NULL,
  `mtreg` int(11) NOT NULL,
  PRIMARY KEY  (`idreg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `reglement`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `soft`
-- 

CREATE TABLE `soft` (
  `idsoft` int(11) NOT NULL auto_increment,
  `libsoft` varchar(150) NOT NULL,
  `descrip` varchar(255) NOT NULL,
  `icone` varchar(150) NOT NULL,
  PRIMARY KEY  (`idsoft`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `soft`
-- 

INSERT INTO `soft` (`idsoft`, `libsoft`, `descrip`, `icone`) VALUES 
(1, 'trafic', 'Controle du trafique sur la plateforme', '../sdpicture/1.gif'),
(2, 'gestock', 'Gestion du stock', '../sdpicture/11.gif'),
(3, 'facturation', 'Edition des facture et proforma', '../sdpicture/2.gif'),
(4, 'utilisateur', 'Gestion des profils utilisateurs', '../sdpicture/5.gif'),
(5, 'clientele', 'Gestion des informations de la clientele', '../sdpicture/6.gif');

-- --------------------------------------------------------

-- 
-- Table structure for table `tva`
-- 

CREATE TABLE `tva` (
  `idtva` int(11) NOT NULL auto_increment,
  `valtva` float NOT NULL,
  PRIMARY KEY  (`idtva`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `tva`
-- 

INSERT INTO `tva` (`idtva`, `valtva`) VALUES 
(1, 0),
(2, 0.18);

-- --------------------------------------------------------

-- 
-- Table structure for table `utilisateur`
-- 

CREATE TABLE `utilisateur` (
  `teluser` int(11) NOT NULL,
  `nomuser` varchar(150) NOT NULL,
  `motpass` varchar(255) NOT NULL default '77bee1ce07ad8a5fa051af2fa883d566',
  `profil` varchar(150) NOT NULL default 'agent',
  PRIMARY KEY  (`teluser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `utilisateur`
-- 

INSERT INTO `utilisateur` (`teluser`, `nomuser`, `motpass`, `profil`) VALUES 
(97685178, 'olory suzon', '77bee1ce07ad8a5fa051af2fa883d566', 'admin');
