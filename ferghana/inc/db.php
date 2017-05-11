<?php

$link = mysql_connect(BDD_HOST, BDD_USER, BDD_PASSWORD)
    or die("Impossible de se connecter : " . mysql_error());

mysql_select_db (BDD_SCHEMA) or die ('ERREUR '.mysql_error());

?>
