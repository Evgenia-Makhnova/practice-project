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
if(!isset($_SESSION['testname']))
	session_start();
if (isset($_POST['testname']))
    $_SESSION['testname'] = $_POST['testname'];

	if(!$_SESSION['testname'])
	{
	include "errnoname.html";
	}

	else
	{
	$doc = new DOMDocument("1.0", "utf-8");
	$doc->load("XML/tests.xml");


	if(!($doc->hasChildNodes()))
	{
		echo "no file"; 
		$root = $doc->createElement('tests');
		$root = $doc->appendChild($root);
	}
	else
	{
		$root = $doc->documentElement;
	}

	if (getItemByName($doc, $_SESSION['testname'], "test"))
	{
		include "errusedname.html";
	}    

	else
	{
		$test = $doc->createElement("test");
		$test->setAttribute('name', $_SESSION['testname']);
		$root->appendChild($test);
		$doc->formatOutput = true;
		$doc->save('XML/tests.xml');

		include "testmaking.html";
	}
}
?>