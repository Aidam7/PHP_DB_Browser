<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Seznam zaměstnanců</title>
</head>
<body class="container">
<?php

require_once "inc/db.inc.php";

$stmt = $pdo->query('SELECT e.*, r.name AS roomName, r.phone AS roomPhone FROM employee e LEFT JOIN room r ON e.room = r.room_id ORDER BY e.surname');


if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
} else {
    echo("<h1>Zaměstnanci</h1>");
    echo('<a href="index.php"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Zpět na hlavní stránku</a>');
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>Jméno</th><th>Pozice</th><th>Místnost</th><th>Telefon</th>";
    echo "</tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        $capitalizedJob = mb_convert_case($row -> job, MB_CASE_TITLE, 'UTF-8');
        echo "<td><a href='person.php?employeeId={$row->employee_id}'>{$row->surname} {$row -> name}</a></td><td>$capitalizedJob</td><td>{$row->roomName}</td><td>{$row->roomPhone}</td>";
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