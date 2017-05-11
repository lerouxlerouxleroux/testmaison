<?php

require_once("inc/_init.php");

if(!isset($_POST['email']) || !isset($_POST['password'])):
    header('location:index.php');
endif;

$email = mysql_real_escape_string($_POST['email']);
$password = mysql_real_escape_string($_POST['password']);

$login = login($email,$password);

if($login):
    header("location:".$_SERVER['HTTP_REFERER']);
endif;

require_once("meta.php");
require_once("header.php");

?>

<article>
    <section>
    <h1>Identification</h1>
    <?php
    if(!$login):
    ?>

    <div class = "error">
    <?php
    $link = "password.php";
    if($_SESSION['ferghana_pref_language'] == 'fr'):
	echo("Nous n'avons pu vous identifier.<br>");
	echo("Peut-&ecirc;tre avez-vous <a href = 'password.php'>oubli&eacute; votre mot de passe</a> ?");
    else:
	echo("Authentification failed.<br>");
	echo("Did you <a href = 'password.php'>forget your password</a> ?");
    endif;
    ?>
    </div>
    <?php
    else:
    if($_SESSION['ferghana_pref_language'] == 'fr'):
	echo("Vous avez bien &eacute;t&eacute; identifi&eacute;(e).");
    else:
	echo("Authentification OK");
    endif;
    ?>
    </div>
    <?php
    endif;
    ?>
    </section>
</article>
<aside>
    <?php
    if(!isset($_SESSION['ferghana_user'])):
        include_once('login.php');
    else:
        include_once('logout.php');
    endif;
    ?>
</aside>

<?php
    require_once('footer.php');
?>
