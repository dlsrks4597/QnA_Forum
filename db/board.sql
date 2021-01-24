create table board (
   num int not null auto_increment,
   thread int(11) unsigned not null,
   depth int(11) unsigned not null default '0',
   id char(15) not null,
   name char(10) not null,
   subject char(200) not null,
   content text not null,
   regist_day  TIMESTAMP     NOT NULL DEFAULT current_timestamp(),
   ip varchar(16) not null,
   hit int not null,
   file_name char(40),
   file_type char(40),
   file_copied char(40),
   importance int(1) not null,
   board_like int(5) unsigned not null default '0',
   alter table board add (comments int(5) not null),
   primary key(num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
