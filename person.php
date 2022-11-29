<?php
$id = filter_input(INPUT_GET,
    'employeeId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range"=> 1]]
);

if ($id === null || $id === false) {
    http_response_code(400);
    $status = "bad_request";
} else {

    require_once "inc/db.inc.php";

    $stmt = $pdo->prepare("SELECT * FROM employee WHERE employee_id=:employeeID");
    $stmt->execute(['employeeID' => $id]);
    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        $status = "not_found";
    } else {
        $person = $stmt->fetch();
        $stmt = $pdo->prepare("SELECT room.name, room.room_id FROM room INNER JOIN employee ON room.room_id = employee.room WHERE employee.employee_id =:employeeId");
        $stmt->execute(['employeeId' => $id]);
        $room = $stmt->fetch();
        $status = "OK";
    }
}
?>

<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <title><?php
        if($status == "OK"){
            echo("{$person -> name} {$person -> surname}");
        }
        else{
            $httpCode = http_response_code();
            echo("Chybový kód: {$httpCode}");
        }
        ?></title>
</head>
<body>
<?php
switch ($status) {
    case "bad_request":
        echo "<h1>Error 400: Bad request</h1>";
        break;
    case "not_found":
        echo "<h1>Error 404: Not found</h1>";
        break;
    default:
        echo("<div class='container'>");
        echo("<h1>Zaměstnanec č. {$person -> employee_id}</h1>");
        echo('<a href="people.php"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Zpět na seznam zaměstnanců</a>');
        echo("<dl class='dl-horizontal'>");

        $capitalizedJob = mb_convert_case($person -> job, MB_CASE_TITLE, 'UTF-8');
        $formattedWage = number_format($person -> wage,2);
        echo("<dt>Číslo</dt><dd>{$person -> employee_id}</dd><dt>Jméno</dt><dd>{$person -> name} {$person -> surname}</dd><dt>Pozice</dt><dd>{$capitalizedJob}</dd><dt>Plat</dt><dd>{$formattedWage}</dd><dt>Místnost</dt><dd><a href='room.php?roomId={$room->room_id}'>{$room->name}</a></dd>");
        $stmt = $pdo ->prepare("SELECT room.name, room.room_id FROM `key` klic JOIN room ON klic.room = room.room_id WHERE klic.employee =:employeeId ORDER BY room.name");
        $stmt->execute(['employeeId' => $id]);
        if($stmt ->fetch() === 0){
            echo("<dt>Klíče</dt><dd>—</dd>");
        }
        else{
            echo("<dt>Klíče</dt>");
            while($room = $stmt->fetch()){
                echo("<dd><a href='room.php?roomId={$room->room_id}'>{$room->name}</a></dd>");
            }
        }
        echo("</dl>");
        echo("</div>");

        break;
}
?>
