<?php

require_once("inc/_init.php");

//On contrôle que l'utilisateur a bien les privilèges nécessaires
if(
    !isset($_SESSION['ferghana_user']) 
    || is_null($_SESSION['ferghana_user']['id_droit'])
    || $_SESSION['ferghana_user']['id_droit'] != 1):

    header('location:admin.php');

endif;

//On récupère le paramètre
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

if(isset($_POST['id'])):
    //On met à jour le statut de l'utilisateur
    if($_POST['droit'] == 0):
        //On supprime l'entrée dans la table d'association utilisateur/droits
        $query = "DELETE FROM user_droit WHERE id_user = '".$id."'";
        $result = mysql_query($query);
        if($result):
            $success[] = 'La modification a bien &eacute;t&eacute; enregistr&eacute;e.';
        else:
            $errors[] = 'Une erreur est survenue;';
        endif;
    else:
        //On met à jour les droits de l'utilisateur  
        $query = "REPLACE INTO user_droit(id_droit,id_user) VALUES('".$_POST['droit']."','".$id."')";
        $result = mysql_query($query);
        if(!$result):
            $errors[] = 'Une erreur est survenue.';
        else:
        
            //Il ne peut y avoir qu'un seul fondateur. Si c'est le droit accordé, il faut le retirer à l'uttilisateur courant.
            if($_POST['droit'] == 1) :
                
                $query = "UPDATE user_droit SET id_droit = '2' WHERE id_user = '".$_SESSION['ferghana_user']['id_user']."'";
                $result = mysql_query($query);
                if($result):
                    $success[] = 'La modification a bien &eacute;t&eacute; enregistr&eacute;';
                    $_SESSION['ferghana_user']['id_droit'] = 2;
                else:
                    $errors[] = 'Une erreur est survenue.';
                endif;
        
            endif;
            
        endif;
        
    endif;
endif;

//On contrôle que l'utilisateur visé existe bien
$query = "
    SELECT * 
    FROM users u
    LEFT JOIN user_droit ud USING(id_user)
    LEFT JOIN droits USING(id_droit)
    WHERE id_user = '".$id."' LIMIT 1";

$result = mysql_query($query);

$user = NULL;

while($row = mysql_fetch_assoc($result)):
    $user = $row;
endwhile;

if(is_null($user)):
    header('location:admin.php');
endif;

require_once('meta.php');
require_once('header.php');

//On liste les droits possibles
$query = "SELECT * FROM droits ORDER BY id_droit DESC";
$result = mysql_query($query);

$droits = array();

while($row = mysql_fetch_assoc($result)):
    $droits[] = $row;
endwhile;

require_once("meta.php");
require_once("header.php");

?>

<article class = "admin_full">
    <section>
    <div>
    <a href = "admin.php">[Retour]</a>
    </div>
    <h1><?php 
    echo "Gestion du compte de ".utf8_encode($user['pseudo']);
    ?></h1>
    <div class = "error">
    <?php
	if(count($errors)>0):
	    foreach($errors as $error):
		echo "<p>";
			echo $error;
		echo "</p>";
	    endforeach;
	endif;
    ?>
    </div>
    <div class = "success">
	<?php
    
	if(count($success)>0):
	    foreach($success as $message):
		echo "<p>";
			echo $message;
		echo "</p>";
	    endforeach;
	endif;
	?>
    </div>

    <form 
	method = "POST" 
        action = "admin_edit_user.php?id=<?php echo $id; ?>"
    	enctype = "multipart/form-data"
    >
 
    <div>Nom r&eacute;el : <?php echo utf8_encode($user['fname']); ?> <?php echo utf8_encode($user['lname']); ?></div>
    <div>Email : <?php echo utf8_encode($user['email']); ?> <?php echo utf8_encode($user['email']); ?></div>
    <div>Date d'inscription: <?php echo $user['date_inscription']; ?></div>
    <input type = "hidden" name = "id" id = "id" value = "<?php echo $id; ?>">
    
    <label for = 'droit'></label>
    <select id = "droit" name = "droit" onChange = 'warn(this.value);'>
        <option value = '0' <?php if($user['id_droit'] == NULL) echo "selected = 'selected' "; ?>>Membre</option>
        <?php
        foreach($droits as $droit):
            ?>
            <option 
                value = '<?php echo $droit['id_droit'] ?>'
                <?php if($droit['id_droit'] == $user['id_droit']) echo " selected = 'selected' "; ?>
                >
                <?php 
                //echo $droit['id_droit'].' | '.$user['id_droit'];
                echo $droit['libelle'];
                ?>
            </option>
            <?php
        endforeach;
        ?>
    </select>
    
	<input type = "submit" value = "Valider">
    </form>
    </section>
</article>

<?php

require_once('footer.php');
?>

<script>
function warn(id){   
    
    if(id === '1'){
        alert("ATTENTION !!! Il ne peut y avoir plus d'un fondateur. En donnant les droits a cet utilisateur, vous perdrez vos privil\350ges et redeviendrez simple administrateur.");
    }
    
}
</script>
