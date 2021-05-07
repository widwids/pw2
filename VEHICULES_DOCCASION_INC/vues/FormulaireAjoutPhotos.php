<h1>Ajout photos voiture donnée</h1>

<div data-component="Photos" >

	<form action="index.php?Voiture_AJAX&action=ajoutPhotosVoiture" method="post" enctype="multipart/form-data" data-js-nserie ='<?php echo $data; ?>'>
		<p>Photo principale</p>
		<label for="imgPrincipale">Select image:</label>
		<input type="file" id="imgPrincipale" name="imgPrincipale" accept=".jpg, .jpeg">
		<br>
		<br>
		<p>Photo secondaire</p>
		<label for="imgSecondaire">Select image :</label>
		<input type="file" id="imgSecondaire" name="imgSecondaire[]" accept=".jpg" multiple>
		<br>
		<br>
		<button data-js-btn-soumettre>Soumettre</button>
	</form>
	
</div>

