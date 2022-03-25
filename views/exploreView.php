<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="./js/globalPostTweet.js" type="module" defer></script>
  <script src="./js/displayTweets.js" type="module" defer></script>
  <script src="./js/explore.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body>

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <form name="explore-form">
            <div style="position : relative">
                <input type="text" name="explore-input" id="explore-input" value="<?= $textValue?>"></input>
                <ul class="explore-suggestions" id="explore-suggestions" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%);display:none;background:grey"> </ul>
            </div>
            <input type="submit" name="explore-submit" id="explore-submit" class="sr-only"></input>
        </form>
        <?php $i = 0;
              foreach($allTweetsWInfos as $tweet){
                $i++ ?>
            <?php require('includes/tweet.php') ?>
            <br/>
            <br/>
            <br/>
            
        <?php } ?>
        <?php require('includes/modalComments.php') ?>
        <?php require('includes/modalQuotes.php') ?>  

    </main>
    <script>
    
    
    </script>


</body>
</html>