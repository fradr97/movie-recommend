<?php

include_once './../config/database.php';

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return substr($haystack, -$length) === $needle;
}

function getMoviesResults()
{
    $database = new Database();
    $db = $database->getConnection();

    $type = $_GET['type'];
    $year = $_GET['year'];
    $country = $_GET['country'];
    $actors = $_GET['actors'];

    $moviesQuery = "SELECT title, type, year, country, actors, duration " .
        "FROM  movies " .
        "WHERE waiting = 1 AND type LIKE CONCAT('%',?,'%') AND " .
        "year LIKE CONCAT('%',?,'%') AND country LIKE CONCAT('%',?,'%') ";

    $queryTypes = "";
    $parameters = [];

    $queryTypes = $queryTypes . "sss";
    array_push($parameters, $type);
    array_push($parameters, $year);
    array_push($parameters, $country);

    if ($actors != '') {
        $moviesQuery = $moviesQuery . "AND actors LIKE CONCAT('%',?,'%')";
        $queryTypes = $queryTypes . "s";
        array_push($parameters, $actors);
    }

    $moviesQuery = $moviesQuery . " ORDER BY id LIMIT 8";

    $stmt = $db->prepare($moviesQuery);
    $stmt->bind_param($queryTypes, ...$parameters);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result;
    }
    return null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css" />
    <link rel="stylesheet" type="text/css" href="movies-results.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script type="text/javascript" src="../index.js"></script>

    <title>
        Results
    </title>
</head>

<body>
    <b>
        <h1>Film consigliati</h1>
        <div id="button-div">
            <button onClick="goHome()"><i class="material-icons">home</i></button>
        </div>
    </b>

    <div>
        <ol>
            <?php
            $movies = getMoviesResults();

            if ($movies == null) {
                echo '<p>Mi dispiace, non è presente alcun film con i parametri specificati!</p>';
            } else {
                while ($row = $movies->fetch_assoc()) {
                    echo '<li onclick="openMovieUrl(\'' . $row['title'] . '\')">' .
                        '<span>' . $row['title'] . '</span>' .
                        '<span>' . $row['type'] . ' - ' . $row['year'] . ' - ' .
                        $row['duration'] . ' min circa</span>' .
                        '</li>';
                }
            }
            ?>
        </ol>
    </div>
</body>

</html>