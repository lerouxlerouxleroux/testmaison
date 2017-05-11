<?php

    //Détection de langue à utiliser.
    function languageGet(){
        
    if(isset($_REQUEST['language'])):
        $_SESSION['ferghana_pref_language'] = $_REQUEST['language'];
        return($_SESSION['ferghana_pref_language']);
    endif;
    
    if(!isset($_SESSION['ferghana_pref_language'])):
    
        //Si l'utilisateur est enregistré, on récupère sa langue habituelle.
        if(userIsLogged()):
            if(isset($_SESSION['ferghana_pref_language'])):
            $lang = $_SESSION['ferghana_pref_language'];
            languageRegister($lang);
            return($lang);
            endif;
        endif;

        //Pas d'information en BDD ou utilisateur non loggé : On récupère la langue du navigateur
        if(!isset($_SESSION['ferghana_pref_language'])):
            $_SESSION['ferghana_pref_language'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
        endif;
       
    endif;
        
    return($_SESSION['ferghana_pref_language']);
    
    }

    //On vÃ©rifie si un user est loggÃ© ou non.
    function userIsLogged(){
        return false;
    }
    
    function login($email = NULL,$password = NULL, $returnPage = NULL){
        
        //On contrôle que l'on a bien des paramètres en entrée.
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
