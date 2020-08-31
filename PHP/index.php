<?php
function getItemByNames($doc,$name,$tag)
{
    foreach($doc->getElementsByTagName($tag) as $item)
    {
        if($item->getAttribute("name") == $name)
        {
            return $item;
        }
    }
}
if (!(isset($_SESSION)))
	session_start();
if (!isset($_SESSION['user']) && !isset($_POST['login']))
    include('authorize.html');
else if (!isset($_SESSION['user'])){
    $doc = new DOMDocument("1.0", "utf-8");
    $doc->load('XML/users.xml');
    $root = $doc->documentElement;
    $name = getItemByNames($doc, $_POST['login'], 'user');
    if ($name && $name->getAttribute('password') == $_POST['password'])
    {
        $_SESSION['user'] = $_POST['login'];	  
        include("actionchoose.html");
    }
    else
        include('authorize.html');
}
else
    include("actionchoose.html");
?>