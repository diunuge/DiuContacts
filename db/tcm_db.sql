-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 29, 2008 at 10:55 AM
-- Server version: 5.0.27
-- PHP Version: 5.2.0
-- 
-- Database: `tcm_db`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ind_contacts`
-- 

DROP TABLE IF EXISTS `ind_contacts`;
CREATE TABLE `ind_contacts` (
  `ind_contact_id` int(11) NOT NULL auto_increment,
  `ind_contact` varchar(254) collate latin1_general_ci NOT NULL,
  `ind_contact_date` date NOT NULL,
  `ind_address` varchar(254) collate latin1_general_ci default NULL,
  `ind_zip` varchar(64) collate latin1_general_ci default NULL,
  `ind_city` varchar(64) collate latin1_general_ci default NULL,
  `ind_provence` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`ind_contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `ind_discussions`
-- 

DROP TABLE IF EXISTS `ind_discussions`;
CREATE TABLE `ind_discussions` (
  `ind_discussion_id` int(11) NOT NULL auto_increment,
  `ind_contact_id` int(11) NOT NULL,
  `ind_discussion` text character set utf8 collate utf8_bin NOT NULL,
  `ind_discussion_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ind_discussion_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `ind_info`
-- 

DROP TABLE IF EXISTS `ind_info`;
CREATE TABLE `ind_info` (
  `ind_info_id` int(11) NOT NULL auto_increment,
  `ind_contact_id` int(11) NOT NULL,
  `ind_info_title` varchar(64) collate latin1_general_ci NOT NULL,
  `ind_info` varchar(254) collate latin1_general_ci NOT NULL,
  `ind_info_date` varchar(254) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`ind_info_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
