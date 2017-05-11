<?php
echo "<div class = 'logout_pseudo'>";
/*if(languageGet() == 'fr'):
    echo "Vous &ecirc;tes connect&eacute; en tant que <br>";
else:
    echo "Connected as<br>";
endif;*/
echo $_SESSION['ferghana_user']['pseudo'];

echo "<br><br>";

if(languageGet() == 'fr'):
    $text =  "D&eacute;connexion";
else:
    $text = "Logout";
endif;

echo "<input type = 'button' value = '".$text."' onClick = \"window.location='deconnect.php'\">";
echo "</div>";
?>
