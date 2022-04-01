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

<body class="connected-page">
    <div class="connected-page__container">
        <?php require('includes/nav.php') ?>
        <main class='homeContainer'>
            <form name="explore-form">
                <div style="position : relative">
                    <div class="explore-block flex" id="explore-block">
                        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path id="explore-block-search" fill="rgb(255,255,255)" d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"/></svg>
                        <input type="text" name="explore-input" id="explore-input" value="<?= $textValue?>" placeholder="Recherche Twitter"></input>
                        <div class="explore-block__close" id="explore-block-close" >
                            <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path  fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg>
                        </div>
                    </div>
                    <div class="text-mentions__container" id="explore-suggestions-container">
                        <ul class="text-mentions" id="explore-suggestions" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%);"></ul>
                        <div class="text-mentions-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:1"></div>
                    </div>
                </div>
                <input type="submit" name="explore-submit" id="explore-submit" class="sr-only"></input>
            </form>
            <?php $i = 0;
                foreach($allTweetsWInfos as $tweet){
                    $i++; 
                    require('includes/tweet.php') ;
                } 
                require('includes/modalComments.php'); 
                require('includes/modalQuotes.php'); 
            ?>  
        </main>
    </div>
</body>
</html>