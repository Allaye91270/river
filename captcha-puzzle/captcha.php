<?php 

session_start();

// var_dump($_POST);
echo "<input type='hidden' id='gender' value='" . $_POST["gender"] . "' />";
echo "<input type='hidden' id='firstname' value='" . $_POST["firstname"] . "' />";
echo "<input type='hidden' id='lastname' value='" . $_POST["lastname"] . "' />";
echo "<input type='hidden' id='email' value='" . $_POST["email"] . "' />";
echo "<input type='hidden' id='pwd' value='" . $_POST["pwd"] . "' />";
echo "<input type='hidden' id='pwdConfirm' value='" . $_POST["pwdConfirm"] . "' />";
echo "<input type='hidden' id='birthday' value='" . $_POST["birthday"] . "' />";
echo "<input type='hidden' id='country' value='" . $_POST["country"] . "' />";
echo "<input type='hidden' id='cgu' value='" . $_POST["cgu"] . "' />";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Slide Puzzle</title>
        <link rel="stylesheet" href="captcha.css">
    </head>

    
    <header>
  <div class="breadcrumbs">
    <ul>
      <li>
        <a href="../index.php">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path
              d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
            <path
              d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
          </svg>
        </a>
      <li class="arrow">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </li>
      <li>
        <a href="../register.php">Inscription</a>
      </li>

      <li class="arrow">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </li>
      <li>
        <a href="#">Création D'Avatar<a>
      </li>
    </ul>
  </div>
</header>
<br> <br> <br>


    <body>
        <h2>Veuillez résoudre ce Puzzle</h2>
        <div id="board">
        </div>
        <button id="btn" onclick="puzzleValidate()">Valider le captcha</button>

        <div id="popup" class="popup">
            <div class="popup-content">
              <h2 id="popup-message"><h2>
              <button id="popup-close-btn">Continuer</button>
            </div>
          </div>

            <script src="captcha.js"></script>
    </body>
</html>