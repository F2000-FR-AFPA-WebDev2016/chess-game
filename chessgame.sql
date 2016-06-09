-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- Serveur: 127.0.0.1
-- Généré le : Jeu 09 Juin 2016 à 16:38
-- Version du serveur: 5.1.49
-- Version de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `chessgame`
--

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `game`
--

INSERT INTO `game` (`id`, `data`, `created_date`, `status`) VALUES
(1, 'O:37:"Afpa\\ChessGameBundle\\Model\\Chessboard":11:{s:41:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0id";N;s:44:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0cases";N;s:44:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0board";a:8:{i:0;a:8:{i:0;O:31:"Afpa\\ChessGameBundle\\Model\\Rook":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:1;O:33:"Afpa\\ChessGameBundle\\Model\\Knight":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:2;O:33:"Afpa\\ChessGameBundle\\Model\\Bishop":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:3;O:31:"Afpa\\ChessGameBundle\\Model\\King":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:4;O:32:"Afpa\\ChessGameBundle\\Model\\Queen":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:5;r:16;i:6;r:11;i:7;r:6;}i:1;a:8:{i:0;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:1;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:2;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:3;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:4;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:5;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:6;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}i:7;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"black";s:11:"\0*\0position";N;}}i:2;a:8:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}i:3;a:8:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}i:4;a:8:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}i:5;a:8:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}i:6;a:8:{i:0;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:1;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:2;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:3;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:4;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:5;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:6;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:7;O:31:"Afpa\\ChessGameBundle\\Model\\Pawn":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}}i:7;a:8:{i:0;O:31:"Afpa\\ChessGameBundle\\Model\\Rook":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:1;O:33:"Afpa\\ChessGameBundle\\Model\\Knight":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:2;O:33:"Afpa\\ChessGameBundle\\Model\\Bishop":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:3;O:31:"Afpa\\ChessGameBundle\\Model\\King":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:4;O:32:"Afpa\\ChessGameBundle\\Model\\Queen":4:{s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0x";N;s:35:"\0Afpa\\ChessGameBundle\\Model\\Piece\0y";N;s:8:"\0*\0color";s:5:"white";s:11:"\0*\0position";N;}i:5;r:163;i:6;r:158;i:7;r:153;}}s:50:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0whitePieces";N;s:50:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0blackPieces";N;s:48:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0isInCheck";N;s:50:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0isCheckmate";N;s:49:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0playerTurn";s:5:"white";s:50:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0playerWhite";i:3;s:50:"\0Afpa\\ChessGameBundle\\Model\\Chessboard\0playerBlack";i:4;s:13:"\0*\0difficulty";i:0;}', '2016-06-08 11:28:05', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DA17977E48FD905` (`game_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nickname`, `email`, `password`, `game_id`) VALUES
(3, 'popo', 'popo@gmail.com', 'popo', 1),
(4, 'papa', 'papa@gmail.com', 'papa', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_2DA17977E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`);
