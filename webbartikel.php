<?php
  include('db.php');
?>

<!DOCTYPE html>
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

	<div id="artikel">
		<?php

$ArtID = $_GET['ArtID'];

$sql = "select Artikel.ArtikelID, Artikel.Rubrik, Artikel.Ingress, Artikel.Brodtext, Artikel.Datum from Artikel where ArtikelID='$ArtID'";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}

$row = mysqli_fetch_array($result);

$sql = "select Kan_Ha_Bild.BildID, Kan_Ha_Bild.BildText, Bild.AltText, Bild.Address, Fotograf.Namn from Kan_Ha_Bild left join Bild on Kan_Ha_Bild.BildID=Bild.BildID left join Fotograf on Bild.FotografID=Fotograf.FotografID where ArtikelID='$ArtID'";
$result = mysqli_query($link, $sql);
$row1 = mysqli_fetch_array($result);

echo('<h2>'.$row[1].'</h2>');
echo('<h3>'.$row[4].'</h3>');
echo('<div class="bildfloat">');
echo('<img src="'.$row1[3].'" alt="'.$row1[2].'" />');
echo('<cite>'.$row1[1].'</cite>');
echo('</div>');
echo('<p class"ingress">'.$row[2].'</p><p>'.$row[3].'</p>');

$sql = "select Owner.AnstallningsID, Redaktionsmedlem.Namn from Owner left join Redaktionsmedlem on Owner.AnstallningsID=Redaktionsmedlem.AnstallningsID where ArtikelID='$ArtID'";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}

while ($row2 = mysqli_fetch_array($result))
{
echo('<address>'.$row2[1].', redaktör</address>');
}

if ($row1 == null)
{

}
else
{
echo('<address>'.$row1[4].', fotograf</address>');
}

?>

	</div>

	</body>
</html>
