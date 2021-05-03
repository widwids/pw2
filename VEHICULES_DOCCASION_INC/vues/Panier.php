<?php $commande = $data["commande"]; $voiture = $data["voiture"] ?>

<h1>Panier</h1>

<div class="container">

    <section id="cart"> 
      <article class="product">
        <header>
          <a class="remove">
            <img src="http://www.astudio.si/preview/blockedwp/wp-content/uploads/2012/08/1.jpg" alt="">

            <h3>Enlever du panier</h3>
          </a>
        </header>

        <div class="content">

          <h1>Lorem ipsum</h1>

          <p style="color:#222"><?= $voiture["nomMarque"] ?> <?= $voiture["nomModele"]; ?> <?= $voiture["anneeId"]; ?></p>
        </div>

        <footer class="content">
          <span class="qt-minus" style="color:#222">-</span>
          <span class="qt" style="color:#222">1</span>
          <span class="qt-plus" style="color:#222">+</span>

          <h2 class="full-price" style="color:#222">
            <?= number_format($commande["prixVente"], 2, ',', ' ') ?>
          </h2>

        </footer>
      </article>

      
    </section>

  </div>

  <footer id="site-footer">
    <div class="container clearfix">

      <div class="left">
        <h2 class="subtotal">Subtotal: <span><?= number_format($commande["prixVente"], 2, ',', ' ') ?></span>$</h2>
        <h3 class="tax">Taxes (14.975%): 
          <span><?= number_format($commande["prixVente"] * 0.14975, 2, ',', ' ') ?></span>$</h3>
        <h3 class="Shipping">Manutention: <span>00.00</span>$</h3>
      </div>

      <div class="right">
        <h1 class="total">Total: 
          <span style="color:#222"><?= number_format($commande["prixVente"] + $commande["prixVente"] * 0.14975, 2, ',', ' ') ?></span>$
        </h1>
        <a class="btn">Checkout</a>
      </div>

    </div>
  </footer>

