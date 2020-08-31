<?php
function getItemByName1($doc,$name,$tag)
{
    foreach($doc->getElementsByTagName($tag) as $item)
    {
        if($item->getAttribute("name") == $name)
        {
            return $item;
        }
    }
}
if (!isset($_SESSION))
			session_start();
		
$_SESSION['testname'] = $_POST['testname'];

echo $_SESSION['abracadabra'];

$doc = new DOMDocument("1.0", "utf-8");
$doc->load("XML/tests.xml");

$del = getItemByName1($doc, $_SESSION['testname'], 'test');
$doc->documentElement->removeChild($del);
$doc->save('XML/tests.xml');
include('open.php');
?>
