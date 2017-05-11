<?php

ini_set('display_errors', 1); 
error_reporting(E_ALL); 

if($_SERVER['SERVER_ADDR'] == '127.0.0.1'):

    //CONFIG MACHINE LOCALE
    if(!defined("URL_WWW")):
        define("URL_WWW",'http://localhost/ferghana/');
    endif;

    if(!defined("PATH_WWW")):
        define("PATH_WWW",'\var\www\ferghana\\');
    endif;

    if(!defined("BDD_HOST")):
        define("BDD_HOST",'localhost');
    endif;

    if(!defined("BDD_USER")):
        define("BDD_USER",'root');
    endif;

    if(!defined("BDD_PASSWORD")):
        define("BDD_PASSWORD",'Br1anB0ru');
    endif;

    if(!defined("BDD_SCHEMA")):
        define("BDD_SCHEMA",'ferghana');
    endif;

else:
    //CONFIG SERVEUR FINAL
    if(!defined("URL_WWW")):
        define("URL_WWW",'http://www.ferghana.fr/');
    endif;

    if(!defined("PATH_WWW")):
        define("PATH_WWW",'/htdocs/public/www/');
    endif;

    if(!defined("BDD_HOST")):
        define("BDD_HOST",'hostingmysql281.amen.fr');
    endif;

    if(!defined("BDD_USER")):
        define("BDD_USER",'DA2267_ferghana');
    endif;

    if(!defined("BDD_PASSWORD")):
        define("BDD_PASSWORD",'Br1anB0ru');
    endif;

    if(!defined("BDD_SCHEMA")):
        define("BDD_SCHEMA",'ferghana_fr_main');
    endif;
    
endif;

?>
