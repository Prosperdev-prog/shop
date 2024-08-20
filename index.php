<?php

 require("config/commandes.php");
    $mesProduits=afficher();
    $produits = array('$image', '$nom', '$prix', '$desc');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gestion des produits</title>
    </head>
    <body>
        <h2>Gestion des produits</h2>
        <form action="" method="">
        <input type="text" class="mail_text" placeholder="Your Name" name="Your Name">
        <input type="text" class="mail_text" placeholder="Your Prix" name="Your Prix">
        <input type="text" class="mail_text" placeholder="Your Description" name="Your Description">
        <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="Massage"></textarea>
             <div class="send_bt"><a href="#">SEND</a></div>
            <!-- Ajouter d'autres champs selon vos besoins -->
            <button type="submit">Ajouter</button>      <button type="submit">Modifier</button>       <button type="submit">Supprimer</button>
        </form>
        <h1>Liste des produits</h1>
    
        <?php foreach ($produits as $produits) : ?>
            <table>
            <tr>
            <?php echo "
                <?= $produits->$nom ?>
                <title> <?= $produits->$image?></title>
                <?= $produits->$prix ?>
                <?= $produits->$description ?>" ?>
            </tr> 
            </table> 
            <!--<?php echo "Le fruit est :($fruit);" ?>-->
        <?php endforeach; ?>
   
    </body>
</html>