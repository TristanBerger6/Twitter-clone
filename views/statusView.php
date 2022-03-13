<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/js_ajax/postTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/quoteTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/deleteTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/follow.js" type="module" defer></script>
  <script src="./js/js_ajax/like.js" type="module" defer></script>
  <script src="./js/js_ajax/retweet.js" type="module" defer></script>
  <script src="./js/modules/modules.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body>

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <?= $gg ?>
        

    </main>


</body>
</html>