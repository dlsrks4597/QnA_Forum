create table members (
    num int not null auto_increment,
    id char(15) not null,
    pass char(15) not null,
    name char(10) not null,
    email char(80) not null,
    regist_day  TIMESTAMP     NOT NULL DEFAULT current_timestamp(),
    level int,
    point int,
    tier char(10),
    tier_dir char(20),
    profile text,
    profile_img char(100),
    profile_img_dir char(120),
    board_like_num text,
    primary key(num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into members (id, pass, name, email, level, point, tier, tier_dir, profile, profile_img, profile_img_dir)
values ('admin', '123', '어드민', 'admin@gmail.com',  -1, 999999, 'admin.gif', './img/tier/admin.gif', '저는 이 게시판의 관리자입니다. ^^7', 'admin_profile.png', './data/pictures/admin_profile.png');
