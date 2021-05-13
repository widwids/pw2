<section class="yu-section">

    <div class="yu-table-connexions yu-btn-ajouter-container">
        <button class="yu-btn-ajouter">Mettre à jour</button>
    </div>

    <div class="yu-table-responsive">        
    <table class="yu-table yu-table-connexions" data-component="Pagination">
        
        <thead>
            <tr>
                <th>Pseudonyme</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse IP</th>
                <th>Date connexion</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($data["connexions"] as $connexion) { ?>

        <tr>
            <td><?= $connexion["pseudonyme"] ?></td>
            <td><?= $connexion["nom"]?></td>
            <td><?= $connexion["prenom"]?></td>
            <td><?= $connexion["adresseIp"]?></td>
            <td><?= $connexion["dateConnexion"]?></td>
        </tr>

            
        <?php }?>

        </tbody>

    </table>
    </div>

</section>

<script>

function obtenirConnexionsAJAX()
{

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {  
            let jsonResponse = JSON.parse(this.response)['connexions'];

            let table = document.querySelector("table tbody");
            table.innerHTML = "";

            for(let i=0; i<jsonResponse.length; i++)
            {
                let connexion = jsonResponse[i];

                table.innerHTML += 
                `
                <tr>
                    <td>${connexion["pseudonyme"]}</td>
                    <td>${connexion["nom"]}</td>
                    <td>${connexion["prenom"]}</td>
                    <td>${connexion["adresseIp"]}</td>
                    <td>${connexion["dateConnexion"]}</td>
                 </tr>
                `;                
            }     
            
            
        }
        };

    xhttp.open("GET", "index.php?Utilisateur&action=listeConnexionsAJAX", true);
    xhttp.send();

}

document.querySelector(".yu-btn-ajouter").addEventListener("click", () => 
{
    obtenirConnexionsAJAX();
});


</script>

