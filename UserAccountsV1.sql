create database UserAccounts;
use UserAccounts;

create table Registration(
userID int primary key not null auto_increment,
firstName char(25),
lastName char(25),
email varchar(50),
userName varchar(25),
userPassword varchar(30)

)engine innodb;

create table Login(
loginID int primary key not null auto_increment,
userName varchar(25),
userPassword varchar(30),
foreign key (userName, userPassword) references Registration(userName, userPassword)
)engine innodb;