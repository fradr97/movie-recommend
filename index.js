const BASE_URL = 'http://localhost/movie-recommend/';   // http://fradr.altervista.org/

function goHome() {
    window.location.href = BASE_URL + 'home/home.html';
}

function goSearchMovies() {
    window.location.href = BASE_URL + 'search-movies/search-movies.html';
}

function openMovieUrl(movieTitle) {
    window.open('https://www.google.com/search?q=' + movieTitle, '_blank');
}

function goFavoriteMovie() {
    window.location.href = BASE_URL + 'favorite-movies/favorite-movies.html';
}