<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?php echo($this->title); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dm-tw4b-2022/skin/style.css">
  </head>
  <body>
    <header>
      <h1>Sneaky</h1>
      <nav id="mainNav">
        <ul>
          <?php
          foreach ($this->menu as $text => $link) {
            echo "<li><a href=\"$link\">$text</a></li>";
          }
          ?>
        </ul>
      </nav>
    </header>
    <main>
      <?php
        echo("<p id='feedback'>$this->feedback</p>");
        echo("<h1>$this->h1</h1>");
        echo($this->content);
      ?>
    </main>
  </body>
</html>
