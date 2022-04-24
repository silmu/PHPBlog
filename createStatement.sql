drop database if exists blogdb_123;
create database blogdb_123;
use blogdb_123;

create table users(
    id integer(11) not null PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) not null,
    password varchar(50) not null
);

insert into users values(1, 'admin','12345');