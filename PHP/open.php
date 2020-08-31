<html>
<head>
<title>Opening</title>
<link href="style/external.css?<?=time()?>" rel="stylesheet">
</head>
<body>
<div class='exiting'>
<?php 
if (!isset($_SESSION['user']))
	session_start();
echo "Здравствуй, ".$_SESSION['user'];
?>
<form action='exit.php'>
<input type='submit' value='Sign Out'>
</form> <hr>
<form action='results.php'> 
<input type='submit' value='Results'> 
</form>
</div>
<h1 class = 'review'>Выберите тест</h1>
<div class='showing'><table>
<?php
function getItemByName($doc,$name,$tag)
{
    foreach($doc->getElementsByTagName($tag) as $item)
    {
        if($item->getAttribute("name") == $name)
        {
            return $item;
        }
    }
}

$doc = new DOMDocument("1.0", "utf-8");
$doc->load("XML/tests.xml");
$tests = $doc->getElementsByTagName('test');
foreach ($tests as $item){
	
	echo "<form action='ReadXML.php' method='POST'>";
	
	$res=$item->getAttribute("name");
	echo "<input type='text' name='testname' hidden value='$res' hidden>
	<tr><td><input type='submit' class='testname'  value ='$res' ></td>";
	if ($_SESSION['user']=='Teacher')
	{
		echo "<td><input type='submit' value = 'Delete' formaction = 'Delete.php'></td>
		<td><input type='submit' value = 'Edit' formaction = 'Edit.php'></td></tr>";
	}
	echo "</form>";
}
?>
</table>
</div><hr>
<form>
<input type='submit' class='back' value = 'Назад' formaction = 'index.php'>
</form><br>
</body>
</html>
