create table comments (
   parent_comment_id char(15) not null,
   name char(10) not null,
   comment text not null,
   comment_sender_name char(15) not null,
   comment_day  TIMESTAMP     NOT NULL DEFAULT current_timestamp(),
   primary key(parent_comment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO comments(parent_comment_id,comment,comment_sender_name,date
-- INSERT INTO comments(parent_comment_id,name,comment,comment_sender_name,comment_day
