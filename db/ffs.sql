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
