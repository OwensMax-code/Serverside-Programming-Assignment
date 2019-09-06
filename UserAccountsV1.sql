SET SQL_SAFE_UPDATES = 0;
drop database if exists Accounts;
create database if not exists Accounts;
use Accounts;

CREATE TABLE AccountDetails (
    accountID INTEGER AUTO_INCREMENT,
    firstName CHAR(40) NOT NULL,
    lastName CHAR(40) NOT NULL,
    userName VARCHAR(25) UNIQUE,
    userPassword VARCHAR(264) UNIQUE,
    emailAddress VARCHAR(30) UNIQUE,
    dateOfBirth DATE NOT NULL,
    phoneNo VARCHAR(20) NOT NULL,
    address1 VARCHAR(50) NOT NULL,
    address2 VARCHAR(50) NOT NULL,
    PRIMARY KEY (accountID)
)  ENGINE INNODB;

/*CREATE TABLE UpdatedAccountInfo (
    accountID INTEGER,
    oldInfo VARCHAR(100),
    newInfo VARCHAR(100),
    dateChanged DATE,
    PRIMARY KEY (accountID),
    FOREIGN KEY (accountID)
        REFERENCES AccountDetails (accountID)
)  ENGINE INNODB;*/

CREATE TABLE UserAccount (
    userName VARCHAR(25) UNIQUE NOT NULL,
    userPassword VARCHAR(264) UNIQUE NOT NULL,
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
    postTitle VARCHAR(50) NOT NULL,
    postContent VARCHAR(500) NOT NULL,
    userName VARCHAR(25) NOT NULL,
    PRIMARY KEY (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

CREATE TABLE BlogComment (
    commentID INTEGER AUTO_INCREMENT,
    postID INTEGER NOT NULL,
    commentContent VARCHAR(300) NOT NULL,
    userName VARCHAR(25) NOT NULL,
    PRIMARY KEY (commentID),
    FOREIGN KEY (postID)
        REFERENCES BlogPost (postID),
    FOREIGN KEY (userName)
        REFERENCES UserAccount (userName)
)  ENGINE INNODB;

  -- Update trigger which encrypts password 
 
delimiter $$
 create trigger EncryptPassword before insert on AccountDetails
 for each row
 begin 
 set new.userPassword = SHA2(new.userPassword, 256);
 end$$
 delimiter ;
 
 -- update trigger which creates a simple user login table, for bridging with the blog post/comment tables
 
 delimiter $$
 create trigger CreateUserLogin after insert on AccountDetails
 for each row
 begin 
 insert into UserAccount values (new.userName, new.userPassword, new.AccountID);
 end$$
 delimiter ;
 
  -- trigger which adds to table whenever a detail is changed from account details

  /*delimiter $$
  create trigger DetailChange after update on AccountDetails
  for each row
  begin
  insert into UpdatedAccountInfo values (new.accountID, new.userName, userName, CURRENT_TIMESTAMP());
  end$$
  delimiter ;*/

  -- first creating an account complete with information and with username and password. Trigger automatically fills the UserAccount table. 
  
insert into AccountDetails values (null,"Amit","Sarkar","AmitTheSlayer6969","password3","AmitLordOfTheSun@NZGardner.com",'1000-12-25',033352456,"34 Kingly Street, Calimara","PO Box Fishman"); 
insert into AccountDetails values (null,"Nick","Leslie","SnickerMan","ImBald","Glenda12@NZGardner.com",'2004-01-11',033453623,"University of Canterbury","PO Box UC"); 
insert into AccountDetails values (null,"Emily","Chuck 'E' Cheese","WheresMySuperSuit","Fibbonacci","erangleMan@gmail.com",'1997-05-22',034968394,"8 Newsons Road","RD3 Cheviot"); 
insert into AccountDetails values (null,"Spup","M'larky","MrKansas","flubber","FlatEarthSociety@FESAdmin.com",'1990-05-04',035903456,"NASA","Miami, FL"); 

update AccountDetails set userName = "Calamari Joe" where AccountID = 2;
select userName from AccountDetails where AccountID = 2;
select * from AccountDetails;

insert into BlogPost values (null,"I love all the sirens","sing sing sing sing isng isngsigsngodugnhogundgridrgidgrdrgubdgr","AmitTheSlayer6969");
insert into BlogPost values (null,"Ping Ping is the best","fthy6dubdb6uytedjtdyujhytedujhytiuhbd65eu56u","MrKansas");
insert into BlogPost values (null,"Please help; my teacher is trying to kill me","I genuinely think I am in extreme danger. send help","WheresMySuperSuit");
insert into BlogPost values (null,"I lost my dog somewhere in the park","A group of angry cousins came at me with knives. Big troubles lie ahead.","WheresMySuperSuit");
insert into BlogPost values (null,"Good lord, this website!","This is by far the greatest website I have EVER seen. Keep up the A+ work! I am so happy whenever I visit this website.","MrKansas");

insert into BlogComment values (null,2,"I agree with this post!","AmitTheSlayer6969");
insert into BlogComment values (null,3,"I am feeling ok with this post!","Snickerman");
insert into BlogComment values (null,3,"I am angry with this post!","WheresMySuperSuit");
insert into BlogComment values (null,1,"I am providing feedback to this post!","AmitTheSlayer6969");
insert into BlogComment values (null,1,"Lost my dog?","AmitTheSlayer6969");
insert into BlogComment values (null,1,"I disagree with this post!","AmitTheSlayer6969");

select * from UserAccount;

 -- View which retrieves some account details from userAccount table

CREATE VIEW basicUserInfo AS
    SELECT 
        U.userName,
        A.firstName,
        A.lastName,
        A.emailAddress
    FROM
        UserAccount U
            INNER JOIN
        AccountDetails A ON U.accountID = A.accountID
    WHERE
        U.accountID = A.accountID;

 -- View which displays blog post with the comment count

CREATE VIEW BlogMostComments AS
    SELECT 
        B.postTitle, COUNT(C.commentID) AS TotalComments
    FROM
        BlogPost B
            INNER JOIN
        BlogComment C ON B.postID = C.postID
    WHERE
        B.postID = C.PostID
    GROUP BY B.postTitle;

 -- View which displays users and their total posts
 
CREATE VIEW UsersTotalPosts as
	SELECT
		U.userName, COUNT(B.postID) as TotalPosts
	FROM
		userAccount U
			INNER JOIN
		BlogPost B on U.userName = B.userName
	WHERE
		U.userName = B.userName
	GROUP BY U.userName; 

    
															select * from UsersTotalPosts;
                                                            select * from BlogMostComments;
                                                            select * from basicUserInfo;
    