/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : ffs

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2017-12-16 15:58:35
*/
CREATE DATABASE IF NOT EXISTS ffs;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user
-- ----------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` char(36) NOT NULL COMMENT 'ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `created_by` char(36) DEFAULT NULL COMMENT '记录创建者',
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录修改时间',
  `modified_by` char(36) DEFAULT NULL COMMENT '记录修改者',
  PRIMARY KEY (`id`),
  KEY `ix_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
REPLACE INTO `user` VALUES ('da74a20b-e233-11e7-95ba-60a44c592f69', 'admin', '123', '$2y$10$AmwQdUyxdDBjMhx3ueGdvev9FytTGkLg7HfMN8RI7zjoXYQYn6lra', '', '', '10', '10', '2017-12-16 15:37:07', null, '2017-12-16 15:48:34', null);


-- ----------------------------
-- Table structure for agents
-- ----------------------------
CREATE TABLE IF NOT EXISTS `agents` (
  `id` char(36) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT '名称',
  `start_station` varchar(50) NOT NULL COMMENT '始发站',
  `simple_code` varchar(50) NOT NULL COMMENT '简码',
  `financial_code` varchar(50) NOT NULL COMMENT '财务结算代码',
  `manager` varchar(50) NOT NULL COMMENT '经理',
  `manager_phone` varchar(50) NOT NULL COMMENT '经理电话',
  `query` varchar(100) NOT NULL COMMENT '查询',
  `query_phone` char(11) NOT NULL COMMENT '查询手机',
  `add_goods` varchar(200) NOT NULL COMMENT '加货',
  `add_goods_phone` char(11) NOT NULL COMMENT '加货手机',
  `dispatch` varchar(200) NOT NULL COMMENT '调度',
  `dispatch_fax` varchar(30) NOT NULL COMMENT '调度传真',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `created_by` char(36) DEFAULT NULL COMMENT '记录创建者',
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录修改时间',
  `modified_by` char(36) DEFAULT NULL COMMENT '记录修改者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理人表';

-- ----------------------------
-- Table structure for flight
-- ----------------------------
CREATE TABLE IF NOT EXISTS `flight` (
  `id` char(36) NOT NULL,
  `flight_num` varchar(20) NOT NULL COMMENT '航班号',
  `flight_model` varchar(50) NOT NULL COMMENT '机型',
  `air_line` varchar(50) NOT NULL COMMENT '航线',
  `schedule` varchar(50) NOT NULL COMMENT '班期',
  `start_station` varchar(50) NOT NULL COMMENT '始发站',
  `take_off_1` varchar(50) NOT NULL COMMENT '起飞1',
  `land_1` varchar(50) NOT NULL COMMENT '降落1',
  `stopover_station` char(11) NOT NULL COMMENT '经停站',
  `take_off_2` varchar(50) NOT NULL COMMENT '起飞2',
  `land_2` varchar(50) NOT NULL COMMENT '降落2',
  `destination_station` char(11) NOT NULL COMMENT '目的站',
  `start_date` varchar(50) NOT NULL COMMENT '开始日期',
  `end_date` varchar(50) NOT NULL COMMENT '结束日期',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `created_by` char(36) DEFAULT NULL COMMENT '记录创建者',
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录修改时间',
  `modified_by` char(36) DEFAULT NULL COMMENT '记录修改者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='航班表';


-- ----------------------------
-- Table structure for goods_class
-- ----------------------------
CREATE TABLE IF NOT EXISTS `goods_class` (
  `id` char(36) NOT NULL,
  `flight_station` varchar(20) NOT NULL COMMENT '航站',
  `freight_rates_code` varchar(50) NOT NULL COMMENT '运价代码',
  `product_name` varchar(100) NOT NULL COMMENT '品名',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `created_by` char(36) DEFAULT NULL COMMENT '记录创建者',
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录修改时间',
  `modified_by` char(36) DEFAULT NULL COMMENT '记录修改者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货物种类表';

-- ----------------------------
-- Table structure for shipping
-- ----------------------------
CREATE TABLE IF NOT EXISTS `shipping_order` (
  `id` char(36) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT '订单类型：common, pg',
  `flight_date` varchar(20) NOT NULL COMMENT '航班日期',
  `prefix` varchar(20) NOT NULL COMMENT '前缀',
  `order_num` varchar(100) NOT NULL COMMENT '运单号',
  `start_station` varchar(50) DEFAULT NULL COMMENT '始发站',
  `stopover_station` char(11) DEFAULT NULL COMMENT '中转站',
  `destination_station` char(11) DEFAULT NULL COMMENT '目的站',
  `flight_num` varchar(20) DEFAULT NULL COMMENT '航班号',
  `simple_code` varchar(50) DEFAULT NULL,
  `freight_rates_code` varchar(50) DEFAULT NULL COMMENT '运价代码',
  `product_name` varchar(100) DEFAULT NULL COMMENT '品名',
  `quantity` int(4) DEFAULT '0' COMMENT '件数',
  `actual_weight` int(4) DEFAULT '0' COMMENT '实际重量',
  `billing_weight` int(4) DEFAULT '0' COMMENT '计费重量',
  `freight_rates` decimal(14,2) DEFAULT '0.00' COMMENT '费率（净运价）',
  `freight_fee` decimal(14,2) DEFAULT '0.00' COMMENT '航空运费',
  `fuel_fee` decimal(14,2) DEFAULT '0.00' COMMENT '燃油费',
  `freight_total_fee` decimal(14,2) DEFAULT '0.00' COMMENT '运费总额（含燃油）',
  `pg_quantity` int(4) DEFAULT '0' COMMENT '拉货件数',
  `pg_weight` int(4) DEFAULT '0' COMMENT '拉货重量',
  `pg_freight_rates` decimal(14,2) DEFAULT '0.00' COMMENT '拉货费率',
  `pg_loss_fee` decimal(14,2) DEFAULT '0.00' COMMENT '拉货损失金额',
  `pg_reason` varchar(255) DEFAULT NULL COMMENT '拉货原因',
  `pg_processing_method` varchar(100) DEFAULT NULL COMMENT '拉货处理方式',
  `pg_remark` varchar(255) DEFAULT NULL COMMENT '拉货备注',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `created_by` char(36) DEFAULT NULL COMMENT '记录创建者',
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录修改时间',
  `modified_by` char(36) DEFAULT NULL COMMENT '记录修改者',
  PRIMARY KEY (`id`),
  KEY `ix_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='运单表';
