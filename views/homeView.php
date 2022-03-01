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

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <a href= 'index.php?page=logout' > Se déconnecter </a>
        <p> username : <?= $_SESSION['username'] ?>
        <p> id : <?= $_SESSION['id'] ?>
        <p> mail : <?= $_SESSION['mail'] ?>
    </main>


</body>
</html>