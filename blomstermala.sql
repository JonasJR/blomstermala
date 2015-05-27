-- ==============================
-- Skapa databasen och använd den
-- Kommenteras så småningom bort
-- ==============================

create database Blomstermala;
use Blomstermala;

-- =======================
-- Droppa tabellerna först
-- =======================

drop table if exists Kan_Ha_Bild;
drop table if exists Kommentar;
drop table if exists Artikel;
drop table if exists Sub_Kategori;
drop table if exists Kategori;
drop table if exists Anvandare;
drop table if exists Bild;
drop table if exists Owner;

-- ==================
-- Skapa nya tabeller
-- ==================
 
create table Kategori
(KategoriID     int NOT NULL,
 Kategorinamn	varchar(50),
 primary key (KategoriID))ENGINE=InnoDB CHARACTER SET=utf8;
 
 create table Sub_Kategori
(SubKategoriID     int NOT NULL,
 SubKategorinamn	varchar(50),
 KategoriID			int NOT NULL,
 primary key (SubKategoriID),
 foreign key (KategoriID) references Kategori(KategoriID))ENGINE=InnoDB CHARACTER SET=utf8;
 
create table Artikel
(Rubrik			varchar(100),
 Ingress     		varchar(200),
 Brodtext     		text,
 Datum			date,
 ArtikelID		int NOT NULL,
 SubKategoriID	int NOT NULL,
 primary key (ArtikelID),
 foreign key (SubKategoriID) references Sub_Kategori(SubKategoriID))ENGINE=InnoDB CHARACTER SET=utf8;
 
create table Anvandare 
(AnvandarID	     int NOT NULL,
 Namn	     	varchar(30),
 Email	     	varchar(50),
 Password	varchar(20),
 Moderator	boolean,
 primary key(AnvandarID))ENGINE=InnoDB CHARACTER SET=utf8;
create table Bild
(Hojd		int,
Bredd		int,
AltText		varchar(100),
BildID		int,
AnvandarID	int,
Address		varchar(100),
primary key (BildID),
foreign key (AnvandarID) references Anvandare(AnvandarID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Kan_Ha_Bild
(ArtikelID		int,
BildID			int,
BildText		varchar(200),
primary key (ArtikelID, BildID),
foreign key (ArtikelID) references Artikel(ArtikelID),
foreign key (BildID) references Bild(BildID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Owner
(ArtikelID		int NOT NULL,
AnvandarID			int NOT NULL,
primary key (ArtikelID, AnvandarID),
foreign key (ArtikelID) references Artikel(ArtikelID),
foreign key (AnvandarID) references Anvandare(AnvandarID))ENGINE=InnoDB CHARACTER SET=utf8;

create table Kommentar
(Innehall	varchar(500),
ArtikelID	int NOT NULL,
KommentarID	int NOT NULL,
Datum		date,
Ok			boolean,
AnvandarID	int NOT NULL,
primary key (KommentarID),
foreign key (AnvandarID) references Anvandare(AnvandarID),
foreign key (ArtikelID) references Artikel(ArtikelID))ENGINE=InnoDB CHARACTER SET=utf8;


-- ============================
-- Fyll tabellerna med innehåll
-- ============================

insert into Kategori (KategoriID, Kategorinamn) values
(1,'Nyheter'),
(2,'Om Äspåröd'),
(3,'En till Kategori'),
(4,'Den sista kategorin');

insert into Sub_Kategori (SubKategoriID, SubKategoriNamn, KategoriID) values
(1,'En subkategori',3),
(2,'EntillSubKategori',2),
(3,'En tredje Subkategori',2),
(4,'Det finns många',3),
(5,'Många Subkategorier',1),
(6,'En hel drös',1),
(7,'Väldigt många',1);

insert into Anvandare (AnvandarID, Namn, Email,Password,Moderator) values
(00001,'Helge Knutsson','helge.knutsson@gmail.com','PASS', false),
(00002,'Arvid Sörensen', 'arvid.sorensen@gmail.com','PASS', false),
(00003,'Petter Järv','petter.jarv@gmail.com','PASS', false),
(00004,'Rasmus Mårtensson','rasmus.martenssen@gmail.com','PASS', false),
(00005,'Jerry Pedersen','jerry.ck.pedersen@gmail.com','nisse123',true),
(00006,'Jonas Remgård','jonas.remgard@gmail.com','nisse123',true);

insert into Artikel (ArtikelID, SubKategoriID, Rubrik, Ingress, Brodtext, Datum ) values
(1, 3,'Hemlösa får komma in gratis', 'Flera hemlösa har fått komma in gratis på Äventyrslandet','Här står en massa grejjer','2014-04-01'),
(2, 4,'Rubriken för andra','Ingressen för andra','Brödtexten för andra','2014-02-11'),
(3, 6,'Många har sett Äspåröd växa','Äspåröd är et av landets äldsta äventyrsparker',
'Riktigt lång text om hur bra äspåröd är. Det finns massor av grejer att göra här. 
Och man skryter även mycket om hur gammalt och fint äspåröd är men även nytänkande och ungdomligt','2012-01-02'),
(4, 1,'Next one','En mycket bra ingress för den här tredje','Här är hela artikeln asså. Den är mycket lång. Med flera meningar.','2014-05-22');

insert into Kommentar (KommentarID, Innehall, AnvandarID, ArtikelID, Datum, Ok) values
(000001,'Jag tycker att äspåröd är hemskt kul att va på! Jag är där varje sommar med mina föräldrar!',00002,3, '2014-05-04',1),
(000002,'Jag tycker också att det är kul!',00004,3,'2014-05-05',1),
(000003,'Jag kommer ihåg när jag var på Äspåröd för första gången! Oj, vad det har vuxit sedan dess!',00001,2,'2014-05-22',1),
(000004,'Jag tycker att äspåröd är hemskt kul att va på! Jag är där varje sommar med mina föräldrar!',00002,3, '2014-05-04',1),
(000005,'Jag tycker också att det är kul!',00004,3,'2014-05-05',1),
(000006,'Jag kommer ihåg när jag var på Äspåröd för första gången! Oj, vad det har vuxit sedan dess!',00001,2,'2014-05-22',1),
(000007,'Hej, Jag gillar Äspåröd!',00004,1,'2014-06-06',1);

insert into Bild (BildID, Hojd, Bredd, AltText, AnvandarID, Address) values
(0001,200,300,'Bild på vattenfall',00005,'media/valborgseld.jpg'),
(0002,755,500,'Bild på högt hus i parken',00006,'media/valborgseld.jpg'),
(0003,300,200,'Bild på trollet',00006,'media/valborgseld.jpg'),
(0004,500,755,'Bild på restaurangen',00006,'media/valborgseld.jpg');

insert into Kan_Ha_Bild (ArtikelID, BildID, BildText) values
(2,0003,'Trollet i trollskogen har blivit vandaliserat'),
(3,0003,'Den gangen da trollet blev vandaliserat'),
(4,0001,'Vattenfallet star fint kvar dar det alltid statt trots ombygnationerna i parken');

insert into Owner (ArtikelID, AnvandarID) values
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
