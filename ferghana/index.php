<?php

require_once("inc/_init.php");

require_once("meta.php");
require_once("header.php");

//Sélection des articles

$query = "SELECT * 
	FROM langues AS l
    INNER JOIN article_langue al USING(id_langue)
    INNER JOIN articles a USING(id_article)
    LEFT JOIN users u ON (a.id_author = u.id_user) 
	WHERE l.code = '".$lang."'
    AND a.is_online = 1
    AND a.is_suppr = 0 
    ORDER BY a.date_creation DESC
    LIMIT 6";

$result = mysql_query($query);

?>

<article>
    <?php
    if(mysql_num_rows($result) > 0):
        while($article = mysql_fetch_assoc($result)):
            ?>
             <section class = "home">
             <h1>
                 <?php echo ucfirst(utf8_encode($article['libelle'])); ?>
             </h1>
                 
             <div class = "article_author">
                 <?php echo ucwords($article['pseudo']); ?>, 
                 <?php echo $article['date_creation']; ?>
             </div>  
                 
             <div class = "home_article_text">
            
             <?php 

             $texte = utf8_encode($article['texte']);	
             $texte = strip_tags($texte);
             $texte = substr($texte,0,600);

             echo $texte."...";

             ?>
             </div>
             
             <div class = "more">
            <a 
                href = "article.php?id=<?php echo $article['id_article']; ?>";
            >
            <?php
            switch($lang):
                default:
                case 'fr':
                echo "Voir plus";
                break;
                case 'en':
                echo "More";
                break;
            endswitch;
            ?>
            </a>
             </div>
                 </section>
            <?php
        endwhile;
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
    
    require_once('box_comments.php');
    
    ?>
    
</aside>

<?php
    require_once('footer.php');
?>
