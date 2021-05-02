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
      <form class="form form-signup">
        <fieldset>
          <legend>Veuillez inscrire vos informations.</legend>
          <div class="input-block">
            <label for="signup-email">Courriel</label>
            <input id="signup-email" type="email" required>
          </div>
          <div class="input-block">
            <label for="signup-password">Mot de passe</label>
            <input id="signup-password" type="password" required>
          </div>
          <div class="input-block">
            <label for="signup-password-confirm">Confirmation du mot de passe</label>
            <input id="signup-password-confirm" type="password" required>
          </div>
        </fieldset>
        <button type="submit" class="btn-signup">Continuer</button>
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
