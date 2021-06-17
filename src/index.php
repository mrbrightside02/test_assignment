<?php

require_once './include/constants.php';
require_once './include/helpers.php';
// set order
$order = (isset($_POST['desc']) && filter_var($_POST['desc'], FILTER_VALIDATE_BOOLEAN)) ? 'DESC' : 'ASC';
$sql =
    "SELECT 
        main.Continent,
        main.Region, 
        (SELECT COUNT(country.Code) FROM country WHERE country.Region = main.Region) AS Countries,
        (SELECT ROUND(AVG(country.LifeExpectancy),2) FROM country WHERE country.Region = main.Region ) AS lifeDuration,
        (SELECT SUM(city.Population) FROM city WHERE city.CountryCode IN (SELECT concat(country.Code) FROM country WHERE country.Region = main.Region )) AS Population,
        (SELECT COUNT(city.ID) FROM city WHERE city.CountryCode IN  (SELECT concat(country.Code) from country where country.Region = main.Region )) AS Cities,
        (SELECT COUNT(countrylanguage.language) FROM countrylanguage WHERE countrylanguage.CountryCode IN (SELECT concat(country.Code) from country WHERE country.Region = main.Region )) AS languages
    FROM country main
    GROUP BY main.Region, main.Continent 
    ORDER BY :sort ${order};";
// execute statement
$order = getFieldName($_POST['order']);
$prepared = $pdo->prepare($sql);
$prepared->bindParam(':sort', $order, PDO::PARAM_INT);
$prepared->execute();
$result = $prepared->fetchAll(PDO::FETCH_ASSOC);
// Api call
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type', 'text/json');
    die (json_encode($result));
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test Assignment 1</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<table class="report_table">
    <thead>
    <tr>
        <th data-order="continent">Continent</th>
        <th data-order="region">Region</th>
        <th data-order="countries">Countries</th>
        <th data-order="lifeduration">LifeDuration</th>
        <th data-order="population">Population</th>
        <th data-order="cities">Cities</th>
        <th data-order="languages">Languages</th>
    </tr>
    </thead>
    <tbody id="content">
    <? foreach ($result as $row) { ?>
        <tr>
            <td><?= $row['Continent'] ?? '0'; ?></td>
            <td><?= $row['Region'] ?? '0'; ?></td>
            <td><?= $row['Countries']?? '0'; ?></td>
            <td><?= $row['lifeDuration']?? '0'; ?></td>
            <td><?= $row['Population']?? '0'; ?></td>
            <td><?= $row['Cities']?? '0'; ?></td>
            <td><?= $row['languages']?? '0'; ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
<script src="./js/foreach.js"></script>
<script src="./js/helpers.js"></script>
<script src="./js/app.js"></script>
<script>

</script>

</body>
</html>
