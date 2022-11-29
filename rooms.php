<?php
$order = filter_input(INPUT_GET,
    'poradi',FILTER_DEFAULT,
    ["options" => "nazev_up","nazev_down","cislo_up","cislo_down","telefon_up","telefon_down"]
);
require_once "inc/db.inc.php";


$stmtString = 'SELECT * FROM room';
switch ($order){

    CASE "nazev_up": $stmtString .= " ORDER BY room.name"; break;
    CASE "nazev_down": $stmtString .= " ORDER BY room.name DESC"; break;
    CASE "cislo_up": $stmtString .= " ORDER BY room.no"; break;
    CASE "cislo_down": $stmtString .=" ORDER BY room.no DESC"; break;
    CASE "telefon_up": $stmtString .= " ORDER BY room.phone"; break;
    CASE "telefon_down": $stmtString .= " ORDER BY room.phone DESC"; break;
}
$stmt = $pdo->query($stmtString);
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Seznam místností</title>
</head>
<body class="container">
<?php

require_once "inc/db.inc.php";

$stmt = $pdo->query($stmtString);

if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
} else {
    echo("<h1>Místnosti</h1>");
    echo('<a href="index.php"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Na hlavní stránku</button></a><br><br>');
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo '
<th>Název<a href="?poradi=nazev_up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><a href="?poradi=nazev_down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></th>
<th>Číslo<a href="?poradi=cislo_up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><a href="?poradi=cislo_down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></th>
<th>Pevná linka<a href="?poradi=telefon_up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><a href="?poradi=telefon_down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></th>';
    echo "</tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td><a href='room.php?roomId={$row->room_id}'>{$row->name}</a></td><td>{$row->no}</td><td>{$row->phone}</td>";
        echo "</tr>";
    //foreach ($stmt as $row) {
//        var_dump($row);
//        var_dump($row->name);
//        var_dump($row['name']);
    }
    echo "</table>";
    if($order === null){
        echo('<a href="rooms.php"><button type="button" class="btn btn-primary btn-sm">Zrušit řazení</button></a><br>');
    }
    else{
        echo('<a href="rooms.php"><button type="button" class="btn btn-danger btn-sm">Zrušit řazení</button></a><br>');
    }
}
unset($stmt);
?>
</body>
</html>