CREATE TABLE albumphoto(
    roomid varchar(255) not null,
    name varchar(255) not null,
    albumphoto varchar(255) not null,
    primary key(roomid, name, albumphoto),
    foreign key(roomid, name) references album(roomid, name) on delete cascade
);