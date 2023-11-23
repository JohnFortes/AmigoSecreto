drop database if exists db_amigo_secreto;

create database db_amigo_secreto DEFAULT CHARSET=utf8;

use db_amigo_secreto;

create table usuarios (
	id int not null primary key auto_increment,
    nome varchar(70),
    email varchar(50),
    senha varchar(70)
)DEFAULT CHARSET=utf8;

create table amigos_secretos (
	id int not null primary key auto_increment,
    user_id int not null,
    nome varchar(30),
    data_cadastro datetime not null default now(),
    grupo bool default false,
    data_evento datetime, 
    status int default 0,
    foreign key (user_id) references usuarios (id)
)DEFAULT CHARSET=utf8; 

create table grupos (
	id int not null primary key auto_increment,
    amigo_secreto_id int not null,
    nome varchar(30) not null default 'Geral',
    foreign key (amigo_secreto_id) references amigos_secretos (id)
)DEFAULT CHARSET=utf8;

create table participantes (
	id int not null primary key auto_increment,
    user_id int,
    amigo_secreto_id int not null,
    grupo_id int not null,
    nome varchar (30),
    data_cadastro datetime not null default now(),
    foreign key (user_id) references usarios (id),
    foreign key (amigo_secreto_id) references amigos_secretos (id),
    foreign key (grupo_id) references grupos (id)
)DEFAULT CHARSET=utf8;

create table matchs (
	id int not null primary key auto_increment,
    amigo_secreto_id int not null,
    participante_id int not null,
    match_particimante varchar(20) not null,
    foreign key (amigo_secreto_id) references amigos_secretos (id),
    foreign key (participante_id) references participantes (id)
)DEFAULT CHARSET=utf8;
