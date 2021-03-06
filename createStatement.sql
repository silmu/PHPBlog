drop database if exists blogdb_123;
create database blogdb_123;
use blogdb_123;

create table posts(
    id integer(11) not null PRIMARY KEY AUTO_INCREMENT,
    user_id integer not null,
    title varchar(50) not null,
    created_at timestamp default CURRENT_TIMESTAMP,
    content text(2000) not null
);

create table users(
    id integer(11) not null PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) not null,
    password varchar(225) not null
);

insert into users (username, password) values('admin','$2y$10$8TPxdezukchhytwqBI5PUO.RN1zziBbDWmd4b6EFiUBgjbebO3vY6');
insert into users (username, password) values('admin2','$2y$10$.Uj37hvvjqgcI64tKuqSbexXqEx3Sjmyt3wWZb8mtEuUOFQ5FZyIi');

insert into posts (user_id, title, content) values (1, 'Day 1', 'Dear diary...');
insert into posts (user_id, title, content) values (1, 'Day 2', 'Dear diary...again');
insert into posts (user_id, title, content) values (2, 'Entry 1', 'Some text');
insert into posts (user_id, title, content) values (2, 'Entry 2', 'Some text...again');