/*
Navicat MySQL Data Transfer

Source Server         : FUTFÁCIL
Source Server Version : 50548
Source Host           : skorp.com.br:3306
Source Database       : futfacil_web

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2016-03-13 17:37:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for futfacil_capitao
-- ----------------------------
DROP TABLE IF EXISTS `futfacil_capitao`;
CREATE TABLE `futfacil_capitao` (
  `ID` int(5) NOT NULL AUTO_INCREMENT COMMENT 'SALVA O ID DO CAPITÃO DO TIME',
  `DATA_REGISTRO` datetime NOT NULL COMMENT 'REGISTRA A DATA DE QUE O CAPITÃO SE CADASTROU',
  `ULTIMO_LOGIN` datetime NOT NULL COMMENT 'REGISTRA O ULTIMO LOGIN DO CAPITÃO',
  `NOME` text NOT NULL COMMENT 'SALVA O NOME DO CAPITÃO  DO TIME',
  `EMAIL` text NOT NULL COMMENT 'SALVA O EMAIL DO CAPITÃO DO TIME',
  `TELEFONE` text NOT NULL COMMENT 'SALVA O EMAIL DO CAPITÃO DO TIME',
  `FLAGS` text NOT NULL COMMENT 'DEFINE A FLAG DE ACESSO DO USUÁRIO',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`,`TELEFONE`(4)),
  FULLTEXT KEY `FLAGS` (`FLAGS`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of futfacil_capitao
-- ----------------------------
INSERT INTO `futfacil_capitao` VALUES ('1', '2015-09-08 22:23:41', '2015-09-08 22:23:41', 'Luigi Matheus Afornalli Breda', 'luigimatheus@skorp.com.br', '(41) 9661-5848', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('2', '2015-09-08 23:13:50', '2015-09-08 23:13:50', 'zika zika zika', 'zika@zika.co', '(41) 41', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('3', '2015-09-09 17:18:51', '2015-09-09 17:18:51', 'zika aikaka ', 'iwejf@eifjif.com', '(45) 654', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('4', '2015-09-09 17:20:36', '2015-09-09 17:20:36', 'wge', 'wegweg@efef.com', '(46) 54', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('5', '2015-09-09 17:20:52', '2015-09-09 17:20:52', 'wfgwe', 'fgwegfwe#rgwg.com', '(45) 464', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('6', '2015-09-09 17:21:10', '2015-09-09 17:21:10', 'wegweg', 'weg@wgee.com', '(52) 21-3211', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('7', '2015-09-09 20:59:12', '2015-09-09 20:59:12', 'rayron magno moura marques', 'rayronmagno@live.com', '(41) 8734-9827', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('8', '2015-09-16 15:39:33', '2015-09-16 15:39:33', 'e', 'sample@email.tst', 'e', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('9', '2015-10-17 01:20:59', '2015-10-17 01:20:59', 'zika do bagylho', 'lkeelgk@eg.com', '(41) 6565-6565', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('10', '2015-10-22 04:54:30', '2015-10-22 04:54:30', 'ziak do bagukho', 'lgimatbrd@gmail.com', '(99) 9999-9999', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('11', '2015-10-22 09:43:11', '2015-10-22 09:43:11', 'Registre-se', 'igor.s@skorp.com.br', '(31) 99477-7958', 'FLAG_ZERO');
INSERT INTO `futfacil_capitao` VALUES ('12', '2015-10-24 04:14:53', '2015-10-24 04:14:53', 'jeieje suejjejd', 'lu@lu.com', '(00) 0000-0000', 'FLAG_ZERO');

-- ----------------------------
-- Table structure for futfacil_jogos
-- ----------------------------
DROP TABLE IF EXISTS `futfacil_jogos`;
CREATE TABLE `futfacil_jogos` (
  `JOGO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `JOGO_DATA` date DEFAULT NULL,
  `JOGO_PERIODO` text,
  `JOGO_TIME_1` int(11) DEFAULT NULL,
  `JOGO_TIME_2` int(11) DEFAULT NULL,
  `JOGO_TELEFONE_CONF` text,
  `JOGO_APROVADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`JOGO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of futfacil_jogos
-- ----------------------------

-- ----------------------------
-- Table structure for futfacil_times
-- ----------------------------
DROP TABLE IF EXISTS `futfacil_times`;
CREATE TABLE `futfacil_times` (
  `JOGADOR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `JOGADOR_CAPITAO` int(11) NOT NULL,
  `JOGADOR_POS` text NOT NULL COMMENT 'POSIÇÃO DO JOGADOR',
  `JOGADOR_NOME` text NOT NULL COMMENT 'NOME DO JOGADOR',
  `JOGADOR_TELEFONE` text NOT NULL COMMENT 'TELEFONE DO JOGADOR',
  PRIMARY KEY (`JOGADOR_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of futfacil_times
-- ----------------------------
INSERT INTO `futfacil_times` VALUES ('1', '1', 'GL', 'Jose743eee', '(41) 850-1667');
INSERT INTO `futfacil_times` VALUES ('2', '1', 'LE', 'NENHUM2', '(22) 2-2222');
INSERT INTO `futfacil_times` VALUES ('3', '1', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('4', '1', 'LD', 'NENHUM231', '(00) 0000-0001');
INSERT INTO `futfacil_times` VALUES ('5', '1', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('6', '1', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('7', '1', 'AD', 'Julio cesar2', '(41) 9767-8678');
INSERT INTO `futfacil_times` VALUES ('8', '2', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('9', '2', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('10', '2', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('11', '2', 'LD', 'jaiosjaiosj', '(12) 4-4124');
INSERT INTO `futfacil_times` VALUES ('12', '2', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('13', '2', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('14', '2', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('15', '3', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('16', '3', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('17', '3', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('18', '3', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('19', '3', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('20', '3', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('21', '3', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('22', '4', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('23', '4', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('24', '4', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('25', '4', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('26', '4', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('27', '4', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('28', '4', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('29', '5', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('30', '5', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('31', '5', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('32', '5', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('33', '5', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('34', '5', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('35', '5', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('36', '6', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('37', '6', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('38', '6', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('39', '6', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('40', '6', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('41', '6', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('42', '6', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('43', '7', 'GL', 'Joao ', '(40) 45454-5645');
INSERT INTO `futfacil_times` VALUES ('44', '7', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('45', '7', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('46', '7', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('47', '7', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('48', '7', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('49', '7', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('50', '8', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('51', '8', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('52', '8', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('53', '8', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('54', '8', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('55', '8', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('56', '8', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('57', '9', 'GL', 'ttttt', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('58', '9', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('59', '9', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('60', '9', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('61', '9', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('62', '9', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('63', '9', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('64', '10', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('65', '10', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('66', '10', 'MC', 'NENHUM2', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('67', '10', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('68', '10', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('69', '10', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('70', '10', 'AD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('71', '11', 'GL', 'NENHUM20', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('72', '11', 'LE', 'NENHUM4', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('73', '11', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('74', '11', 'LD', 'NENHUM3', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('75', '11', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('76', '11', 'AC', 'NENHUM5', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('77', '11', 'AD', 'NENHUM1', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('78', '12', 'GL', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('79', '12', 'LE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('80', '12', 'MC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('81', '12', 'LD', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('82', '12', 'AE', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('83', '12', 'AC', 'NENHUM', '(00) 0000-0000');
INSERT INTO `futfacil_times` VALUES ('84', '12', 'AD', 'NENHUM', '(00) 0000-0000');
