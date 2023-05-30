function validateFavoriteMoviesForm() {
    let nickname = document.forms["favoriteMoviesForm"]["nickname"].value;
    let title = document.forms["favoriteMoviesForm"]["title"].value;
    let type = document.forms["favoriteMoviesForm"]["type"].value;
    let year = document.forms["favoriteMoviesForm"]["year"].value;
    let country = document.forms["favoriteMoviesForm"]["country"].value;
    let duration = document.forms["favoriteMoviesForm"]["duration"].value;
    let seasons = document.forms["favoriteMoviesForm"]["seasons"].value;
    let episodes = document.forms["favoriteMoviesForm"]["episodes"].value;
    let actors = document.forms["favoriteMoviesForm"]["actors"].value;

    if (nickname == '' || nickname.length < 1 || nickname.length > 20 ||
        title == '' || title.length < 1 || title.length > 60 ||
        type == '' || year == '' || country == '' ||
        duration == '' || duration < 1 || duration > 1000 ||
        actors == '' || actors.length < 1 || actors.length > 200) {
        alert('Campi vuoti, lunghezza del nome maggiore di 20 caratteri,' +
            ' lunghezza del titolo maggiore di 60 caratteri o ' +
            ' lunghezza attori maggiore di 200 caratteri');
        return false;
    }

    if (type == "Serie" && (seasons == '' || seasons < 1 || seasons > 100 ||
        episodes == '' || episodes < 1 || episodes > 1000)) {
        alert('Indicare il numero di stagioni della serie o il numero di episodi!');
        return false;
    }
    return true;
}

function showHideSeasons() {
    var type = document.getElementById("type");
    var seasons = document.getElementById("seasons");
    seasons.style.display = type.value == "Serie" ? "block" : "none";
}
