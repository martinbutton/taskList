/* Create Database and required tasks table */
create database tasklist;
use tasklist;
create table tasks(id int not null auto_increment primary key,
	startDate bigint unsigned,
	endDate bigint unsigned,
	title varchar(255),
	comments text,
	email varchar(255));

/* Uncomment below if user account also needs creating */

/*
create user 'taskuser'@'localhost' identified by 'password';
grant select,insert,update,delete
	on tasklist.*
	to 'taskuser'@'localhost';
alter user 'taskuser'@'astro.outerorbit.org' password expire never;
*/
