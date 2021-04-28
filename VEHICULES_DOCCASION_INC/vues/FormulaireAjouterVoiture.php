<form action="index.php?Voiture&action=ajoutVoiture" method="post" class="yu-formulaire">
	<div>
		<label for="noSerie">№ Série</label>
		<input type="text" name="noSerie" value="">
	</div>
	<div>
		<label for="descriptionFR">Description Français</label>
		<textarea name="descriptionFR" id="descriptionFR" cols="30" rows="10"></textarea>
	</div>
	<div>
		<label for="descriptionEN">Description Anglais</label>
		<textarea name="descriptionEN" id="descriptionEN" cols="30" rows="10"></textarea>
	</div>
	<div class="yu-checkbox">
		<label for="visibilite">Visibilité</label>
		<input type="checkbox" name="visibilite">		
	</div>
	<div>
		<label for="kilometrage">Kilométrage</label>
		<input type="number" name="kilometrage" value="">
	</div>
	<div>
		<label for="dateArrivee">Date Arrivée</label>
		<input type="date" name="dateArrivee" id="dateArrivee">
	</div>
	<div>
		<label for="prixAchat">Prix Achat</label>
		<input type="number" name="prixAchat" id="prixAchat">
	</div>
	<div>
		<label for="groupeMPid">Group MP</label>
		<select name="groupeMPid" id="groupeMPid">
			<option value="">Sélectionnez un groupe MP</option>
				<?php foreach($data["motopropulseur"] as $groupeMP) { ?>

					<option value="<?= $groupeMP["idMotopro"] ?>"><?= $groupeMP["nomMotopro"]?></option>

				<?php }?>
		</select>
	</div>
		<label for="corpsId">Corps</label>
		<select name="corpsId" id="corpsId">
			<option value="">Sélectionnez un corps</option>
				<?php foreach($data["corps"] as $corp) { ?>

					<option value="<?= $corp["idCorps"] ?>"><?= $corp["nomCorpsFR"]?></option>

				<?php }?>
		</select>
	<div>
		<label for="carburantId">Carburant</label>
		<select name="carburanstsId" id="carburantId">
			<option value="">Sélectionnez un carburant</option>
				<?php foreach($data["carburant"] as $carburant) { ?>

					<option value="<?= $carburant["idCarburant"] ?>"><?= $carburant["typeCarburantFR"]?></option>

				<?php }?>
		</select>
	</div>
	<div>
		<label for="modeleId">Modèle</label>
		<select name="modeleId" id="modeleId">
			<option value="">Sélectionnez un modèle</option>
				<?php foreach($data["modele"] as $modele) { ?>

					<option value="<?= $modele["nomModele"] ?>"><?= $modele["nomModele"]?></option>

				<?php }?>
		</select>
	</div>
	<div>
		<label for="transmissionId">Transmission</label>
		<select name="transmissionId" id="transmissionId">
			<option value="">Sélectionnez une transmission</option>
				<?php foreach($data["transmission"] as $transmission) { ?>

					<option value="<?= $transmission["idTransmission"] ?>"><?= $transmission["nomTransmissionFR"]?></option>

				<?php }?>
		</select>
	</div>
	<div>
		<label for="anneeId">Année</label>
		<select name="anneeId" id="anneeId">
			<option value="">Sélectionnez une année</option>
				<?php foreach($data["annee"] as $annee) { ?>

					<option value="<?= $annee["annee"] ?>"><?= $annee["annee"]?></option>

				<?php }?>
		</select>
	</div>
	<div>
		<input type="submit" name="boutonAjouter" value="Ajouter" class="bouton-ajouter">
	</div>
</form>


