<h1>Page de connexion</h1>
<!--
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
  </div>
</section>


-->
<section class="connexionWrapper">
  <form method="post" class="login">
    <label for="pseudonyme">Identifiant</label><br>
    <input type="text" name="pseudonyme" placeholder="Identifiant" required><br>
    <label for="motDePasse">Mot de passe</label><br>
    <input type="password" name="motDePasse" placeholder="Mot de passe" required><br>
        <input type="hidden" name="action" value="authentification">
    <br>
    <button type="submit" value="Connexion">Connexion</button>
    <a href="index.php?Utilisateur&action=creationCompte">Créez un compte</a>
  </form>
</section>
	
<?php
	if($data["erreurs"] != "")
?>
	<p style="color:red"><?= $data["erreurs"] ?></p><br>
	


