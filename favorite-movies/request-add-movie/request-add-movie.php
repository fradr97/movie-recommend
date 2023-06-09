<?php

include_once './../../config/database.php';

function newMoviesRequest()
{
    $database = new Database();
    $db = $database->getConnection();

    $nickname = $_GET['nickname'];
    $title = $_GET['title'];
    $type = $_GET['type'];
    $year = $_GET['year'];
    $country = $_GET['country'];
    $duration = $_GET['duration'];
    $seasons = $_GET['seasons'];
    $episodes = $_GET['episodes'];
    $actors = $_GET['actors'];

    $paragrap = 'Errore nella richiesta! Ricontrolla i campi inseriti e ripeti l\'operazione.';

    if (
        strlen($nickname) < 1 || strlen($nickname) > 20 ||
        strlen($title) < 1 || strlen($title) > 60 ||
        strlen($type) == '' || strlen($year) == '' || strlen($country) == '' ||
        strlen($duration) == '' || strlen($duration) < 1 || strlen($duration) > 1000 ||
        strlen($actors) < 1 || strlen($actors) > 200 ||
        ($type == "Serie" && ($seasons == '' || $seasons < 1 || $seasons > 100 ||
            $episodes == '' || $episodes < 1 || $episodes > 1000))
    ) {
        return $paragrap;
    }

    $waiting = 0; // the movie is waiting to be approved

    if ($seasons != '' || $episodes != '') {
        $moviesQuery = "INSERT INTO movies " .
            "(title, type, year, country, actors, duration, seasons, episodes, waiting)" .
            " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($moviesQuery);
        $stmt->bind_param(
            "sssssiiii",
            $title,
            $type,
            $year,
            $country,
            $actors,
            $duration,
            $seasons,
            $episodes,
            $waiting
        );
    } else {
        $moviesQuery = "INSERT INTO movies " .
            "(title, type, year, country, actors, duration, waiting)" .
            " VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($moviesQuery);
        $stmt->bind_param(
            "sssssii",
            $title,
            $type,
            $year,
            $country,
            $actors,
            $duration,
            $waiting
        );
    }
    $stmt->execute();

    $lastId = $db->insert_id;

    $moviesQuery = "INSERT INTO advisers " .
        "(nickname, movie)" .
        " VALUES (?, ?)";

    $stmt = $db->prepare($moviesQuery);
    $stmt->bind_param(
        "si",
        $nickname,
        $lastId,
    );
    $stmt->execute();
    $db->close();

    if ($stmt) {
        $paragrap = 'Richiesta avvenuta con successo. Saranno revisionate le caratteristiche del film da te
        consigliato ed in seguito sarà eventualmente aggiunto al nostro database.
        Grazie, suggerisci ancora altri film!';
    }
    return $paragrap;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../index.css" />
    <link rel="stylesheet" type="text/css" href="request-add-movie.css" />
    <script type="text/javascript" src="../../index.js"></script>

    <title>
        Request add movie
    </title>
</head>

<body>
    <b>
        <h1>Richiesta aggiunta film</h1>
    </b>
    <div id="paragraph">
        <p>
            <?php echo newMoviesRequest(); ?>
        </p>
    </div>
    <div id="button-div">
        <button onClick="goHome()">Torna alla Home</button>
    </div>

</body>
