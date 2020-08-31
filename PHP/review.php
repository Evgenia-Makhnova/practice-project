<html>
<head>
<link href="style/external.css?<?=time()?>" rel="stylesheet">
</head>
<body>
<div class='exiting'>
<?php
if (!isset($_SESSION['testname']))
	session_start();
echo "Здравствуй, ".$_SESSION['user'];
?>
<form action='exit.php'>
<input type='submit' value='Sign Out'>
</form> <hr>
<form action='results.php'> 
<input type='submit' value='Результат'> 
</form>
</div>
<div class='review'><h1>Ваш результат</h1><hr>
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
function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
	

$doc = new DOMDocument("1.0", "utf-8");
$doc->load('XML/tests.xml');
$root = getItemByName($doc, $_SESSION['testname'],'test');

$test=$root->getElementsByTagName("question");

$i=1;
$right = 0;
foreach ($test as $q) {
    $question = $q->firstChild->nodeValue;
	$qType = $q->getAttribute("type");
    echo "<h2>Вопрос: $question</h2>";
    $ans=$q->getElementsByTagName("answer");
    
    $j = 1;
	$checkCount = 0;
	if ($qType == "check"){
		foreach ($ans as $a){
			if ($a->getAttribute("correct") == 'y'){
			$checkCount++;}
		}
	}
	
    foreach ($ans as $a){
        $answer  = $a->nodeValue;
        if (!isset($_POST["answer$i"]))
            continue;
        else if ($qType == "text")
        {
            if  ($_POST["answer$i"] == $answer && $a->getAttribute("correct") == 'y'){
                echo "<h4 class='right-answer'>Ваш ответ: ".$_POST["answer$i"]."</h4>";
                $right++;
            }
            else if ($a->getAttribute("correct") == 'y'){
                echo "<h4 class='wrong-answer'>Ваш ответr: ".$_POST["answer$i"]."</h4>";
                echo "<h4 class='needed-answer'>Правильный ответ: $answer</h4>";
            }
        }
        else if ($qType == "check" && IsChecked("answer$i",$j)){
            if ($a->getAttribute("correct") == 'y'){
            echo "<h4 class='right-answer'>Ваш ответ: $answer</h4>";
            if($checkCount!=0)
				$right+=1/$checkCount;
            }
            else{
			if($checkCount!=0)
                $right-=1/$checkCount;
            echo "<h4 class='wrong-answer'>Ваш ответ: $answer</h4>";
            }
        }
		
        else if ($a->getAttribute("correct") == 'y' && $_POST["answer$i"] == $j){
            echo "<h4 class='right-answer'>Ваш ответ: $answer</h4>";
            $right++;
        }
        else if ($_POST["answer$i"] == $j){
            echo "<h4 class='wrong-answer'>Ваш ответ: $answer</h4>";
        }else if ($a->getAttribute("correct") == 'y')
            echo "<h4 class='needed-answer'>Правильный ответ: $answer</h4>";
        
        
        $j++;
    }
    $i++;
}
$right = round($right, 3);
echo "<h1> Ваша оценка ".($right).'/'.($i-1)."</h1>
<form><button class='back' formaction='index.php'>Назад</button></form>";

$res = new DOMDocument("1.0", "utf-8");
$res->load('XML/results.xml');
$root = $res->documentElement;
$element = $res->createElement('res');
$element->setAttribute('user', $_SESSION['user']);

if(($i-1)*100*100 == 0)
	$grade=0;
else
	$grade=ceil(($right)/($i-1)*100*100)/100;

$element->setAttribute('grade', $grade);
$element->setAttribute('test', $_SESSION['testname']);
$root->appendChild($element);
$res->save('XML/results.xml');

?>
</div>
</body>
</html>