<h1>Ajout photos voiture donnée</h1>

<div data-component="Photos" >

	<form data-js-nserie ='<?php echo $data; ?>'>
		<p>Photo principale</p>
		<label for="imgPrincipale">Select image:</label>
		<input type="file" id="imgPrincipale" name="imgPrincipale" accept=".jpg, .jpeg">
		<br>
		<br>
		<p>Photo secondaire</p>
		<label for="imgimgSecondaire">Select image :</label>
		<input type="file" id="imgSecondaire" name="imgSecondaire" accept=".jpg, .jpeg" multiple>
		<br>
		<br>
		
	
	</form>
	<button data-js-btn-soumettre>Soumettre</button>
</div>

