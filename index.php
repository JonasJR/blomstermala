<?php
  include('db.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Blomstermåla</title>
    <link type="text/css" rel="stylesheet" href="blad.css" />
  </head>

	<body>

	<div id="toplogo">
		<h1>Blomstermåla</h1>
		<p>Dagbladet</p>
	</div>

	<div id="lnav">
	<?php
    $sql = "select Categoryname, SubCategoryname, SubCategoryID from Category inner join Sub_Category on Sub_Category.CategoryID=Category.CategoryID order by Category.CategoryID";

    $result = mysqli_query($link, $sql);
    if (!$result) {
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
	echo('<li><a href="index.php?cat='.$row[2].'">'.$row[1].'</a></li>');


}
echo("\t</ul>\n</li>\n");
echo("</ul>\n");
?>
	</div>

	<div id="rightsplash">
		<h3>Våra mest kommenterade artiklar</h3>
		<?php

$sql = "select Article.ArticleID, Article.Date, Article.Title, count(Comment.ArticleID) as NumberOfComments from Comment left join Article on Comment.ArticleID=Article.ArticleID group by Title order by NumberOfComments desc limit 3";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}


while ($row = mysqli_fetch_array($result))
{

	echo('<li><a href="webbArticle.php?ArtID='.$row[0].'">'.$row[2].' ('.$row[3].')</a></li>');
}
?>
	</div>

	<div id="content">
				<?php

$cat = $_GET['cat'];

if ($cat==null)
{
$sql = "select Title, Preamble, Date, ArticleID from Article order by ArticleID desc limit 5";
}
else
{
$sql = "select Title, Preamble, Date, ArticleID from Article where SubCategoryID='$cat'";
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
	echo('<p class="Preamble">'.$row[1].'</p>');
	echo('<a href="webbArticle.php?ArtID='.$row[3].'">Läs mer --></a>');
	echo('</div>');
}
?>
	</div>
	</body>
</html>
