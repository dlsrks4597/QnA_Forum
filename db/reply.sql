create table board (
   num int not null auto_increment,
   con_num int not null;
   id char(15) not null,
   name char(10) not null,
   content text not null,
   regist_day  TIMESTAMP     NOT NULL DEFAULT current_timestamp(),
   hit int not null,
   file_name char(40),
   file_type char(40),
   file_copied char(40),
   primary key(num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
