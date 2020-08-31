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
session_start();
$action = $_POST['action'];
if (isset($_POST['testname']))
    $testname = $_POST['testname'];

if($action == "Create")
{
    if(!$testname)
    {
        include "errnoname.html";
    }

    else
    {
        $doc = new DOMDocument("1.0", "utf-8");
        $doc->load("tests.xml");
        
        
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

        if (getItemByName($doc, $testname, "test"))
        {
            include "errusedname.html";
        }    
        
        else
        {
            $test = $doc->createElement("test");
            $test->setAttribute('name', $testname);
            $root->appendChild($test);
            $doc->formatOutput = true;
            $doc->save('tests.xml');

            $q=$testname;
            include "testmaking.html";
        }
    }
}
elseif($action == "Open")
{
    $doc = new DOMDocument("1.0", "utf-8");
    $doc->load("tests.xml");
    $tests = $doc->getElementsByTagName('test');
    echo '<link href="external.css" rel="stylesheet">';
	echo "<h1>Please choose your test</h1>";
    foreach ($tests as $item){
		
        echo "<form action='ReadXML.php' method='POST'>";
        $res=$item->getAttribute("name");
        echo "<input type='text' name='q' value ='$res' hidden><input type='submit' value ='$res' >";
        if ($_SESSION['user']=='Teacher')
            echo "<input type='submit' value = 'Delete' formaction = 'Delete.php'><br>";
        echo "</form>";
    }
    echo "<form><input type='submit' value = 'Return' formaction = 'index.php'></form><br>";
    
}
?>


