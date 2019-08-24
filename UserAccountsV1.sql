drop database UserAccounts;
create database UserAccounts;
use UserAccounts;

create table UserAccount (
userName varchar (25),
userPassword varchar (32),
primary key (userName)
)engine innodb;

create table AccountDetails (
accountID integer auto_increment,
firstName char (40),
lastName char (40),
userName varchar (25),
emailAddress varchar (30),
dateOfBirth date,
phoneNo int,
address1 varchar (50),
address2 varchar (50),
primary key (accountID),
foreign key (userName) references UserAccount(userName)
)engine innodb;

create table BlogPost (
postID integer auto_increment,
postTitle varchar (30),
postContent varchar (500),
userName varchar (25),
primary key (postID),
foreign key (userName) references UserAccount (userName)
)engine innodb;