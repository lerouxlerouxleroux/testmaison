<?php

require_once("inc/_init.php");

require_once("meta.php");
require_once("header.php");

$success = false;
$errors = array();

if(count($_POST) > 0):
    
    $data = $_POST;

    if(
        isset($data['lname'])
        && isset($data['fname'])
        && isset($data['login'])
        && isset($data['email'])
        && isset($data['password'])
        && isset($data['passwordConfirm'])
        ):

        //On protège les données pour éviter toute injection.
        $lname    = mysql_real_escape_string($data['lname']);
        $fname    = mysql_real_escape_string($data['fname']);
        $login    = mysql_real_escape_string($data['login']);
        $email    = mysql_real_escape_string($data['email']);
        $password = mysql_real_escape_string($data['password']);                   

        $insert = true;

        //On vérifie qu'il n'existe pas en base de données un utilisateur avec le 
        //même identifiant.
        $query = "SELECT * FROM users WHERE `pseudo` = '".$login."' LIMIT 1";
        $result = mysql_query($query);

        if(mysql_num_rows($result) > 0):
            $insert = false;
            if($_SESSION['ferghana_pref_language'] == 'fr'):
                $errors[] = htmlentities("Le nom d'utilisateur '".$login."' n'est pas disponible.");
            else:
                $errors[] = htmlentities($login."' is already in use.");
            endif;
        endif;

        //On vérifie qu'il n'existe pas en base de données un utilisateur avec le 
        //même email.
        $query = "SELECT * FROM users WHERE `email` = '".$email."' LIMIT 1";
        $result = mysql_query($query);

        if(mysql_num_rows($result) > 0):
            $insert = false;
            if($_SESSION['ferghana_pref_language'] == 'fr'):
                $errors[] = htmlentities("Il existe déjà un utilisateur associé à cette adresse de messagerie.");
            else:
                $errors[] = htmlentities("This specific email adress is already in use.");
            endif;
        endif;

        if($insert):
        
            //On encode le mot de passe en MD5
            $password = md5($password);

            //On insère l'utilisateur
            $query = "INSERT INTO `users` (`fname`,`lname`,`pseudo`,`email`,`password`,`date_inscription`)
                VALUES ('".$fname."','".$lname."','".$login."','".$email."','".$password."','".date('Y-m-d H:i:s')."')";
            if( !mysql_query($query)):
                $errors[] = htmlentities("Une erreur est survenue.");
            else:
                $success = true;
            endif;
    
        endif;
        
    endif;
    
endif;

?>

<article>
    <section>
        <h1>Inscription</h1>
        
        <?php
        if($success === false):
        ?>
        
        <div class = 'error'>
            <?php
            if(count($errors)>0):
                foreach($errors as $error):
                    echo "<p>".$error."</p>";
                endforeach;
            endif;
            
            ?>
        </div>
        <form 
            id = 'form_registration'
            name = 'form_registration'
            action = 'register.php'
            method = 'POST'
            >
            
            <input 
                type = 'text'
                name = 'lname'
                id   = 'lname'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Nom";
                            break;
                        case 'en':
                            echo "Last Name";
                            break;
                    endswitch;
                ?>'
                value = "<?php echo (isset($_POST['lname']) ? $_POST['lname'] : ''); ?>"
                >
            <input 
                type = 'text'
                name = 'fname'
                id   = 'fname'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Pr&eacute;nom";
                            break;
                        case 'en':
                            echo "First Name";
                            break;
                    endswitch;
                ?>'
                value = "<?php echo (isset($_POST['fname']) ? $_POST['fname'] : ''); ?>"
                >
            <input 
                type = 'text'
                name = 'login'
                id   = 'login'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Identifiant";
                            break;
                        case 'en':
                            echo "Login";
                            break;
                    endswitch;
                ?>'
                value = "<?php echo (isset($_POST['login']) ? $_POST['login'] : ''); ?>"
                >
            <input 
                type = 'email'
                name = 'email'
                id   = 'email'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Adresse de messagerie";
                            break;
                        case 'en':
                            echo "Email";
                            break;
                    endswitch;
                ?>'
                value = "<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>"
                >
            <input 
                type = 'password'
                name = 'password'
                id   = 'password'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Mot de passe";
                            break;
                        case 'en':
                            echo "Password";
                            break;
                    endswitch;
                ?>'
                value = "<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); ?>"
                >
            <input 
                type = 'password'
                name = 'passwordConfirm'
                id   = 'passwordConfirm'
                placeholder = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Confirmation du mot de passe";
                            break;
                        case 'en':
                            echo "Password Confirmation";
                            break;
                    endswitch;
                ?>'
                >
            <input 
                type = 'submit'
                name = 'button'
                id   = 'submit'
                value = '<?php 
                    switch($lang):
                        default:
                        case 'fr':
                            echo "Valider";
                            break;
                        case 'en':
                            echo "Submit";
                            break;
                    endswitch;
                ?>'
                
                >
        </form>
        
        <?php
        else:
            
            $returnPage = (isset($_SESSION['ferghana_return_page']) ? $_SESSION['ferghana_return_page'] : 'index.php');
        
            if(login($_POST['email'],$_POST['password'])):
                ?>
                <script type = "text/javascript">
                $(document).attr('href','<?php echo $returnPage; ?>')
                </script>
                <?php
            endif;
            
            ?>
        
            <div class = "success">
                Votre inscription a bien &eacute;t&eacute; enregistr&eacute;e.
            </div>
        

        
    </section>
    <section>
    <blockquote>
    <?php
    
    if($_SESSION['ferghana_pref_language'] == 'fr'): ?>
       Conform&eacute;ment &agrave; la loi &apos;informatique et libert&eacute;s &apos; du 6 janvier 1978 
        modifi&eacute;e en 2004, vous b&eacute;n&eacute;ficiez d&apos;un droit d&apos;acc&egrave;s et de rectification aux 
        informations qui vous concernent, que vous pouvez exercer en vous adressant 
        &agrave; [TODO].
    <?php else: ?>
        Accordance with the &apos; Informatique et Libert&eacute; &apos; law of 
        January 6, 1978 amended in 2004, you have a right to access and rectify 
        information about you that you can exercise by contacting [TODO].
    <?php endif; ?>
     </blockquote>
        
            <?php
        endif;
        ?>
        
    </section>
</article>
<aside>
 
</aside>

<?php
    require_once('footer.php');
?>

<script type = 'text/javascript'>

$('#form_registration').submit(function(event){
    var submit = checkRegistrationForm('<?php echo $_SESSION['ferghana_pref_language']; ?>');
    if(submit === false){
        event.preventDefault();
    }
});

function checkRegistrationForm(lang){
    
    var tab = ['#fname','#lname','#login','#email','#password','#passwordConfirm'];
    var validate = true;
    
    //On vérifie qu'aucun champ n'est vide.
    $.each(tab,function(key,value){
        if($.trim($(value).val().length) < 0){
            $(value).css('border-color','red');
            validate = false;
        }else{
            $(value).css('border-color','#CCCCCC'); 
        }
    });
    
    if(validate === true){
        
        //On vérifie que le mot de passe comporte plus de 6 caractères.
        if($.trim($('#password').val()).length < 6){
            if(lang === 'fr'){
                $('#error').html('Votre mot de passe doit comporter au moins 6 caract&egrave;res.');
            }else{
                $('#error').html('Your password must be at least 6 characters long.');
            }
            return false;
        }
        
        //On vérifie que le mot de passe et sa confirmation correspondent bien.
        
        if($('#password').val() !== $('#passwordConfirm').val()){
            $('password').css('border-color','red');
            $('passwordConfirm').css('border-color','red');
            if(lang == 'fr'){
                $('#error').html('Le mot de passe et sa confirmation ne correspondent pas.');
            }else{
                $('#error').html('Password and confirmation mismatch.');
            }
            return false;
        }else{
            $('password').css('border-color','#CCCCCC');
            $('passwordConfirm').css('border-color','#CCCCCC');
        }
   
    }else{
        if(lang == 'fr'){
            $('#error').html('Merci de remplir tous les champs.');
        }else{
            $('#error').html('All fields are mandatory.');
        }
        return false;
    }
    
    return true;
}

</script>
