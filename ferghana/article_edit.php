<?php

require_once("inc/_init.php");

if(
    !isset($_SESSION['ferghana_user']) 
    || is_null($_SESSION['ferghana_user']['id_droit'])
    || $_SESSION['ferghana_user']['id_droit'] > 2):

    header('location:admin.php');

endif;

$errors = array();
$success = array();

$language = (isset($_REQUEST['language']) && ($_REQUEST['language'] == 'fr' || $_REQUEST['language'] == 'en') ? mysql_real_escape_string($_REQUEST['language']) : 'fr');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if(isset($_POST['libelle']) && isset($_POST['texte'])):

	//On rÃ©cupÃ¨re l'id de la langue concernÃ©e.
	$query = "SELECT * FROM langues WHERE code = '".$language."' LIMIT 1"; 
	$result = mysql_query($query);
	
    while($row = mysql_fetch_assoc($result)):
	    $idLangue = $row['id_langue']; 
	endwhile;
    
    //On gère un éventuel upload
    if(isset($_FILES['illustration'])):
        if($_FILES['illustration']['size'] == 0):
            $errors[] = "Le fichier que vous avez t&eacute;l&eacute;charg&eacute; est corrompu.";
        else:
            $tab = array('image/gif','image/png','image/jpg','image.jpeg');
            if(!in_array($_FILES['illustration']['type'],$tab)):
                $errors[] = "Format de fichier invalide";
            
            else:
                    
                $stat = stat($_FILES['illustration']['tmp_name']);
                if($stat['size']>150000):
                    $errors[] = "Vous tentez de t&eacute;l&eacute;charger un fichier trop volumineux.";
                
                else:
                    
                    
                    $ext = pathinfo($_FILES['illustration']['name'], PATHINFO_EXTENSION);
                    $dir =  PATH_WWW.'upload/';
                    $name = time().'.'.$ext;
                    
                    if(!move_uploaded_file($_FILES['illustration']['tmp_name'],$dir.$name)):
                        $errors[] = "Une erreur est survenue lors du chargement de l'image.";
                    else:
                        $illustration = $name;
                    endif;

                
                endif;
                
            endif;
        endif;
    endif;
    
	$online  = (isset($_POST['online'])?mysql_real_escape_string($_POST['online']) : 0);
	$libelle = (isset($_POST['libelle'])?mysql_real_escape_string($_POST['libelle']) : '');
	$texte   = (isset($_POST['texte'])?mysql_real_escape_string($_POST['texte']):'');

	if($id == ''):


	    //CrÃ©ation
            $query = "INSERT INTO `articles` 
		(id_author,date_creation,is_online) 
		VALUES('".$_SESSION['ferghana_user']['id_user']."','".date('Y-m-d H:i:s')."','".$online."')";

	    $result = mysql_query($query);

	    if($result):
		$id = mysql_insert_id();

		//On rÃ©alise l'insertion
		$query = "INSERT INTO `article_langue` (id_article,id_langue,libelle,texte) VALUES ('".$id."','".$idLangue."','".$libelle."','".$texte."')";
		$result = mysql_query($query);

		if($result):
			$success[] = "L'article a bien &eacute;t&eacute; cr&eacute;e.";
		else:
			$errors[] = "Une erreur est survenue. (#1)";
		endif;

	    else:

		$errors[] = "Une erreur est survenue lors e la cr&eacute;tion de l'article. (#2)";

	    endif;

	else:
        //Edition
        //MAJ de l'article
        $query = "UPDATE articles SET is_online = '".$online."' ";
        if(isset($illustration)):
            $query .= ", illustration = '".$illustration."' ";
        endif;
        $query .=" WHERE id_article = '".$id."'";
        if(!mysql_query($query)):
            $errors[] = "Une erreur est survenue.";
        else:

            //MAJ de l'article dans la langue concernée;
            $query = "UPDATE article_langue SET libelle = '".$libelle."', texte = '".$texte."' WHERE 'id_article' = '".$id."' AND id_langue = '".$idLangue."'";
            if(!mysql_query($query)):
                $errors[] = "Une erreur est survenue.";
            else:
                $success[] = "Les modifications ont bien &eacute;t&eacute; enregistr&eacute;es.";
            endif;

        endif;
        
	endif;
endif;

require_once("meta.php");
require_once("header.php");

if($id != '' && !is_null($id) && isset($_GET['language'])):

    $query = "SELECT *, al.libelle AS libelle FROM articles a 
        LEFT JOIN article_langue al USING(id_article) 
        LEFT JOIN langues l USING(id_langue) 
        WHERE a.id_article = '".$id."' 
        AND l.code = '".$_GET['language']."'
        LIMIT 1";

    $result = mysql_query($query);

    while($row = mysql_fetch_assoc($result)):
        $online = $row['is_online'];
        $libelle = $row['libelle'];
        $texte = $row['texte'];
        $illustration = $row['illustration'];
        
        $libelle = utf8_encode($libelle);
        $texte = utf8_encode($texte);
        
    endwhile;
    
else:

    $online  = "";
    $libelle = "";
    $texte   = "";
    $illustration = "";

endif;

?>

<article class = "admin_home">
    <section>
    <div>
    <a href = "admin.php">[Retour]</a>
    <a href = "article_edit.php?id=<?php echo (isset($id)?$id:''); ?>&language=<?php echo (($language == 'fr')?'en':'fr');  ?>">[
    <?php 



    if(isset($_REQUEST['id'])):
	if($language == 'fr'):
	   echo "Version anglaise";
	else:
	   echo "Version fran&ccedil;aise";
	endif;
    else:
	echo "Version fran&ccedil;aise (Par d&eacute;faut pour la cr&eacute;ation.)";
    endif;
    ?>
    ]</a>
    </div>
    <h1><?php 
    echo ((isset($libelle) && $libelle != "")?$libelle : "Cr&eacute;ation d'un nouvel article");
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
        action = "article_edit.php?id=<?php echo $id; ?>&language=<?php echo $language; ?>"
    	enctype = "multipart/form-data"
    >
        <input type = "hidden" name = "id" value = "<?php echo (isset($id)?$id:''); ?>">
        <input type = "hidden" name = "language" value = "<?php echo $language; ?>">
	<label>En ligne</label>	
	<input type = "checkbox" id = "online" name = "online" <?php echo (($online == 1)?'checked' : ''); ?> value = '1'>
	<input 
	    type = "text"
            id = "libelle"
	    name = "libelle"
            value = "<?php echo (isset($libelle)?$libelle:''); ?>"
	    placeholder = "titre"
        >
	<textarea id = "texte" name = "texte" placeholder = "Texte"><?php echo (isset($texte)?$texte:''); ?></textarea>
    
        <?php
        if(isset($illustration)):
            ?>
            <br><br><img src = "upload/<?php echo $illustration;?>"><br><br>
            <?php
        endif;
        ?>
    
        <input 
	    type = "file"
            id = "illustr
"
            name = "illustration"
        >
	<input type = "submit" value = "Valider">
    </form>
    </section>
</article>

<?php
    require_once('footer.php');
?>
