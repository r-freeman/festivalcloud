<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">FestivalCloud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php
        require_once 'functions.php';
        
        echo '<a class="nav-link" href="/festivalCloud/">Home</a>';
        echo '<a class="nav-link" href="/festivalCloud/views/festivals/index.php">Festivals</a>';
        echo '<a class="nav-link" href="/festivalCloud/views/stages/index.php">Stages</a>';
        echo '<a class="nav-link" href="/festivalCloud/views/shows/index.php">Shows</a>';
        echo '<a class="nav-link" href="/festivalCloud/views/performers/index.php">Performers</a>';
        ?>
      </div>
    </div>
  </div>
</nav>
<br>
<br>



