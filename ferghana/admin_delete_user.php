<?php

require_once("inc/_init.php");

//On contr�le que l'utilisateur a bien les privil�ges n�cessaires
if(
    !isset($_SESSION['ferghana_user']) 
    || is_null($_SESSION['ferghana_user']['id_droit'])
    || $_SESSION['ferghana_user']['id_droit'] != 1):

    header('location:admin.php');

endif;

//On r�cup�re le param�tre
$id = (isset($_GET['id']) ? $_GET['id'] : NULL);

if(is_null($id)):
    header('location:admin.php');
endif;

//L'utilisateur ne peut pas modifier son propre compte
if($id == $_SESSION['ferghana_user']['id_user']):
    header('location:admin.php');
endif;

$errors = array();
$success = array();

$query = "UPDATE users SET is_suppr = 1 WHERE id_user = '".$id."'";
mysql_query($query);

header('location:admin.php');

?>