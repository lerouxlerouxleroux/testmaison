<?php

require_once("inc/_init.php");

//Sélection des articles
$idArticle = (isset($_GET['id']) ? $_GET['id'] : NULL);

//Si pas de paramètre en entrée, on renvoie vers l'index.
if(is_null($idArticle)):
    header("location:index.php");
endif;

//Suppression d'un commentaire
if(isset($_GET['action']) && $_GET['action'] == 'delete_comment'):

    $query = "DELETE FROM commentaires 
	WHERE id_commentaire = '".$_GET['comment']."'";
 
    if(!isset($_SESSION['ferghana_user']) 
	|| $_SESSION['ferghana_user']['id_droit'] < 2
	|| IS_NULL($_SESSION['ferghana_user']['id_droit'])):

	$query .= " AND id_author = '".$_SESSION['ferghana_user']['id_user']."' ";

    endif;

    $query .= "LIMIT 1";

    $result = mysql_query($query);


endif;

//Validation des commentaires
if(isset($_POST['comment'])):
    $comment = trim($_POST['comment']);
    if($comment != ""):
        
    $comment = mysql_real_escape_string($comment);
        
	$query = "INSERT INTO `commentaires`
	(
	`id_author`,
	`id_article`,
	`texte`,
	`date_creation`)
	VALUES
	(
	'".$_SESSION['ferghana_user']['id_user']."',
	'".$idArticle."',
	'".$comment."',
	'".date('Y-m-d H:i:s')."'
	);";
        

    echo $query;
    
        mysql_query($query);

    endif;
endif;

require_once("meta.php");
require_once("header.php");

//Détail de l'article
$query = "SELECT * 
	FROM langues AS l
    INNER JOIN article_langue USING(id_langue)
    INNER JOIN articles a USING(id_article)
    LEFT JOIN users u ON u.id_user = a.id_author
    WHERE l.code = '".$lang."'
    AND id_article = '".$idArticle."'
    LIMIT 1";

$result = mysql_query($query);

//Si pas de résultat, on renvoie vers l'index.
if(mysql_num_rows($result) == 0):
    header('location:index.php');
endif;

while($row = mysql_fetch_assoc($result)):
    $article = $row;
endwhile;

//Sélection des commentaires
$query = "SELECT * FROM commentaires c
	LEFT JOIN users u ON (u.id_user = c.id_author)
	WHERE id_article = '".$idArticle."' 
	AND c.is_suppr = 0 
        AND u.is_suppr = 0
	ORDER BY date_creation DESC";

$result = mysql_query($query);

$comments = array();

if(mysql_num_rows($result) > 0):
	while($row = mysql_fetch_assoc($result)):
		$comments[] = $row;
	endwhile;
endif;

?>

<article>

    <section>
    <h1><?php echo utf8_encode($article['libelle']); ?></h1>
    <div class = "author"><?php echo "Par ".ucwords(utf8_encode($article['pseudo'])); ?>, <?php echo $article['date_creation']; ?></div>
    <p class = "texte">
    <?php
    if($article['illustration'] != ""):
    ?>
	<img 
	    style = 'float:left;margin-right:10px;margin-bottom:10px;'
	    src = 'upload/<?php echo $article['illustration']; ?>'
	    >
    
    
    <?php
    endif;
    ?> 
    
	<?php echo utf8_encode(nl2br($article['texte'])); ?>
    </p>
    
    </section>
 
        
        
    <h1>Commentaires</h1>
    
    <section class = "comments">
        
        <?php
	foreach($comments as $comment):
	?>
	<?php 
	if(isset($_SESSION['ferghana_user'])):
	if(
	    $_SESSION['ferghana_user']['id_droit'] == '2'
	    || $_SESSION['ferghana_user']['id_droit'] == '3'
	    || $comment['id_author'] == $_SESSION['ferghana_user']['id_user']
	):	
	?>
	<div class = 'actions'>
        <a href = 'article.php?id=<?php echo $idArticle; ?>&action=delete_comment&comment=<?php echo $comment['id_commentaire']; ?>'>
            <img 
                src = "/img/icons/delete.png"
                alt = "Supprimer"
                title = "Supprimer"
                >
        </a></div>
	<?php 
	endif; 
        endif;
	?>
	<div class = "comment_header"><?php echo ucwords(utf8_encode($comment['pseudo'])); ?>, <?php echo $comment['date_creation']; ?></div>
	<p><?php echo nl2br(utf8_encode($comment['texte'])); ?></p>
	<?php
	endforeach;
        ?>
    </section>  

    <a name = "commentsForm"></a>
    
    <?php
    if(isset($_SESSION['ferghana_user'])):
    ?>
    <section class = "comments_form">
    <form
        name = "form_commentaires"
	action = "article.php?id=<?php echo $article['id_article']; ?>#commentsForm"
        method = "POST"
    >
    <h2>Ajouter un commentaire</h2>
    <textarea id = "comment" name = "comment" placeholder = "Ajouter un commentaire"></textarea>
    <input type = "submit" value = "Valider">;
    </form>
    </section>
    <?php
    else:
    ?>
    <section class = "comments_forbidden">
    <?php
    switch($_SESSION['ferghana_pref_language']):
        default:
        case 'fr':
            echo "Vous devez &ecirc;tre identifi&eacute; pour pouvoir poster un commentaire.";
            break;
        case 'en':
           break;
           echo "Only logged users are allowed to post comments.";
    endswitch;
    ?>
    
    </section>
    <?php
    endif;
    ?>

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
