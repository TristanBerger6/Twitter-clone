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

<body>

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <div class="postTweet">
            <form action='' method="post" enctype='multipart/form-data'>
                <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
                <div style="position : relative">
                <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text2" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                <div class="contenteditable" id="contenteditable2" contenteditable> </div>
                <ul class="text-mentions" id="text-mentions2" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
                </div>
                <span class="count-text" id="count-text2">140</span>
                <span class="close-preview" id="close-preview2"> close preview</span>
                <img class="preview-input img-tweet-preview" id="preview-input2" src='' alt="tweet image preview">
                <label class="img-icon" for="input-img2">
                    <i class="fa fa-image" aria-hidden="true"></i>
                </label>
                <input id="input-img2" class="input-img" type="file" name="tweet-img">
                <input type="submit" name="postTweet" value="Tweeter">
                <?php if (isset($error)) {
                echo '<font color="red">' . $error . '</font>';
                } ?>
            </form>
        </div>
        <br/>
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