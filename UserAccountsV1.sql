SET SQL_SAFE_UPDATES = 0;
drop database Accounts;
create database if not exists Accounts;
use Accounts;

CREATE TABLE AccountDetails (
    accountID INTEGER AUTO_INCREMENT,
    firstName CHAR(40) NOT NULL,
    lastName CHAR(40) NOT NULL,
    userName VARCHAR(25) UNIQUE,
    userPassword VARCHAR(32) UNIQUE,
    emailAddress VARCHAR(30) UNIQUE,
    dateOfBirth DATE NOT NULL,
    phoneNo INTEGER NOT NULL,
    address1 VARCHAR(50) NOT NULL,
    address2 VARCHAR(50) NOT NULL,
    PRIMARY KEY (accountID)
)  ENGINE INNODB;

CREATE TABLE UserAccount (
    userName VARCHAR(25) UNIQUE NOT NULL,
    userPassword VARCHAR(32) UNIQUE NOT NULL,
    accountID INTEGER NOT NULL,
    PRIMARY KEY (userName),
    FOREIGN KEY (accountID)
        REFERENCES AccountDetails (accountID),
    FOREIGN KEY (userName)
        REFERENCES AccountDetails (userName),
    FOREIGN KEY (userPassword)
        REFERENCES AccountDetails (userPassword)
)  ENGINE INNODB;

CREATE TABLE BlogPost (
    postID INTEGER AUTO_INCREMENT,
    postTitle VARCHAR(30) NOT NULL,
    postContent VARCHAR(500) NOT NULL,
    userName VARCHAR(25) UNIQUE NOT NULL,
    PRIMARY KEY (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

CREATE TABLE BlogComment (
    commentID INTEGER AUTO_INCREMENT,
    postID INTEGER NOT NULL,
    commentContent VARCHAR(300) NOT NULL,
    userName VARCHAR(25) UNIQUE NOT NULL,
    PRIMARY KEY (commentID),
    FOREIGN KEY (postID)
        REFERENCES BlogPost (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

 -- first creating an account complete with information and with username and password. 
 -- update trigger which creates a simple user login table, for bridging with the blog post/comment tables
 
 drop trigger CreateUserLogin;
 
 delimiter $$
 create trigger CreateUserLogin after insert on AccountDetails
 for each row
 begin 
 insert into UserAccount values (new.userName, new.userPassword, new.AccountID);
 end$$
 delimiter ;
 
insert into AccountDetails values (null,"Amit","Sarkar","AmitTheSlayer6969","password3","AmitLordOfTheSun@NZGardner.com",'1000-12-25',033352456,"34 Kingly Street, Calimara","PO Box Fishman"); 
insert into AccountDetails values (null,"Nick","Leslie","SnickerMan","ImBald","Glenda12@NZGardner.com",'2004-01-11',033453623,"University of Canterbury","PO Box UC"); 
insert into AccountDetails values (null,"Emily","Chuck 'E' Cheese","WheresMySuperSuit","Fibbonacci","erangleMan@gmail.com",'1997-05-22',034968394,"8 Newsons Road","RD3 Cheviot"); 
insert into AccountDetails values (null,"Spup","M'larky","MrKansas","flubber","FlatEarthSociety@FESAdmin.com",'1990-05-04',035903456,"NASA","Miami, FL"); 


    
 -- 
 
    
    

/*UPDATE UserAccount
inner join AccountDetails on UserAccount.userID = AccountDetails.AccountID
SET 
    UserAccount.accountID = AccountDetails.accountID
WHERE
    UserAccount.userID = AccountDetails.accountID;*/
    
    
    
    