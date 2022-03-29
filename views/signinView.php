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
  <main >
    <div class="sign-page text-light bg-navy">
   
      <div class="sign-card bg-dark ">
        <div class="sign-card__topside">
          <a href='index.php' class='back'> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg> </a>
          <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="rgb(255,255,255)" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
          </div>
        </div>
        <form method="POST" action="" class="sign-form fs-500 ">
          <h1 class="fs-800 sign-title text-white">Connectez-vous à Twitter </h1>
          <input class="sign-input bg-dark" type="email" name="mailConnect" placeholder="Mail" required/>
          <input class="sign-input bg-dark" type="password" name="passConnect" placeholder="Mot de passe" required/>
          <input class = 'sign-buton fw-700 bg-white text-dark' type="submit" name="formConnect" value="Se connecter" />
          <?php if (isset($error)) {
          echo '<font color="red">' . $error . '</font>';
          } ?>
          <p class="fs-400 sign-redirect">Pas encore de compte ? <a href='index.php?page=signup' class="text-blue"> Inscrivez-vous </a> </p>
        </form>
      </div>
    </div>
  </main>
</body>
</html>