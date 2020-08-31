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

if (!isset($_SESSION['testname']))
	session_start();
		
$doc = new DOMDocument("1.0", "utf-8");
$doc->load("XML/tests.xml");
$root = $doc->documentElement;
$del = getItemByName($doc, $_SESSION['testname'],'test');
$root->removeChild($del);

$test = $doc->createElement('test');
$test->setAttribute('name', $_SESSION['testname']);

$i=1;
while(isset($_POST['qnum_'.$i])) {
	$questionName = $_POST['qnum_'.$i];
	$qType = $_POST['qtype_'.$i];
	$question = $doc->createElement('question',$questionName);
	$question->setAttribute('type', $qType);
	$j = 1;
	while(isset($_POST[$i.''.$j.'answer']))
	{
		$answer = $doc->createElement('answer',$_POST[$i.''.$j.'answer']);
		if(($qType!='check' && $j==$_POST['answer'.$i])||($qType=='check' && in_array($j, $_POST['answer'.$i])))
			$answer->setAttribute('correct','y');
		else
			$answer->setAttribute('correct','n');
		$question->appendChild($answer);
		$j++;
	}
	$i++;
	$test->appendChild($question);
}
$root->appendChild($test);
$doc->save('XML/tests.xml');
include('actionchoose.html');
?>