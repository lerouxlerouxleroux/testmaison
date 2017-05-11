<div id = "login">
    <form action = "auth.php" method = "POST">
        <input 
            type = "email" 
            id = "email" 
            name = "email"
            placeholder = "<?php
            switch($lang):
                default:
                case 'fr':
                    echo "Email";
                    break;
                case 'en':
                    echo "Email";
                    break;
            endswitch;
            ?>
            ">
        <br>
        <input 
            type = "password" 
            id = "password" 
            name = "password"
            placeholder = "<?php
            switch($lang):
                default:
                case 'fr':
                    echo "Mot de passe";
                    break;
                case 'en':
                    echo "Password";
                    break;
            endswitch;
            ?>"
            >
        <br>
        <input type = "submit" value = "<?php
            switch($lang):
                default:
                case 'fr':
                    echo "M'identifier";
                    break;
                case 'en':
                    echo "Login";
                    break;
            endswitch;
            ?>">

        
    </form>
    
    <form id = "form_create_account" action = 'register.php'>
        <input type = "submit" value = "<?php
            switch($lang):
                default:
                case 'fr':
                    echo "Cr&eacute;er un compte";
                    break;
                case 'en':
                    echo "Register";
                    break;
            endswitch;
            ?>">
    </form>
    
    <!--<form id = "form_forgot_password" action = 'password.php'>
        <input type = "submit" value = "<?php
            switch($lang):
                default:
                case 'fr':
                    echo "J'ai oubli&eacute; mon mot de passe.";
                    break;
                case 'en':
                    echo "Forgot password";
                    break;
            endswitch;
            ?>">
    </form>-->
    
</div>

<script type = "text/javascript">
    $('#form_create_account').submit(function(event){
        logCurrentPage();
    });
    $('#form_create_account').submit(function(event){
        logCurrentPage();
    });
    
    function logCurrentPage(){
        <?php

        //Récupération de l'URL courante et ajout du param de langue
        $url = $_SERVER['PHP_SELF'];
        if($_SERVER['QUERY_STRING'] != ""):
            $url .= "?";
            $url .= $_SERVER['QUERY_STRING'];
            $url .= "&language=";
        endif;
        
        $_SESSION['ferghana_return_page'] = $url;
        
        ?>
    }
    
</script>
