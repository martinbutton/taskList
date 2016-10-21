create database tasklist;
use tasklist;
create table tasks(id int not null auto_increment primary key,
	startDate bigint unsigned,
	endDate bigint unsigned,
	title varchar(255),
	comments text,
	email varchar(255));

/* Uncomment below if user account also need creating */

/*
create user 'taskuser'@'localhost' identified by 'password';
grant select,insert,update,delete
	on tasklist.*
	to 'taskuser'@'localhost';
alter user 'taskuser'@'astro.outerorbit.org' password expire never;
*/

/* Create test data */
insert into tasks (startDate, endDate, title, comments, email) values (
	1000,
	2000,
	"Example Task",
	"This is an example task.",
	"marty@outerorbit.org");

delete from tasks where startDate=1000;
