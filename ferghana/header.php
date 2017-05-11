<body>
    

    
        <div id = "container">
            <header>
                <div id = "actions">
                    
                    <?php
                    if(!isset($_SESSION['ferghana_user'])):
                    ?>

                    <?php
                    endif;
                    ?>
                    
                    <div id = "language">
                        
                        <?php
                        //Récupération de l'URL courante et ajout du param de langue
                        $url = $_SERVER['PHP_SELF'];
                        if($_SERVER['QUERY_STRING'] != ""):
                            $url .= "?";
                            $url .= $_SERVER['QUERY_STRING'];
                            $url .= "&language=";
                        else:
                            $url .= "?language=";
                        endif;
                        ?>
                        
                        <a href = "<?php echo $url; ?>fr">
                            <img src = "<?php echo URL_WWW; ?>img/flags/fr.png">
                        </a>
                        <a href = "<?php echo $url; ?>en">
                            <img src = "<?php echo URL_WWW; ?>img/flags/en.png">
                        </a>
                    </div>

                </div>
                
                <div class = "titre"><span>Ferghana.fr</span></div>
                
                <nav>
                   <ul>
                       <li>
                           <a href = "index.php">
                               <?php
                               switch($_SESSION['ferghana_pref_language']):
                                   default :
                                   case 'fr' :
                                       echo "Accueil";
                                       break;
                                   case 'en' :
                                       echo "Home";
                                       break;
                               endswitch;
                               ?>
                           </a>
                       </li>
                       <!--<li>
                           <a href = "listing.php">
                               <?php
                               switch($_SESSION['ferghana_pref_language']):
                                   default :
                                   case 'fr' :
                                       echo "Recherche";
                                       break;
                                   case 'en' :
                                       echo "Browse";
                                       break;
                               endswitch;
                               ?>
                           </a>
                       </li>-->
                       <li>
                           <a href = "contact.php">
                               <?php
                               switch($_SESSION['ferghana_pref_language']):
                                   default :
                                   case 'fr' :
                                       echo "Contact";
                                       break;
                                   case 'en' :
                                       echo "Contact";
                                       break;
                               endswitch;
                               ?>
                           </a>
                       </li>
                       <?php
                       if(
                        isset($_SESSION['ferghana_user']) 
                        && !is_null($_SESSION['ferghana_user']['id_droit'])
                        && $_SESSION['ferghana_user']['id_droit'] < 2):
                       ?>
                       <li>
                           <a href = "admin.php">Administration</a>
                       </li>
                       <?php
                       endif;
                       ?>
                </nav>
                <div class = "rss"><a href = "rss_<?php echo $_SESSION['ferghana_pref_language']; ?>.php"><img src = "img/icons/rss.png"></a></div>
            </header>
