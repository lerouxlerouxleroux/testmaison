<?php
include_once('header.php');
?>


	<section class = "contact">

	<article>
	    <h1>Contact</h1>
	    <div class = "success"><?php if($_GET['success'] == 'true'): ?>Votre message a bien &eacute;t&eacute; envoy&eacute;.<?php endif; ?></div>
	    <form 
		id = "contact" 
		name = "contact"
		method = "POST"
                action = "contact.php?success=true"
		>
		<input type = "text" placeholder = "Objet"></input>
		<input type = "text" placeholder = "Vous &ecirc;tes"></input>
		<textarea placeholder = "Votre message" rows = "10"></textarea>
		<input type = "submit" value = "Envoyer">
	    </form>
	</article>



	</section>


<?php
    include_once('footer.php');
?>



