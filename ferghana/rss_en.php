<?php
require_once("inc/_init.php");


//Sélection des articles

$query = "SELECT * 
	FROM langues AS l
    INNER JOIN article_langue al USING(id_langue)
    INNER JOIN articles a USING(id_article)
    LEFT JOIN users u ON (a.id_author = u.id_user) 
	WHERE l.code = 'fr'
    AND a.is_online = 1
    AND a.is_suppr = 0 
    ORDER BY a.date_creation DESC
    LIMIT 6";

$result = mysql_query($query);

function cleanText($intext) {
    return utf8_encode(htmlspecialchars(stripslashes($intext)));
}
 
 
 
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
echo '<rss version="2.0">';
echo '    <channel>';
    
echo '        <title>ferghana.fr</title>';
echo '        <link><lien>http://ferghana.fr</lien></link>';
echo '        <description>ferghana.fr</description>'; 
 
while ($row = mysql_fetch_array($result) )
{
echo '<item>';
echo '<title>' .$row['libelle']. '</title>';
echo '<link> http://www.ferghana.fr/article.php?id='.$row->id.' </link>';
echo '<description>' .$row['texte']. '</description>';
echo '</item>';
}
 
        
echo '    </channel>';
echo '</rss>';
 
?>
