create user 'k190368' identified by 'hello123';
grant all privileges on ProductIdentifier to k190368; 
grant select on customer_validate to k190368;


create database TheComputerStore;
use TheComputerStore;

create table Brands (
	id int primary key auto_increment,
    name varchar(64) unique,
    logo varchar(256)
);


SET SQL_SAFE_UPDATES = 0;

insert into Brands(name, logo) values('Redragon', 'redragon.png');
insert into Brands(name, logo) values('Corsair', 'corsair.svg');
insert into Brands(name, logo) values('Corsir', 'corsair.svg');
insert into Brands(name, logo) values('Sony', 'sony.png');
insert into Brands(name, logo) values('XPG', 'xpg.png');

create table Customers (
	id int primary key auto_increment,
    email varchar(320) unique,
    password binary(60),
    firstName varchar(50),
    lastName varchar(50),
    phoneNumber varchar(11)
);

create table CustomerAddress (
	id int,
	addressLine varchar(256),
    state varchar(50),
    city varchar(50),
    zipCode varchar(8)
);

alter table CustomerAddress add constraint ca_fkey foreign key(id) references Customers(id);
alter table CustomerAddress add constraint ca_pkey primary key(id);


insert into Customers(email, firstName, lastName, phoneNumber) values('wylemustafa@gmail.com', 'Syed Wyle', 'Mustafa', '03142780999');
insert into Customers(email, firstName, lastName, phoneNumber) values('nylemustafa@gmail.com', 'Syed Nyle', 'Mustafa', '03313299175');
insert into CustomerAddress(id,addressLine, state, city, zipCode) values(1,'C-80, Sector 11-B, North Karachi','Sindh', 'Karachi','75850');



create table Categories (
	id int primary key auto_increment,
    name varchar(50) unique,
    parentID int default null
);
alter table Categories add constraint cat_fkey foreign key(parentID) references Categories(id) ON DELETE CASCADE;

insert into Categories(name, parentID) values('Motherboard', null);
insert into Categories(name, parentID) values('Graphics Card', null);
insert into Categories(name, parentID) values('ATX Motherboard', 1);


create table Products (
	id int primary key auto_increment,
    name varchar(50),
    price decimal(10, 2), 
    description text,
    brandID int default null,
    categoryID int
);

alter table Products add constraint p_fkey1 foreign key(brandID) references Brands(id);
alter table Products add constraint p_fkey2 foreign key(categoryID) references Categories(id);

create table ProductIdentifier (
    upc varchar(12),
    sku varchar(64),
    id int
);

alter table ProductIdentifier add constraint pi_pkey primary key(upc, sku);
alter table ProductIdentifier add constraint pi_fkey foreign key(id) references Products(id) ON DELETE CASCADE;

insert into Products(name, price, description, brandID, categoryID) values('560 4gb', 29.99, 'hehe', 18, 13);
insert into ProductIdentifier values('5s', 's', 6);
select * from ProductIdentifier;

create table ProductImages (
    id int,
    link varchar(256) unique
);

alter table ProductImages add constraint pimg_fkey foreign key(id) references Products(id) ON DELETE CASCADE;

create view ProductDetails as 
select p.id, pi.upc, pi.sku, pimg.link, p.name, p.price, p.description, b.name brandName, b.id brandID, c.id categoryID, c.name categoryName from Products p left join ProductIdentifier pi on p.id = pi.id left join ProductImages pimg on p.id = pimg.id left join Brands b on p.brandID = b.id join Categories c on p.categoryID = c.id group by p.id order by p.id;

drop table ProductImages;


select * from ProductDetails;
select count(id) from ProductDetails;


drop table ProductImages;

insert into ProductImages values(4, 'xpg.png');

delete from ProductDetails where id = 1;

select count(*) count from Products p left join Brands b on p.brandID = b.id left join Categories c on p.categoryID = c.id;

