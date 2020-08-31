<html>
<head>
<title>Results</title>
<link href="style/external.css?<?=time()?>" rel="stylesheet">
</head>
<body>
<div class='exiting'>
<?php 
if (!isset($_SESSION))
	session_start();
echo "Здравствуй, ".$_SESSION['user'];
?>
<form action='exit.php'>
<input type='submit' value='Sign Out'>
</form> <hr><form action='results.php'> 
<input type='submit' value='Результат'> 
</form>
</div> 
<h1 class='review'>Результаты:</h1>
<div class='res'>
<p>Поиск: 
<input type='text' placeholder='User or test' id='search-text' onkeyup='tableSearch()'>
</p>
<table id='info-table' border='2px'>
<tr>
<th>Пользователь</th>
<th>Тест</th>
<th>Оценка</th>
</tr>

<?php
$res = new DOMDocument("1.0", "utf-8");
$res->load('XML/results.xml');
$root = $res->documentElement;
$r=$res->getElementsByTagName("res");
foreach ($r as $item)
{
    echo "<tr>";
    echo "<td>".$item->getAttribute('user')."</td>";
    echo "<td>".$item->getAttribute('test')."</td>";
    echo "<td>".$item->getAttribute('grade')."</td>";
    echo "</tr>";
}
echo "</table></div>";
echo '<form><button class="back" formaction="index.php">
                        Return
                    </button></form>';
					

?>
</table>
</div>
<form><button class="back" formaction="index.php">Назад</button></form>
</body>
<script>
function tableSearch() {
    var phrase = document.getElementById('search-text');
    var table = document.getElementById('info-table');
    var regPhrase = new RegExp(phrase.value, 'i');
    var flag = false;
    for (var i = 1; i < table.rows.length; i++) {
        flag = false;
        for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag) {
            table.rows[i].style.display = '';
        } else {
            table.rows[i].style.display = 'none';
        }

    }
}
</script>
</html>
