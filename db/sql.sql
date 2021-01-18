

create table books(
	id int auto_increment,
	code varchar(40),
	name varchar(20) no null,
	description varchar(255),
	tag varchar(60),
	created_at datetime DEFAULT CURRENT_TIMESTAMP,
	updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	primary key(id)
);


create table users(
	id int auto_increment,
	fullname varchar(40),
	phone varchar(20),
	email varchar(60) not null,
	password varchar(400) not null,
	ip varchar(20),
	token varchar(500),
	block boolean default 0,
	lastlog datetime,
	created_at datetime DEFAULT CURRENT_TIMESTAMP,
	updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	primary key(id)
);

create table docs (
	id int auto_increment,
	title varchar(100) not null,
	description text null,
	user_id int not null,
	doc_link varchar(255) not null,
	created_at datetime DEFAULT CURRENT_TIMESTAMP,
	updated_at datetime DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	primary key(id)
);


create table doc_file (
	id int auto_increment,
	doc_id int not null,
	file_name varchar(100) not null,
	file_name2 varchar(100) not null,
	file_type varchar(100) null,
	file_link varchar(255) not null,
	created_at datetime DEFAULT CURRENT_TIMESTAMP,
	updated_at datetime DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	primary key(id)
);




INSERT INTO `users`(`id`, `fullname`, `phone`, `email`, `password`, `ip`, `token`, `block`, `lastlog`, `created_at`, `updated_at`) VALUES (1, 'MArk AI', 'xxx', 'mark@gmail.com', '$2y$10$X8ZdUjaULR/eD4olCBSQqOz4rU5G/9MGfax3wGY.fEoOPtijQ.MC6', NULL, NULL, 0, NULL, '2021-01-10 12:44:32', '2021-01-10 14:51:10');