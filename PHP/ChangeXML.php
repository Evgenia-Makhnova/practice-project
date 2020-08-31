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

function addAnswers($doc, $parent)
{
    $element = $doc->createElement('question',($_POST['qname']));
    $type = $_POST['type'];
	$qType = $doc->createAttribute('type');
    
    if ($type=="isRadio")
    {
		$qType->value = 'radio';
        $i=1;
        while(isset($_POST["radioanswer$i"]))
        {
        $correctAtr = $doc->createAttribute('correct');
        
            
        $ans = $doc->createElement('answer',($_POST["radioanswer$i"]));
        if ($i==$_POST['corradioanswer'])
            $correctAtr->value = 'y';
        else
            $correctAtr->value = 'n'; 
        $ans->appendChild($correctAtr);
        $element->appendChild($ans);
        $i++;
        }
    }
    else if ($type=="isCheck")
    {
		$qType->value = 'check';
        $i=1;
        while(isset($_POST["checkanswer$i"]))
        {
        $correctAtr = $doc->createAttribute('correct');
        
            
        $ans = $doc->createElement('answer',($_POST["checkanswer$i"]));
		
        if (IsChecked("corcheckanswer",$i))
            $correctAtr->value = 'y';
        else
            $correctAtr->value = 'n'; 
        $ans->appendChild($correctAtr);
        $element->appendChild($ans);
        $i++;
        }
    }
    else
    {
		$qType->value = 'text';
        $correctAtr = $doc->createAttribute('correct');
        $ans = $doc->createElement('answer',($_POST["textanswer"]));
        $correctAtr->value = 'y';
        $ans->appendChild($correctAtr);
        $element->appendChild($ans);  
    }
    $element->appendChild($qType);
    $parent->appendChild($element);    
}


$doc = new DOMDocument("1.0", "utf-8");

$doc->load('XML/tests.xml');

if (!isset($_SESSION['testname']))
			session_start();
$root = getItemByName($doc, $_SESSION['testname'],'test');

addAnswers($doc, $root);
$doc->formatOutput = true;
$doc->save('XML/tests.xml');

include "testmaking.html";


