<!doctype html>
<?php 

$lang = languageGet();

?>
<html lang="<?php echo $lang; ?>">
<head>
  <meta charset="utf-8">
  <title>
    <?php
      switch($lang):
          default :
          case 'fr':
            echo "Ferghana.fr, version fran&ccedil;aise";
            break;
          case 'en':
            echo "Ferghana.fr, english version";
            break;
      endswitch;  
    ?>
  </title>
  
  <?php
  
  $description = "";
  
  switch($lang):
      default :
      case 'fr':
        $description = "Ferghana.fr est un site d&eacute;di&eacute; &agrave; l'histoire et au patrimoine de la vall&eacute;e de la Ferghana, en Asie centrale, entre le Kirghizstan et l'Ouzb&eacute;kistan.";
        break;
      case 'en':
        $description = "Ferghana.fr is a dedicated website to the history and heritage of the Ferghana Valley, Central Asia, between Kyrgyzstan and Uzbekistan.";
        break;
  endswitch;  
  
  ?>
  
  <meta name="description" content="<?php echo $description; ?>" />
  <link rel="stylesheet" href="styles/main.css">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="icon" type="image/png" href="favicon.png" />
  <link href="http://fonts.googleapis.com/css?family=Allan:bold" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
  <script 
      src="http://code.jquery.com/jquery-latest.min.js"
      type="text/javascript"></script>
  
  <script src="scripts/main.js"></script>
</head>


