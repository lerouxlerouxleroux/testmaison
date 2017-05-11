<?php

require_once("inc/_init.php");

require_once("meta.php");
require_once("header.php");

$errors = array();
$success = array();

if(isset($_POST['object']) && isset($_POST['message'])):

	$object = trim($_POST['object']);
	$object = mysql_real_escape_string($object);
	
	$message = trim($_POST['message']);
	$message = mysql_real_escape_string($object);
	$message = nl2br($message);


	//if(mail('brclrx@gmail.com', $object, $message)):
	    switch($_SESSION['ferghana_pref_language']):
		default:
		case 'fr':
		    $success[] = 'Votre message a bien &eacute;t&eacute; envoy&eacute;';
		break;
		case 'en':
		    $success[] = 'Your message has been sent.';
		break;
	    endswitch;
	/*else:
	    switch($_SESSION['ferghana_pref_language']):
		default:
		case 'fr':
		    $error[] = 'Une erreur est survenue.';
		break;
		case 'en':
		    $error[] = 'An error has occurred.';
		break;
	    endswitch;
	endif;*/

endif;

?>

<article>
    <section>
    <h1>Contact</h1>

    <div class = "error">
        <?php
	   foreach($errors as $error):
		?>
		<div><?php echo $error; ?></div>
		<?php
	   endforeach;
        ?>
    </div>
    <div class = "success">
        <?php
	   foreach($success as $message):
		?>
		<div><?php echo $message; ?></div>
		<?php
	   endforeach;
        ?>
    </div>

    <form 
	name = "contact"
	action = "contact.php" 
	method = "POST">

	<?php
        if($_SESSION['ferghana_pref_language'] == 'fr'):
	    $tab = array('Demande de renseignement','Acc&egrave;s &agrave; l&apos;administration');
        else:
	    $tab = array('Miscelleanous','Administrator access');
        endif;
        ?>

	<select id = "object" name = "object">
            <?php
		foreach($tab as $object):
		?>
		    <option><?php echo $object; ?></option>
		<?php
		endforeach;
	    ?>
	</select>

	<textarea id = "message" name = "message" placeholder = "Message"></textarea>

	<input type = "Submit" value = "OK">

    </form>



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
