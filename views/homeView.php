<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="./js/globalPostTweet.js" type="module" defer></script>
  <script src="./js/displayTweets.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body class='connected-page'>
    <div class="connected-page__container">

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <div class="page-title"><a href="index.php?page=home"><h1 class="fs-700">Accueil</h1></a></div>
        <div class="post-tweet__container">
            <form action='' method="post" enctype='multipart/form-data' class="post-tweet flex">
                
                <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="tweet-profile"> 
                <div class="post-tweet__right">
                    <div class="post-tweet__right__top">
                        <div style="position : relative">
                            <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text2" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                            <div class="contenteditable" id="contenteditable2" contenteditable data-placeholder="Quoi de neuf ?" > </div>
                            <ul class="text-mentions" id="text-mentions2" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
                        </div>
                        <div class='preview'>
                            <div class="close-preview" id="close-preview2"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg></div>
                            <img class="preview-input img-tweet-preview" id="preview-input2" src='' alt="tweet image preview">
                        </div>
                    </div>
                    <div class="post-tweet__right__bot post-botom">
                        <label class="img-icon text-blue" for="input-img2">
                            <i class="fa fa-image" aria-hidden="true"></i>
                        </label>
                        <input id="input-img2" class="input-img" aria-hidden="true" type="file" name="tweet-img">
                        <span class="count-text text-blue" id="count-text2">140</span>
                        <input class='tweet-btn bg-blue text-white fw-700' type="submit" name="postTweet" value="Tweeter">
                        <?php if (isset($error)) {
                        echo '<font color="red">' . $error . '</font>';
                        } ?>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="reload-page">
            <a href="index.php?page=home" class="text-blue fs-600">Recharger la page</a>
        </div>
        <?php $i = 0;
              foreach($allTweetsWInfos as $tweet){
                $i++ ?>
            <?php require('includes/tweet.php') ?>
        <?php } ?>
        <?php require('includes/modalComments.php') ?>
        <?php require('includes/modalQuotes.php') ?>  

        

    </main>


    </div>
</body>
</html>