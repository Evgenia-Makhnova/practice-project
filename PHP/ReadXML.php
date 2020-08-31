<html>
<head>
<title>Passing</title>
<link href="style/external.css?<?=time()?>" rel="stylesheet">
</head>
<body>
<div class='exiting'>
<?php
if (!isset($_SESSION))
			session_start();		
$_SESSION['testname'] = $_POST['testname'];
echo "Hello, ".$_SESSION['user'];
?>
<form action='exit.php'>
<input type='submit' value='Sign Out'>
</form> <hr><form action='results.php'> 
<input type='submit' value='Results'> 
</form>
</div>
<div class = 'testview'>
<h1><?php echo $_SESSION['testname'];?></h1>



<form action = 'review.php' method = 'POST'>
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
$doc->load('XML/tests.xml');
$root = getItemByName($doc, $_SESSION['testname'],'test');

$test=$root->getElementsByTagName("question");
$i=1;

foreach ($test as $q) {
    $question = $q->firstChild->nodeValue;
	$qType = $q->getAttribute("type");
    echo "<p><b>$question</b></p>";
    $ans=$q->getElementsByTagName("answer");
    
    $j = 1;
	if ($qType=='check'){
		foreach ($ans as $a){
        $answer = $a->nodeValue;
        echo "<input type='checkbox' class = 'radio' value = '$j' name = 'answer".$i."[]'>$answer<br>";
        $j++;
    }
	}
	if ($qType=='radio'){
	foreach ($ans as $a){
        $answer = $a->nodeValue;
        echo "<input type='radio' class = 'radio' value = '$j' name = 'answer$i'>$answer<br>";
        $j++;
    }
	}
	if ($qType=='text'){
		echo "<input type='text' class = 'text' name = 'answer$i'><br>";
        
	}
    $i++;
}
?>
<input type='submit' value = 'Done'>
</form>
</div>
</body>
</html>
