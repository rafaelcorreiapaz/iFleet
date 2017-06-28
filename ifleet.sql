/*
Navicat MySQL Data Transfer

Source Server         : 189.90.40.54
Source Server Version : 50530
Source Host           : 189.90.40.54:3306
Source Database       : ifleet

Target Server Type    : MYSQL
Target Server Version : 50530
File Encoding         : 65001

Date: 2017-06-28 17:04:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for controles
-- ----------------------------
DROP TABLE IF EXISTS `controles`;
CREATE TABLE `controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `fornecedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fornecedor` (`fornecedor`),
  CONSTRAINT `controles_ibfk_1` FOREIGN KEY (`fornecedor`) REFERENCES `fornecedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of controles
-- ----------------------------
INSERT INTO `controles` VALUES ('58', '2017-06-01', '2');

-- ----------------------------
-- Table structure for fornecedores
-- ----------------------------
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `cpfcnpj` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpfcnpj` (`cpfcnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fornecedores
-- ----------------------------
INSERT INTO `fornecedores` VALUES ('1', 'Auto Posto Quatro Rodas', '22704143000117');
INSERT INTO `fornecedores` VALUES ('2', 'Auto Posto Imprecol II', '10736373000189');
INSERT INTO `fornecedores` VALUES ('3', 'Posto Avenida', '02283661000288');
INSERT INTO `fornecedores` VALUES ('4', 'Posto Maranata', '22962786000160');
INSERT INTO `fornecedores` VALUES ('5', 'Posto R10', '20444802000106');
INSERT INTO `fornecedores` VALUES ('6', 'Posto Nova Esperança', '05386627000121');
INSERT INTO `fornecedores` VALUES ('7', 'Auto Posto São Sebastião', '11669248000166');
INSERT INTO `fornecedores` VALUES ('9', 'Wissae Web AAAA', '05022850362');
INSERT INTO `fornecedores` VALUES ('10', 'Posto Bom Jesus', '03847650335');

-- ----------------------------
-- Table structure for itenscontrole
-- ----------------------------
DROP TABLE IF EXISTS `itenscontrole`;
CREATE TABLE `itenscontrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `veiculo` int(11) DEFAULT NULL,
  `kilometro_atual` int(11) DEFAULT NULL,
  `categoria_controle` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `controle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of itenscontrole
-- ----------------------------
INSERT INTO `itenscontrole` VALUES ('26', '4', '10', '0', '50', '100', '58');

-- ----------------------------
-- Table structure for marcas
-- ----------------------------
DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of marcas
-- ----------------------------
INSERT INTO `marcas` VALUES ('1', 'Fiat II');
INSERT INTO `marcas` VALUES ('2', 'VW');
INSERT INTO `marcas` VALUES ('3', 'Chevrolet');
INSERT INTO `marcas` VALUES ('4', 'Ford');
INSERT INTO `marcas` VALUES ('5', 'teste');
INSERT INTO `marcas` VALUES ('6', 'Jeep');
INSERT INTO `marcas` VALUES ('7', 'Honda');
INSERT INTO `marcas` VALUES ('8', 'Mitsubishi');
INSERT INTO `marcas` VALUES ('9', 'Nissan');
INSERT INTO `marcas` VALUES ('10', 'Peugeot');
INSERT INTO `marcas` VALUES ('11', 'Renault');
INSERT INTO `marcas` VALUES ('12', 'Toyota');
INSERT INTO `marcas` VALUES ('13', 'Yamaha');

-- ----------------------------
-- Table structure for modelos
-- ----------------------------
DROP TABLE IF EXISTS `modelos`;
CREATE TABLE `modelos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) DEFAULT NULL,
  `marca` int(11) DEFAULT NULL,
  `tipo` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marca` (`marca`),
  CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`marca`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modelos
-- ----------------------------
INSERT INTO `modelos` VALUES ('2', 'Bandeirantes II', '1', '0');
INSERT INTO `modelos` VALUES ('3', 'Mobi II', '1', '0');
INSERT INTO `modelos` VALUES ('4', 'CG 150 Titan', '1', '1');
INSERT INTO `modelos` VALUES ('5', 'Pálio', '1', '0');
INSERT INTO `modelos` VALUES ('6', 'XTE 125', '1', '1');
INSERT INTO `modelos` VALUES ('7', 'Factor 4BR 125', '1', '1');
INSERT INTO `modelos` VALUES ('8', 'YBR', '1', '1');
INSERT INTO `modelos` VALUES ('9', 'Fan 125', '1', '1');
INSERT INTO `modelos` VALUES ('10', 'Uno Miller', '1', '0');
INSERT INTO `modelos` VALUES ('11', 'Uno', '1', '0');
INSERT INTO `modelos` VALUES ('12', 'Strada', '1', '0');
INSERT INTO `modelos` VALUES ('13', 'Up', '1', '0');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `usuario` varchar(32) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'Rafael Correia', 'rafael', '123456');
INSERT INTO `usuarios` VALUES ('2', 'Wissae Web II', 'wissae', '123464');
INSERT INTO `usuarios` VALUES ('3', 'Bruno Buguno', 'brunoo', '123456');

-- ----------------------------
-- Table structure for veiculos
-- ----------------------------
DROP TABLE IF EXISTS `veiculos`;
CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(7) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  `kilometro_inicial` int(11) DEFAULT NULL,
  `kilometro_revisao` int(11) DEFAULT NULL,
  `periodo_revisao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of veiculos
-- ----------------------------
INSERT INTO `veiculos` VALUES ('1', 'BOO0000', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('2', 'MVS2850', '5', '500', '1000', '12');
INSERT INTO `veiculos` VALUES ('3', 'NHH1795', '15', '50', '1000', '6');
INSERT INTO `veiculos` VALUES ('4', 'NHI9544', '8', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('5', 'NHK9985', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('6', 'NHP3113', '15', '445', '1000', '6');
INSERT INTO `veiculos` VALUES ('7', 'NHQ6642', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('8', 'NHQ7924', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('9', 'PSA6349', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('10', 'NHQ9498', '15', '45', '1000', '6');
INSERT INTO `veiculos` VALUES ('11', 'NHR4171', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('12', 'NMP6142', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('13', 'NMP8619', '15', '54', '1000', '6');
INSERT INTO `veiculos` VALUES ('14', 'NMZ6959', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('15', 'NMZ7125', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('16', 'NMZ7965', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('17', 'NNG3189', '16', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('18', 'NNH1795', '7', '54', '1000', '6');
INSERT INTO `veiculos` VALUES ('19', 'NWW7148', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('20', 'NWW7607', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('21', 'NWW7617', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('22', 'NWW8650', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('23', 'NWZ2883', '7', '54', '1000', '6');
INSERT INTO `veiculos` VALUES ('24', 'NWZ3107', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('25', 'OIW3569', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('26', 'OIW5403', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('27', 'OIZ3408', '8', '54', '1000', '6');
INSERT INTO `veiculos` VALUES ('28', 'OJJ0386', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('29', 'OJJ6074', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('30', 'OJJ6114', '12', '1000', '1000', '6');
INSERT INTO `veiculos` VALUES ('31', 'OJJ8924', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('32', 'OJK0241', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('33', 'OJK6628', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('34', 'OJK7165', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('35', 'OJL9730', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('36', 'OJM2887', '8', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('37', 'OJM6965', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('38', 'OJM7761', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('39', 'OJN2220', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('40', 'OJO4257', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('41', 'OXQ5413', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('42', 'OXV6813', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('43', 'OXV7074', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('44', 'OXW1665', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('45', 'OXW1685', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('46', 'OXW3012', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('47', 'OXW5347', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('48', 'OXW5367', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('49', 'OXW7227', '11', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('50', 'OXW7500', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('51', 'OXZ1058', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('52', 'PSA6316', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('53', 'PSA6346', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('54', 'PSA7104', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('55', 'PSA7908', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('56', 'PSA7918', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('57', 'PSB1505', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('58', 'PSB1525', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('59', 'PSB2179', '12', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('60', 'PSB2582', '14', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('61', 'PSB4877', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('62', 'PSB5494', '8', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('63', 'PSB6904', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('64', 'PSC1196', '10', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('65', 'PSC1312', '8', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('66', 'PSC1755', '9', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('67', 'PSC3900', '8', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('68', 'PSD4672', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('69', 'PSD6757', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('70', 'PSO2734', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('71', 'PSO4601', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('72', 'PSO6469', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('73', 'PSO9490', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('74', 'PSP7686', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('75', 'PSQ9193', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('76', 'PSQ9728', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('77', 'PSR6950', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('78', 'PST6828', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('79', 'PSU0969', '13', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('80', 'PSV2058', '18', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('81', 'PSV2096', '18', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('82', 'PSV5513', '18', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('83', 'PSV6721', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('84', 'PSV7195', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('85', 'PSV8190', '15', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('86', 'PSV9117', '17', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('87', 'PSW0022', '16', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('88', 'ROC0000', '7', '0', '1000', '6');
INSERT INTO `veiculos` VALUES ('89', 'FQV0038', '2', '5', '2', '6');
INSERT INTO `veiculos` VALUES ('90', 'FCC0055', '3', '0', '10000', '6');
