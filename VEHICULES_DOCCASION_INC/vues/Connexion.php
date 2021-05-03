<h1>Page de connexion</h1>
<section class="forms-section">

  <div class="forms">
    <div class="form-wrapper is-active">
      <button type="button" class="switcher switcher-login">
        Connexion
        <span class="underline"></span>
      </button>
      <form class="form form-login" method="post">
        <fieldset>
          <legend>Veuillez inscrire votre identifiant et mot de passe.</legend>
          <div class="input-block">
            <label for="login-email">Identifiant</label>

            <input id="login-email" type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required>

          </div>
          <div class="input-block">
            <label for="login-password">Mot de passe</label>

            <input id="login-password" type="password" name="motDePasse" placeholder="Mot de passe" required>

          </div>
		  <input type="hidden" name="action" value="authentification">
        </fieldset>
        <button type="submit" class="btn-login">Connexion</button>
      </form>
    </div>

    <div class="form-wrapper">
      <button type="button" class="switcher switcher-signup">
        Nouvel utilisateur
        <span class="underline"></span>
      </button>
      <form class="form form-signup" method="post">
        <fieldset>
          <legend>Veuillez inscrire vos informations.</legend>
          <div class="input-block">
            <label for="prenom">Prénom</label> 
	          <input type="text" name="prenom" required>
          </div>
          <div class="input-block">
            <label for="nom">Nom</label>
            <input type="text" name="nom" required>
          </div>
          <div class="input-block">
            <label for="dateNaissance">Date de naissance</label>
            <input type="date" name="dateNaissance" required>
          </div>
          <div class="input-block">
            <label for="adresse">Adresse</label> 
            <input type="text" name="adresse" required>
          </div>
          <div class="input-block">
            <label for="codePostal">Code postal</label> 
            <input type="text" name="codePostal" required>
          </div>
          <div class="input-block">
            <label for="telephone">Téléphone</label> 
            <input type="tel" name="telephone" required>
          </div>
          <div class="input-block">
            <label for="cellulaire">Cellulaire </label>
            <input type="tel" name="cellulaire">
          </div>
          <div class="input-block">
            <label for="courriel">Courriel </label>
            <input type="email" name="courriel">
          </div>
          <div class="input-block">
            <label for="pseudonyme">Pseudonyme</label> 
            <input type="text" name="pseudonyme" required>
          </div>
          <div class="input-block">
            <label for="motDePasse">Mot de passe</label>
            <input type="password" name="motDePasse" required>
          </div>
            <select id="villeId" name="villeId">
              <option value="1">Montréal</option>
              <option value="2">Laval</option>
              <option value="3">Longueuil</option>
              <option value="4">Toronto</option>
            </select>
        </fieldset>
        <input type="hidden" name="action" value="insereUtilisateur"/>
        <input class="btn-signup" type="submit" value="Continuer"/>
      </form>
    </div>

  </div>
</section>


<!--
<h1>Ouverture de session</h1>
	<form method="post">
		<label for="pseudonyme">Nom d'utilisateur (obligatoire) :</label>
		<input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" required><br>
		<label for="motDePasse">Mot de passe (obligatoire) :</label>
		<input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
        <input type="hidden" name="action" value="authentification">
		<br>
		<input type="submit" value="Se connecter"/>
	</form>
	
<?php
	if($data["erreurs"] != "")
?>
	<p style="color:red"><?= $data["erreurs"] ?></p><br>
	
	<a href="index.php?Utilisateur&action=creationCompte">Nouvel utilisateur? Créez un compte ></a>

-->
