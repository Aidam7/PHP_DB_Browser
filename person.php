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
        $stmt = $pdo->prepare("SELECT room.name FROM room INNER JOIN employee ON room.room_id = employee.room WHERE employee.employee_id =:employeeID");
        $stmt->execute(['employeeID' => $id]);
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
        echo("<dt>Číslo</dt><dd>{$person -> employee_id}</dd><dt>Jméno</dt><dd>{$person -> name} {$person -> surname}</dd><dt>Plat</dt><dd>{$person -> wage}</dd><dt>Místnost</dt><dd>{$room -> name}</dd>");
        echo("</dl>");
        echo("</div>");

        break;
}
?>
