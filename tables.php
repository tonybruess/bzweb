<?php
/*
create table files (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` text,`owner` VARCHAR(200),`type` VARCHAR(10),`contents` text);

create table groups (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,`name` VARCHAR(100),`owner` VARCHAR(100),`status` INT,`enabled` INT);

create table servers (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`master` INT NOT NULL,`name` TEXT,`owner` TEXT,`status` INT,`style` VARCHAR(5),`j` INT,`r` INT,`ms` INT,`noradar` INT,`autoteam` INT,`mp` INT,`rogue` INT,`red` INT,`green` INT,`blue` INT,`purple` INT,`observer` INT,`user` TEXT,`group` TEXT,`ban` TEXT,`report` TEXT,`nomasterban` INT,`fa` INT,`fcl` INT,`ff` INT,`fg` INT,`fgm` INT,`fib` INT,`fl` INT,`fmg` INT,`fn` INT,`foo` INT,`fpz` INT,`fqt` INT,`fsb` INT,`fse` INT,`fsh` INT,`fsr` INT,`fst` INT,`fsw` INT,`ft` INT,`fth` INT,`fus` INT,`fv` INT,`fwg` INT,`fb` INT,`sb` INT,`worldfile` TEXT,`b` INT,`h` INT,`worldsize` INT,`public` TEXT,`p` INT,`domain` TEXT,`disablebots` INT,`servermsg` TEXT,`admsg` TEXT,`enabled` INT NOT NULL);

create table players (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`serverowner` TEXT,`name` TEXT,`ip` VARCHAR(100),`host VARCHAR(200),`description` TEXT,`bzid` VARCHAR(50),`time` VARCHAR(100));

create table reports (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`server` INT,`serverowner` TEXT,`reporter` TEXT,`report` TEXT,`time` VARCHAR(100));

create table settings (`site` TEXT,`email` TEXT,`bzfs` TEXT,`domain1` TEXT,`domain2` TEXT,`domain3` TEXT, `domain4` TEXT, `global` int,`local` int);

create table users (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`bzid` INT, `permissions` INT,`pstart` INT,`pend` INT,`last login` INT);

create table roles (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` TEXT,`permissions` VARCHAR(100));
*/
?>