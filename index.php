<?php
  include('db.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Blomstermåla</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>

	<body>

	<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1>Blomstermåla</h1>
			<p>Dagbladet</p>
		</div>
	</div>

	<div class="row">
	<div class="col-md-4">
	<?php
    $sql = "select Category.CategoryID, Categoryname, SubCategoryname, SubCategoryID from Category left join Sub_Category on Sub_Category.CategoryID=Category.CategoryID order by Category.CategoryID";

    $result = mysqli_query($link, $sql);
    if (!$result) {
      echo('Error processing query: ' . mysqli_error($link));
      exit();
    }

$owner = "";

echo("<ul>\n");
while ($row = mysqli_fetch_array($result))
{
	if (($row[1]!=$owner) && ($owner!="")){
			echo("\t</ul>\n</li>\n");
		}
	if ($row[1]!=$owner){
		echo('<li><a href="index.php?cat='.$row[0].'&sub_cat=0">'.$row[1]."</a>\n\t<ul>\n");
		$owner=$row[1];
	}
	echo('<li><a href="index.php?cat='.$row[0].'&sub_cat='.$row[3].'">'.$row[2].'</a></li>');
}
echo("\t</ul>\n</li>\n");
echo("</ul>\n");
?>
	</div>
	<div class="col-md-4">
				<?php

$cat = $_GET['cat'];
$sub_cat = $_GET['sub_cat'];

if ($cat==null)
{
	$sql = "select Title, Preamble, Date, ArticleID from Article order by ArticleID desc limit 5";
}
else
{
	if ($sub_cat=="0"){
	$sql = "select Title, Preamble, Date, ArticleID from Article join Sub_Category on Article.SubCategoryID=Sub_Category.SubCategoryID join Category on Sub_Category.CategoryID=Category.CategoryID where Category.CategoryID='$cat'";
}
	else{
		$sql = "select Title, Preamble, Date, ArticleID from Article join Sub_Category on Article.SubCategoryID=Sub_Category.SubCategoryID join Category on Sub_Category.CategoryID=Category.CategoryID where Sub_Category.SubCategoryID='$sub_cat' and Category.CategoryID='$cat'";
	}
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
	echo('<a href="Article.php?ArtID='.$row[3].'">Läs mer --></a>');
	echo('</div>');
}
?>
	</div>
	<div class="col-md-4">
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

	echo('<li><a href="Article.php?ArtID='.$row[0].'">'.$row[2].' ('.$row[3].')</a></li>');
}
?>
	</div>
	</div>
	</body>
</html>
