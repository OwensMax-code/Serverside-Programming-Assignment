SET SQL_SAFE_UPDATES = 0;
drop database Accounts;
create database Accounts;
use Accounts;

CREATE TABLE AccountDetails (
    accountID INTEGER AUTO_INCREMENT,
    firstName CHAR(40),
    lastName CHAR(40),
    emailAddress VARCHAR(30),
    dateOfBirth DATE,
    phoneNo INTEGER,
    address1 VARCHAR(50),
    address2 VARCHAR(50),
    PRIMARY KEY (accountID)
)  ENGINE INNODB;

CREATE TABLE UserAccount (
    userID INTEGER AUTO_INCREMENT,
    userName VARCHAR(25),
    userPassword VARCHAR(32),
    accountID INTEGER,
    UNIQUE KEY (userName),
    PRIMARY KEY (userID),
    FOREIGN KEY (accountID)
        REFERENCES AccountDetails (accountID)
)  ENGINE INNODB;

CREATE TABLE BlogPost (
    postID INTEGER AUTO_INCREMENT,
    postTitle VARCHAR(30),
    postContent VARCHAR(500),
    userName VARCHAR(25),
    UNIQUE KEY (userName),
    PRIMARY KEY (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

CREATE TABLE BlogComment (
    commentID INTEGER AUTO_INCREMENT,
    postID INTEGER,
    commentContent VARCHAR(300),
    userName VARCHAR(25),
	UNIQUE KEY (userName),
    PRIMARY KEY (commentID),
    FOREIGN KEY (postID)
        REFERENCES BlogPost (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

 -- first creating an account with username and password. Both of these forms will be entered at the same time, so something will exist to update the IDs.

insert into AccountDetails values (null,"Amit","Sarkar","AmitLordOfTheSun@NZGardner.com",'1000-12-25',033352456,"34 Kingly Street, Calimara","PO Box Fishman"); 
insert into AccountDetails values (null,"Nick","Leslie","Glenda12@NZGardner.com",'2004-01-11',033453623,"University of Canterbury","PO Box UC"); 
insert into AccountDetails values (null,"Emily","Chuck 'E' Cheese","erangleMan@gmail.com",'1997-05-22',034968394,"8 Newsons Road","RD3 Cheviot"); 
insert into AccountDetails values (null,"Spup","M'larky","FlatEarthSociety@FESAdmin.com",'1990-05-04',035903456,"NASA","Miami, FL"); 

insert into UserAccount values (Null,"AmitTheSlayer6969","thebestpassword",null);
insert into UserAccount values (Null,"MrPoolCleaner","anevenb3tterpassword",null);
insert into UserAccount values (Null,"Wif.e","wheredidallmyteago",null);
insert into UserAccount values (Null,"CaptainClatcher","ohIfounditileftitonthetable",null);
    
SELECT 
	*
FROM
	AccountDetails;

SELECT 
    *
FROM
    UserAccount;
    
 -- update query which allocates the UserAccount to it's appropriate account ID. will be created at same time, so no worries
    
UPDATE UserAccount
inner join AccountDetails on UserAccount.userID = AccountDetails.AccountID
SET 
    UserAccount.accountID = AccountDetails.accountID
WHERE
    UserAccount.userID = AccountDetails.accountID;