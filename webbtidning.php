<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Äspåröds Äventyrsblad!</title>
		<link type="text/css" rel="stylesheet" href="blad.css" />
	</head>

	<body>

	<div id="toplogo">
		<h1>Äspåröds Äventyrsblad!</h1>
		<p>Det senaste om det roligaste</p>
	</div>

	<div id="lnav">
		<?php
$link = mysqli_connect('195.178.235.60', 'm11k5638', 'jonasremgard');
if (!$link)
{
	echo('Unable to connect to the database server.');
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	echo('Unable to set database connection encoding.');
	exit();
}

if (!mysqli_select_db($link, 'm11k5638'))
{
	echo('Unable to locate the company database.');
	exit();
}

$sql = "select Kategorinamn, SubKategorinamn, SubKategoriID from Kategori inner join Sub_Kategori on Sub_Kategori.KategoriID=Kategori.KategoriID order by Kategori.KategoriID";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}

$owner = "";

echo("<ul>\n");
while ($row = mysqli_fetch_array($result))
{
	if (($row[0]!=$owner) && ($owner!="")){
			echo("\t</ul>\n</li>\n");
		}
	if ($row[0]!=$owner){
		echo('<li><a href="">'.$row[0]."</a>\n\t<ul>\n");
		$owner=$row[0];
	}
	echo('<li><a href="webbtidning.php?cat='.$row[2].'">'.$row[1].'</a></li>');


}
echo("\t</ul>\n</li>\n");
echo("</ul>\n");
?>
	</div>

	<div id="rightsplash">
		<h3>Våra mest kommenterade artiklar</h3>
		<?php
$link = mysqli_connect('195.178.235.60', 'm11k5638', 'jonasremgard');
if (!$link)
{
	echo('Unable to connect to the database server.');
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	echo('Unable to set database connection encoding.');
	exit();
}

if (!mysqli_select_db($link, 'm11k5638'))
{
	echo('Unable to locate the company database.');
	exit();
}

$sql = "select Artikel.ArtikelID, Artikel.Datum, Artikel.Rubrik, count(Kommentar.ArtikelID) as NumberOfComments from Kommentar left join Artikel on Kommentar.ArtikelID=Artikel.ArtikelID group by Rubrik order by NumberOfComments desc limit 3";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}


while ($row = mysqli_fetch_array($result))
{

	echo('<li><a href="webbartikel.php?ArtID='.$row[0].'">'.$row[2].' ('.$row[3].')</a></li>');
}
?>
	</div>

	<div id="content">
				<?php
$link = mysqli_connect('195.178.235.60', 'm11k5638', 'jonasremgard');
if (!$link)
{
	echo('Unable to connect to the database server.');
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	echo('Unable to set database connection encoding.');
	exit();
}

if (!mysqli_select_db($link, 'm11k5638'))
{
	echo('Unable to locate the company database.');
	exit();
}

$cat = $_GET['cat'];

if ($cat==null)
{
$sql = "select Rubrik, Ingress, Datum, ArtikelID from Artikel order by ArtikelID desc limit 5";
}
else
{
$sql = "select Rubrik, Ingress, Datum, ArtikelID from Artikel where SubKategoriID='$cat'";
}
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	echo('<div class="newsitem">');
	echo("\t\t<h2>".$row[0]."</h2>\n");
	echo('<h3>'.$row[2].'</h3>');
	echo('<p class="ingress">'.$row[1].'</p>');
	echo('<a href="webbartikel.php?ArtID='.$row[3].'">Läs mer --></a>');
	echo('</div>');
}
?>
	</div>
	</body>
</html>
