# $Id: mysql.sql,v 1.1 2006/03/28 04:08:17 mikhail Exp $
# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Nov 12, 2003 at 05:37 PM
# Server version: 3.23.58
# PHP Version: 4.3.3
# 
# Database : `xoops`
# 
# --------------------------------------------------------
#
# Table structure for table `artigos_cat`
#
CREATE TABLE `artigos_cat` (
    `id`              INT(10)     NOT NULL AUTO_INCREMENT,
    `cat_parent_id`   INT(10)     NOT NULL DEFAULT '0',
    `cat_name`        VARCHAR(50) NOT NULL DEFAULT '0',
    `cat_description` TEXT,
    `cat_weight`      INT(10)     NOT NULL DEFAULT '0',
    `cat_showme`      INT(5)      NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
)
    ENGINE = ISAM;
# --------------------------------------------------------
#
# Table structure for table `artigos_main`
#
CREATE TABLE `artigos_main` (
    `id`                  INT(10)      NOT NULL AUTO_INCREMENT,
    `art_author_id`       INT(10)      NOT NULL DEFAULT '0',
    `art_author_ip`       VARCHAR(15)  NOT NULL DEFAULT '0',
    `art_cat_id`          INT(10)      NOT NULL DEFAULT '0',
    `art_title`           VARCHAR(100) NOT NULL DEFAULT '0',
    `art_description`     TEXT,
    `art_artigo_text`     TEXT,
    `art_posted_datetime` DATETIME     NOT NULL DEFAULT '0000-00-00 00:00:00',
    `art_validated`       INT(5)       NOT NULL DEFAULT '0',
    `art_showme`          INT(5)       NOT NULL DEFAULT '0',
    `art_views`           INT(10)      NOT NULL DEFAULT '0',
    `art_last_update`     DATETIME     NOT NULL DEFAULT '0000-00-00 00:00:00',
    `art_last_update_by`  INT(5)       NOT NULL DEFAULT '0',
    `art_last_update_ip`  VARCHAR(15)  NOT NULL DEFAULT '0',
    `art_weight`          INT(10)      NOT NULL DEFAULT '0',
    `art_nohtml`          INT(1)       NOT NULL DEFAULT '0',
    `art_nosmiley`        INT(1)       NOT NULL DEFAULT '0',
    `art_noxcode`         INT(1)       NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
)
    ENGINE = ISAM;
# --------------------------------------------------------
#
# Table structure for table `artigos_rating`
#
CREATE TABLE `artigos_rating` (
    `id`             INT(10)     NOT NULL AUTO_INCREMENT,
    `rate_artigo_id` INT(10)     NOT NULL DEFAULT '0',
    `rate_user_id`   INT(10)     NOT NULL DEFAULT '0',
    `rate_user_ip`   VARCHAR(15) NOT NULL DEFAULT '0',
    `rate_datetime`  DATETIME    NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
)
    ENGINE = ISAM;
