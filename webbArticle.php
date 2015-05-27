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

    $sql = "select Categoryname, SubCategoryname, SubCategoryID from Category inner join Sub_Category on Sub_Category.CategoryID=Category.CategoryID order by Category.CategoryID";
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
    	echo('<li><a href="index.php?cat='.$row[2].'">'.$row[1].'</a></li>');


    }
    echo("\t</ul>\n</li>\n");
    echo("</ul>\n");
  ?>
  </div>

	<div class="col-md-8">
		<?php

$ArtID = $_GET['ArtID'];

$sql = "select Article.ArticleID, Article.Title, Article.Preamble, Article.Content, Article.Date from Article where ArticleID='$ArtID'";
$result = mysqli_query($link, $sql);
if (!$result)
{
	echo('Error processing query: ' . mysqli_error($link));
	exit();
}

$row = mysqli_fetch_array($result);

$sql = "select Picture_Article_Relation.PictureID, Picture_Article_Relation.PictureText, Picture.AltText, Picture.Address, User.Name from Picture_Article_Relation left join Picture on Picture_Article_Relation.PictureID=Picture.PictureID left join User on Picture.UserID=User.UserID where ArticleID='$ArtID'";
$result = mysqli_query($link, $sql);
$row1 = mysqli_fetch_array($result);

echo('<h2>'.$row[1].'</h2>');
echo('<h3>'.$row[4].'</h3>');
echo('<div class="Picturefloat">');
echo('<img src="'.$row1[3].'" alt="'.$row1[2].'" />');
echo('<cite>'.$row1[1].'</cite>');
echo('</div>');
echo('<p class"Preamble">'.$row[2].'</p><p>'.$row[3].'</p>');

$sql = "select Owner.UserID, User.Name from Owner left join User on Owner.UserID=User.UserID where ArticleID='$ArtID'";
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
	</div>
</div>
	</body>
</html>
