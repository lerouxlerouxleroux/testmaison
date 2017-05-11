<?php

require_once("inc/_init.php");

if(
    !isset($_SESSION['ferghana_user']) 
    || is_null($_SESSION['ferghana_user']['id_droit'])
    || $_SESSION['ferghana_user']['id_droit'] > 2):

    header('location:index.php');

endif;



require_once("meta.php");
require_once("header.php");

$query = "SELECT * FROM users u
        LEFT JOIN user_droit ud USING(id_user)
        LEFT JOIN droits USING(id_droit)
	WHERE id_user != '".$_SESSION['ferghana_user']['id_user']."'
    AND is_suppr = 0
	ORDER BY date_inscription DESC ";
$resultUsers = mysql_query($query);


$query = "
   SELECT *,
    CASE WHEN l.code = 'fr' THEN al.libelle END AS libelle_fr,
    CASE WHEN l.code = 'en' THEN al.libelle END AS libelle_en
    FROM articles
    LEFT JOIN article_langue al USING(id_article)
    LEFT JOIN langues l USING(id_langue)
    GROUP BY id_article
    ORDER BY date_creation DESC
    ";
$resultArticles = mysql_query($query);


if($_SESSION['ferghana_user']['id_droit'] == 1):
?>

<article class = "admin_home">
    <section>
    <h1>Utilisateurs</h1>
    <table>
	<thead>
        <td>Pseudo</td>
        <td>Nom</td>
        <td>Pr&eacute;nom</td>
        <td>Statut</td>
        <td>Actions</td>
        </thead>
    <?php
    while($row = mysql_fetch_assoc($resultUsers)): 
        echo "<tr>";
            echo "<td>".$row['pseudo']."</td>";
            echo "<td>".$row['lname']."</td>";
            echo "<td>".$row['fname']."</td>";
            echo "<td>";
                echo (!is_null($row['libelle']) ? $row['libelle'] : 'membre');
            echo "</td>";
            echo "<td>";
            echo "<a href = 'admin_edit_user.php?id=".$row['id_user']."'>Editer</a>";
	    echo "/";
	    echo "<a href = '#' onClick = \"deleteUser('".$row['id_user']."');\"'>Supprimer</a>";
            echo "</td>";
        echo "</tr>";
    endwhile;
    ?>
    </table>
    </section>
</article>

<?php
endif;
?>

<article class = "admin_home">
    <section>
    <h1>Articles</h1>
    <input 
        type = 'button' 
        value = "AJOUTER"
        onClick = "window.location = 'article_edit.php'">
    
    <table style = "margin-top:7px;">
	<thead>
        <td>Fran&ccedil;ais</td>
        <td>Anglais</td>
        <td>En ligne</td>
        <!--<td>Actions</td>-->
        </thead>
    <?php
    while($row = mysql_fetch_assoc($resultArticles)): 
        echo "<tr>";
	   echo "<td>";
           if($row['libelle_fr']):
               echo $row['libelle_fr'];
               echo "<br>";
               echo "<a href = 'article_edit.php?id=".$row['id_article']."&language=".$row['code']."'>[Editer]</a>";
           else:
               echo "<a href = '#'>[Cr&eacute;er]</a>";
           endif;
       echo "</td>";
       echo "<td>";
           if($row['libelle_en']):
               echo $row['libelle_en'];
               echo "<br>";
               echo "<a href = '#'>[Editer]</a>";
           else:
               echo "<a href = '#'>[Cr&eacute;er]</a>";
           endif;
       echo "</td>";
	   echo "<td>";
           if($row['is_online'] == 1):
               echo "Oui";
           else:
               echo "Non";
           endif;
       echo "</td>";
       /*echo "<td><a href = '#'>[Supprimer]</a></td>";*/
        echo "</tr>";
    endwhile;
    ?>
    </table>
    </section>
</article>

<?php
    require_once('footer.php');
?>

<script type = 'text/javascript'>
function deleteUser(id){
    if(confirm("L'op\350ration ne pourra \352tre annul\351e.")){
        window.location = "admin_delete_user.php?id="+id;
    }
}
</script>