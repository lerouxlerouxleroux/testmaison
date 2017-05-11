<?php

    //D�tection de langue � utiliser.
    function languageGet(){
        
    if(isset($_REQUEST['language'])):
        $_SESSION['ferghana_pref_language'] = $_REQUEST['language'];
        return($_SESSION['ferghana_pref_language']);
    endif;
    
    if(!isset($_SESSION['ferghana_pref_language'])):
    
        //Si l'utilisateur est enregistr�, on r�cup�re sa langue habituelle.
        if(userIsLogged()):
            if(isset($_SESSION['ferghana_pref_language'])):
            $lang = $_SESSION['ferghana_pref_language'];
            languageRegister($lang);
            return($lang);
            endif;
        endif;

        //Pas d'information en BDD ou utilisateur non logg� : On r�cup�re la langue du navigateur
        if(!isset($_SESSION['ferghana_pref_language'])):
            $_SESSION['ferghana_pref_language'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
        endif;
       
    endif;
        
    return($_SESSION['ferghana_pref_language']);
    
    }

    //On vérifie si un user est loggé ou non.
    function userIsLogged(){
        return false;
    }
    
    function login($email = NULL,$password = NULL, $returnPage = NULL){
        
        //On contr�le que l'on a bien des param�tres en entr�e.
        if($email == NULL || $password == NULL):
            return false;
        endif;
        
        $password = md5($password);
        
        $query = "SELECT * FROM `users` AS u 
            LEFT JOIN `user_droit` AS ud 
            USING(id_user) 
            WHERE email = '".$email."'
            AND password = '".$password."'
            LIMIT 1";
        
        $result = mysql_query($query);
        
        if(!$result || mysql_num_rows($result) == 0):
            return false;
        endif;
        
        while($row = mysql_fetch_assoc($result)):
            $_SESSION['ferghana_user'] = $row;
            return true;
        endwhile;
        
    }

    
?>
