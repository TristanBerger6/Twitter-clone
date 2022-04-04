<!DOCTYPE html>
<html lang="fr">
<head>
  <base href=<?= $baseURI?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/globalPostTweet.js" type="module" defer></script>
  <script src="./js/displayTweets.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body class="connected-page">
    <div class="connected-page__container">
    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <div class="page-title flex">
            <a href="javascript:history.go(-1)" class="page-title__back" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg></a>
            <a href=""><h1 class="fs-700">Tweet</h1></a>
        </div>
        <div class="status-tweet-response">
        <?php $i = 0;
                foreach($allAboveTweetsWInfos as $key=>$tweet){
                    $i++;
                    if($key === count($allAboveTweetsWInfos)-1){
                        $tweet['date_hour_creation'] = date("H:i \· d M. Y",strtotime($tweet['date_hour_creation']));
                        require('includes/tweetMainStatus.php');
                    }else{
                        $tweet['date_hour_creation'] = get_time_ago_fr($tweet['date_hour_creation']);
                        require('includes/tweet.php');
                    }
                    ?>
        <?php } ?>
        </div>
        <?php 
            foreach($allCommentsWInfos as $tweet){
                $i++;
                require('includes/tweet.php');
            }
                require('includes/modalComments.php');
                require('includes/modalQuotes.php'); ?>  
        

    </main>
    </div>


</body>
</html>