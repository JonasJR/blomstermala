-- ==============================
-- Skapa databasen och använd den
-- Kommenteras så småningom bort
-- ==============================

create database Blomstermala;
use Blomstermala;

-- =======================
-- Droppa tabellerna först
-- =======================

drop table if exists Picture_Article_Relation;
drop table if exists Comment;
drop table if exists Article;
drop table if exists Sub_Category;
drop table if exists Category;
drop table if exists User;
drop table if exists Picture;
drop table if exists Owner;

-- ==================
-- Skapa nya tabeller
-- ==================
 
create table Category
(CategoryID     int NOT NULL,
 Categoryname	varchar(50),
 primary key (CategoryID))ENGINE=InnoDB CHARACTER SET=utf8;
 
 create table Sub_Category
(SubCategoryID     int NOT NULL,
 SubCategoryname	varchar(50),
 CategoryID			int NOT NULL,
 primary key (SubCategoryID),
 foreign key (CategoryID) references Category(CategoryID))ENGINE=InnoDB CHARACTER SET=utf8;
 
create table Article
(Title			varchar(100),
 Preamble     		varchar(200),
 Content     		text,
 Date			date,
 ArticleID		int NOT NULL,
 SubCategoryID	int NOT NULL,
 primary key (ArticleID),
 foreign key (SubCategoryID) references Sub_Category(SubCategoryID))ENGINE=InnoDB CHARACTER SET=utf8;
 
create table User 
(UserID	     int NOT NULL,
 Name	     	varchar(30),
 Email	     	varchar(50),
 Password	varchar(20),
 Moderator	boolean,
 primary key(UserID))ENGINE=InnoDB CHARACTER SET=utf8;
create table Picture
(Height		int,
Width		int,
AltText		varchar(100),
PictureID		int,
UserID	int,
Address		varchar(100),
primary key (PictureID),
foreign key (UserID) references User(UserID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Picture_Article_Relation
(ArticleID		int,
PictureID			int,
PictureText		varchar(200),
primary key (ArticleID, PictureID),
foreign key (ArticleID) references Article(ArticleID),
foreign key (PictureID) references Picture(PictureID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Owner
(ArticleID		int NOT NULL,
UserID			int NOT NULL,
primary key (ArticleID, UserID),
foreign key (ArticleID) references Article(ArticleID),
foreign key (UserID) references User(UserID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Comment
(Content	varchar(500),
ArticleID	int NOT NULL,
CommentID	int NOT NULL,
Date		date,
Ok			boolean,
UserID	int NOT NULL,
primary key (CommentID),
foreign key (UserID) references User(UserID),
foreign key (ArticleID) references Article(ArticleID))ENGINE=InnoDB CHARACTER SET=utf8;


-- ============================
-- Fyll tabellerna med innehåll
-- ============================

insert into Category (CategoryID, Categoryname) values
(1,'Nyheter'),
(2,'Om Äspåröd'),
(3,'En till Category'),
(4,'Den sista Categoryn');

insert into Sub_Category (SubCategoryID, SubCategoryname, CategoryID) values
(1,'En subCategory',3),
(2,'EntillSubCategory',2),
(3,'En tredje SubCategory',2),
(4,'Det finns många',3),
(5,'Många SubCategoryer',1),
(6,'En hel drös',1),
(7,'Väldigt många',1);

insert into User (UserID, Name, Email,Password,Moderator) values
(00001,'Helge Knutsson','helge.knutsson@gmail.com','PASS', false),
(00002,'Arvid Sörensen', 'arvid.sorensen@gmail.com','PASS', false),
(00003,'Petter Järv','petter.jarv@gmail.com','PASS', false),
(00004,'Rasmus Mårtensson','rasmus.martenssen@gmail.com','PASS', false),
(00005,'Jerry Pedersen','jerry.ck.pedersen@gmail.com','nisse123',true),
(00006,'Jonas Remgård','jonas.remgard@gmail.com','nisse123',true);

insert into Article (ArticleID, SubCategoryID, Title, Preamble, Content, Date ) values
(1, 3,'Hemlösa får komma in gratis', 'Flera hemlösa har fått komma in gratis på Äventyrslandet','Här står en massa grejjer','2014-04-01'),
(2, 4,'Titleen för andra','Preambleen för andra','Brödtexten för andra','2014-02-11'),
(3, 6,'Många har sett Äspåröd växa','Äspåröd är et av landets äldsta äventyrsparker',
'Riktigt lång text om hur bra äspåröd är. Det finns massor av grejer att göra här. 
Och man skryter även mycket om hur gammalt och fint äspåröd är men även nytänkande och ungdomligt','2012-01-02'),
(4, 1,'Next one','En mycket bra Preamble för den här tredje','Här är hela Articlen asså. Den är mycket lång. Med flera meningar.','2014-05-22');

insert into Comment (CommentID, Content, UserID, ArticleID, Date, Ok) values
(000001,'Jag tycker att äspåröd är hemskt kul att va på! Jag är där varje sommar med mina föräldrar!',00002,3, '2014-05-04',1),
(000002,'Jag tycker också att det är kul!',00004,3,'2014-05-05',1),
(000003,'Jag kommer ihåg när jag var på Äspåröd för första gången! Oj, vad det har vuxit sedan dess!',00001,2,'2014-05-22',1),
(000004,'Jag tycker att äspåröd är hemskt kul att va på! Jag är där varje sommar med mina föräldrar!',00002,3, '2014-05-04',1),
(000005,'Jag tycker också att det är kul!',00004,3,'2014-05-05',1),
(000006,'Jag kommer ihåg när jag var på Äspåröd för första gången! Oj, vad det har vuxit sedan dess!',00001,2,'2014-05-22',1),
(000007,'Hej, Jag gillar Äspåröd!',00004,1,'2014-06-06',1);

insert into Picture (PictureID, Height, Width, AltText, UserID, Address) values
(0001,200,300,'Picture på vattenfall',00005,'media/valborgseld.jpg'),
(0002,755,500,'Picture på högt hus i parken',00006,'media/valborgseld.jpg'),
(0003,300,200,'Picture på trollet',00006,'media/valborgseld.jpg'),
(0004,500,755,'Picture på restaurangen',00006,'media/valborgseld.jpg');

insert into Picture_Article_Relation (ArticleID, PictureID, PictureText) values
(2,0003,'Trollet i trollskogen har blivit vandaliserat'),
(3,0003,'Den gangen da trollet blev vandaliserat'),
(4,0001,'Vattenfallet star fint kvar dar det alltid statt trots ombygnationerna i parken');

insert into Owner (ArticleID, UserID) values
(1,00005),
(1,00006),
(3,00005),
(4,00005),
(2,00005),
(2,00006),
(3,00006);

-- ============================
-- Fixa resterande foreign keys
-- ============================
