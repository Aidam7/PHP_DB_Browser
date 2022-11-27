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

$stmt = $pdo->query('SELECT * FROM room');

if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
} else {
    echo("<h1>Místnosti</h1>");
    echo('<a href="index.php"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Zpět na hlavní stránku</a>');
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>Název</th><th>Číslo</th><th>Pevná linka</th>";
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
}
unset($stmt);
?>
</body>
</html>