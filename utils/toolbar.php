<?php
require_once 'functions.php';
define('HOSTNAME', $_SERVER['EBS_HOSTNAME']);

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">FestivalCloud</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href=<?= HOSTNAME ?>>Home</a>
                <a class="nav-link" href=<?= HOSTNAME . 'views/festivals' ?>>Festivals</a>
                <a class="nav-link" href=<?= HOSTNAME . 'views/stages' ?>>Stages</a>
                <a class="nav-link" href=<?= HOSTNAME . 'views/shows' ?>>Shows</a>
                <a class="nav-link" href=<?= HOSTNAME . 'views/performers' ?>>Performers</a>
            </div>
        </div>
    </div>
</nav>
<br>
<br>



