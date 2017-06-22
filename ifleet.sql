/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ifleet

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-06-22 17:05:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for controles
-- ----------------------------
DROP TABLE IF EXISTS `controles`;
CREATE TABLE `controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of controles
-- ----------------------------

-- ----------------------------
-- Table structure for itenscontrole
-- ----------------------------
DROP TABLE IF EXISTS `itenscontrole`;
CREATE TABLE `itenscontrole` (
  `id` int(11) NOT NULL,
  `veiculo` int(11) DEFAULT NULL,
  `km` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of itenscontrole
-- ----------------------------

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
INSERT INTO `marcas` VALUES ('1', 'Fiat');
INSERT INTO `marcas` VALUES ('2', 'VW');
INSERT INTO `marcas` VALUES ('3', 'Chevrolet');
INSERT INTO `marcas` VALUES ('4', 'Ford');
INSERT INTO `marcas` VALUES ('5', 'Hyundai');
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
INSERT INTO `modelos` VALUES ('2', 'Bandeirantes', '1', '0');
INSERT INTO `modelos` VALUES ('3', 'Mobi', '1', '0');
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
-- Table structure for veiculos
-- ----------------------------
DROP TABLE IF EXISTS `veiculos`;
CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(7) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  `kilometro_inicial` int(11) DEFAULT NULL,
  `codigo_gps` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of veiculos
-- ----------------------------
INSERT INTO `veiculos` VALUES ('1', 'BOO0000', '7', null, null);
INSERT INTO `veiculos` VALUES ('2', 'MVS2850', '17', null, null);
INSERT INTO `veiculos` VALUES ('3', 'NHH1795', '15', null, null);
INSERT INTO `veiculos` VALUES ('4', 'NHI9544', '8', null, null);
INSERT INTO `veiculos` VALUES ('5', 'NHK9985', '15', null, null);
INSERT INTO `veiculos` VALUES ('6', 'NHP3113', '15', null, null);
INSERT INTO `veiculos` VALUES ('7', 'NHQ6642', '15', null, null);
INSERT INTO `veiculos` VALUES ('8', 'NHQ7924', '15', null, null);
INSERT INTO `veiculos` VALUES ('9', 'PSA6349', '7', null, null);
INSERT INTO `veiculos` VALUES ('10', 'NHQ9498', '15', null, null);
INSERT INTO `veiculos` VALUES ('11', 'NHR4171', '15', null, null);
INSERT INTO `veiculos` VALUES ('12', 'NMP6142', '15', null, null);
INSERT INTO `veiculos` VALUES ('13', 'NMP8619', '15', null, null);
INSERT INTO `veiculos` VALUES ('14', 'NMZ6959', '15', null, null);
INSERT INTO `veiculos` VALUES ('15', 'NMZ7125', '15', null, null);
INSERT INTO `veiculos` VALUES ('16', 'NMZ7965', '15', null, null);
INSERT INTO `veiculos` VALUES ('17', 'NNG3189', '16', null, null);
INSERT INTO `veiculos` VALUES ('18', 'NNH1795', '7', null, null);
INSERT INTO `veiculos` VALUES ('19', 'NWW7148', '11', null, null);
INSERT INTO `veiculos` VALUES ('20', 'NWW7607', '12', null, null);
INSERT INTO `veiculos` VALUES ('21', 'NWW7617', '12', null, null);
INSERT INTO `veiculos` VALUES ('22', 'NWW8650', '11', null, null);
INSERT INTO `veiculos` VALUES ('23', 'NWZ2883', '7', null, null);
INSERT INTO `veiculos` VALUES ('24', 'NWZ3107', '7', null, null);
INSERT INTO `veiculos` VALUES ('25', 'OIW3569', '11', null, null);
INSERT INTO `veiculos` VALUES ('26', 'OIW5403', '11', null, null);
INSERT INTO `veiculos` VALUES ('27', 'OIZ3408', '8', null, null);
INSERT INTO `veiculos` VALUES ('28', 'OJJ0386', '12', null, null);
INSERT INTO `veiculos` VALUES ('29', 'OJJ6074', '11', null, null);
INSERT INTO `veiculos` VALUES ('30', 'OJJ6114', '12', null, null);
INSERT INTO `veiculos` VALUES ('31', 'OJJ8924', '9', null, null);
INSERT INTO `veiculos` VALUES ('32', 'OJK0241', '12', null, null);
INSERT INTO `veiculos` VALUES ('33', 'OJK6628', '12', null, null);
INSERT INTO `veiculos` VALUES ('34', 'OJK7165', '12', null, null);
INSERT INTO `veiculos` VALUES ('35', 'OJL9730', '9', null, null);
INSERT INTO `veiculos` VALUES ('36', 'OJM2887', '8', null, null);
INSERT INTO `veiculos` VALUES ('37', 'OJM6965', '12', null, null);
INSERT INTO `veiculos` VALUES ('38', 'OJM7761', '12', null, null);
INSERT INTO `veiculos` VALUES ('39', 'OJN2220', '12', null, null);
INSERT INTO `veiculos` VALUES ('40', 'OJO4257', '9', null, null);
INSERT INTO `veiculos` VALUES ('41', 'OXQ5413', '13', null, null);
INSERT INTO `veiculos` VALUES ('42', 'OXV6813', '13', null, null);
INSERT INTO `veiculos` VALUES ('43', 'OXV7074', '12', null, null);
INSERT INTO `veiculos` VALUES ('44', 'OXW1665', '11', null, null);
INSERT INTO `veiculos` VALUES ('45', 'OXW1685', '11', null, null);
INSERT INTO `veiculos` VALUES ('46', 'OXW3012', '11', null, null);
INSERT INTO `veiculos` VALUES ('47', 'OXW5347', '12', null, null);
INSERT INTO `veiculos` VALUES ('48', 'OXW5367', '11', null, null);
INSERT INTO `veiculos` VALUES ('49', 'OXW7227', '11', null, null);
INSERT INTO `veiculos` VALUES ('50', 'OXW7500', '9', null, null);
INSERT INTO `veiculos` VALUES ('51', 'OXZ1058', '13', null, null);
INSERT INTO `veiculos` VALUES ('52', 'PSA6316', '7', null, null);
INSERT INTO `veiculos` VALUES ('53', 'PSA6346', '7', null, null);
INSERT INTO `veiculos` VALUES ('54', 'PSA7104', '12', null, null);
INSERT INTO `veiculos` VALUES ('55', 'PSA7908', '12', null, null);
INSERT INTO `veiculos` VALUES ('56', 'PSA7918', '12', null, null);
INSERT INTO `veiculos` VALUES ('57', 'PSB1505', '12', null, null);
INSERT INTO `veiculos` VALUES ('58', 'PSB1525', '12', null, null);
INSERT INTO `veiculos` VALUES ('59', 'PSB2179', '12', null, null);
INSERT INTO `veiculos` VALUES ('60', 'PSB2582', '14', null, null);
INSERT INTO `veiculos` VALUES ('61', 'PSB4877', '7', null, null);
INSERT INTO `veiculos` VALUES ('62', 'PSB5494', '8', null, null);
INSERT INTO `veiculos` VALUES ('63', 'PSB6904', '9', null, null);
INSERT INTO `veiculos` VALUES ('64', 'PSC1196', '10', null, null);
INSERT INTO `veiculos` VALUES ('65', 'PSC1312', '8', null, null);
INSERT INTO `veiculos` VALUES ('66', 'PSC1755', '9', null, null);
INSERT INTO `veiculos` VALUES ('67', 'PSC3900', '8', null, null);
INSERT INTO `veiculos` VALUES ('68', 'PSD4672', '13', null, null);
INSERT INTO `veiculos` VALUES ('69', 'PSD6757', '13', null, null);
INSERT INTO `veiculos` VALUES ('70', 'PSO2734', '7', null, null);
INSERT INTO `veiculos` VALUES ('71', 'PSO4601', '7', null, null);
INSERT INTO `veiculos` VALUES ('72', 'PSO6469', '7', null, null);
INSERT INTO `veiculos` VALUES ('73', 'PSO9490', '7', null, null);
INSERT INTO `veiculos` VALUES ('74', 'PSP7686', '13', null, null);
INSERT INTO `veiculos` VALUES ('75', 'PSQ9193', '13', null, null);
INSERT INTO `veiculos` VALUES ('76', 'PSQ9728', '13', null, null);
INSERT INTO `veiculos` VALUES ('77', 'PSR6950', '13', null, null);
INSERT INTO `veiculos` VALUES ('78', 'PST6828', '13', null, null);
INSERT INTO `veiculos` VALUES ('79', 'PSU0969', '13', null, null);
INSERT INTO `veiculos` VALUES ('80', 'PSV2058', '18', null, null);
INSERT INTO `veiculos` VALUES ('81', 'PSV2096', '18', null, null);
INSERT INTO `veiculos` VALUES ('82', 'PSV5513', '18', null, null);
INSERT INTO `veiculos` VALUES ('83', 'PSV6721', '7', null, null);
INSERT INTO `veiculos` VALUES ('84', 'PSV7195', '7', null, null);
INSERT INTO `veiculos` VALUES ('85', 'PSV8190', '15', null, null);
INSERT INTO `veiculos` VALUES ('86', 'PSV9117', '17', null, null);
INSERT INTO `veiculos` VALUES ('87', 'PSW0022', '16', null, null);
INSERT INTO `veiculos` VALUES ('88', 'ROC0000', '7', null, null);
