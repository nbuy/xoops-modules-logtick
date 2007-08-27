# Logtick Module for XOOPS
# $Id: mysql.sql,v 1.1 2007/08/27 02:42:20 nobu Exp $

#
# Table structure for table `logtick_cat`
#   category table
#

CREATE TABLE logtick_cat (
  catid  integer unsigned NOT NULL auto_increment,
  cuid   integer NOT NULL default '0',
  cname  varchar(60) NOT NULL default '',
  description text,
  PRIMARY KEY  (catid)
);

CREATE TABLE logtick_usercat (
  uidref  integer NOT NULL default '0',
  catref  integer NOT NULL default '0',
  weight  integer NOT NULL default '0',
  KEY (catref, uidref)
);

#
# Table structure for table `logtick_log`
#   logging raw record in this table
#

CREATE TABLE logtick_log (
  logid integer unsigned NOT NULL auto_increment,
  pcat  integer NOT NULL default '0',
  luid  integer NOT NULL default '0',
  ltime integer NOT NULL default '0',
  mtime integer NOT NULL default '0',
  lspan integer NOT NULL default '0',
  comment tinytext,
  PRIMARY KEY  (logid)
);
