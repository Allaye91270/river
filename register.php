<?php
		session_start();
		require "core/functions.php";
 		include "template/header.php"; 
?>


<div class="container">
<h1>S'inscrire</h1>

<?php 
if( isset($_SESSION['errors'])) {
	$listOfErrors = $_SESSION['errors'];
	echo '<div class="alert alert-danger" role="alert">';
	foreach( $listOfErrors as $error){
			echo "<li>".$error;
	}
	echo "</div>";
	unset($_SESSION['errors']);
}

?>
<br><br><br><br>

<body>
    <form action="captcha-puzzle/captcha.php" method="POST" class="registration-form">
        <div class="step" id="step1">
            <h5>Étape 1: Informations de base</h5>
            <div class="mb-3">
	<h5>Civilité</h5>
		<input type="radio" class="form-check-input" id="gender0" name="gender" checked="checked" value="0">
		<label for="gender0">M.</label><br>
		
		<label>
			<input type="radio" class="form-check-input" name="gender" value="1">
			Mme.
		</label><br>

		<label>
			<input type="radio" class="form-check-input" name="gender" value="2">
			Autre
		</label>
	</div>


	<div class="mb-3">
		<label for="firstname" class="form-label"><h5>Votre prénom</h5></label>
    	<input type="text" name="firstname" class="form-control" id="firstname" placeholder="John" required="required">
	</div>

	<div class="mb-3">
		<label for="lastname" class="form-label"><h5>Votre nom</h5></label>
    	<input type="text" name="lastname" class="form-control" id="lastname" placeholder="Doe" required="required">
	</div>

	<div class="mb-3">
		<label for="birthday" class="form-label"><h5>Date de naissance</h5></label>
    	<input type="date" name="birthday" class="form-control" id="birthday" required="required">
	</div>

	<div class="mb-3">
		<label for="country" class="form-label"><h5>Pays de naissance</h5></label>
    	<select name="country"  class="form-select">
        <option value="" disabled selected>Sélectionnez un pays</option>
		<option value="fr">France</option>
    	<option value="pl">Pologne</option>
    	</select>
	</div>


            <div class="mb-3">
		<label for="email" class="form-label"><h5>Votre email</h5></label>
    	<input type="email" name="email" class="form-control" id="email" placeholder="john.doe@gmail.com" required="required">
	</div>

	<div class="mb-3">
		<label for="pwd" class="form-label"><h5>Votre mot de passe</h5></label>
    	<input type="password" name="pwd" class="form-control" id="pwd" required="required">
	</div>

	<div class="mb-3">
		<label for="pwdConfirm" class="form-label"><h5>Confirmation</h5></label>
    	<input type="password" name="pwdConfirm" class="form-control" id="pwdConfirm" required="required">
	</div>

	<div class="mb-3">
    	<input type="checkbox" class="form-check-input" name="cgu" id="cgu" required="required">

		<label for="cgu" required="required" class="form-label">J'accepte les CGUs </label>
	</div>	
	</div>
            <button type="button" class="btn btn-secondary prev-step" data-step="1">Précédent</button>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>
</body>

<?php include "template/footer.php" ?>