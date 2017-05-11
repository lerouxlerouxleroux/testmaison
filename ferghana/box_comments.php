<?php

echo "<div class = 'logout_pseudo box_comments'>";

$query = "SELECT a.*,al.*,COUNT(id_commentaire) as nbComments FROM commentaires c 
    LEFT JOIN articles a USING(id_article)
    JOIN article_langue al USING(id_article)
    LEFT JOIN users u ON (u.id_user = c.id_author)
    where c.is_suppr = 0
    and a.is_suppr = 0
    and a.is_online = 1
    and u.is_suppr = 0 
    GROUP BY a.id_article
    ORDER BY nbComments DESC
    LIMIT 5
    ";

$result = mysql_query($query);

echo "<h2>";
    switch($_SESSION['ferghana_pref_language']):
        default:
        case 'fr':
            echo "Les plus comment&eacute;s";
            break;
        case 'en':
            echo "Most commented";
            break;
    endswitch;
echo "</h2>";

while($row = mysql_fetch_assoc($result)):
    echo "<div>";
    echo "<a href = 'article.php?id=".$row['id_article']."'>";
    echo $row['libelle'];
    echo " (".$row['nbComments'].")";
    echo "</a>";
    echo "</div>";
endwhile;

echo "</div>";
?>
