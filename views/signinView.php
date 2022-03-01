<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body>

        <a href='index.php'> Retour </a>
        
        <form method="POST" action="" class="signCard">
            <input type="email" name="mailConnect" placeholder="Mail" />
            <input type="password" name="passConnect" placeholder="Mot de passe" />
            <br /><br />
            <input type="submit" name="formConnect" value="Se connecter !" />
            <?php if (isset($error)) {
            echo '<font color="red">' . $error . '</font>';
            } ?>
            <br/>
            <p>Pas encore de compte ? <a href='index.php?page=signup'> Inscrivez-vous </a> </p>
         </form>



</body>
</html>