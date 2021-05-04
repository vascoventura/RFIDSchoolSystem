<?php
include_once 'includes/dbh.inc.php';
session_start();

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Nova Palavra-Passe</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  

  <style>
		<?php include 'css/estilo.css'; ?>
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Lato:ital@1&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
  
  <style>
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #04354a;
}

.container1 {
  padding: 15px;
  margin-top: 0px;
  margin-bottom: 20px;
  height: 550px;
  background-color: #5db3de;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}

</style>
</head>		  
<body>

	<!--Navbar-->

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	  <!-- Brand/logo -->
	  <a class="navbar-brand" href="projetoFinal.php">
		<img src="img/logo.jpg" alt="Logo" style="width: 80px;">
	  </a>  
	</nav>

	<div class="browser-login">
		<form action="palavra-passe-nova.php" method="post">
		   <div class="container1">
				

				<label for="psw1" style="margin-bottom: 0px;"><b>Palavra-Passe Atual</b></label>
				<input type="password" placeholder="Introduza a Palavra-Passe Atual" style="margin: 0px; margin-bottom: 10px;" name="psw1" required>

                <label for="psw2" style="margin-bottom: 0px;"><b>Nova Palavra-Passe</b></label>
				<input type="password" placeholder="Introduza a Nova Palavra-Passe" style="margin: 0px; margin-bottom: 10px;" name="psw2" required>

                <label for="psw3" style="margin-bottom: 0px;"><b>Nova Palavra-Passe</b></label>
				<input type="password" placeholder="Repita a Nova Palavra-Passe" style="margin: 0px; margin-bottom: 10px;" name="psw3" required>
					
				<button type="submit" class="cancelbtn green" name='login'>Alterar Palavra-Passe</button>
	        </div>
		</form>
		<p class="text-center text-danger" >
	         
	           <?php
				if (isset($_SESSION['nao autenticado'])){
					echo $_SESSION['nao autenticado'];
					unset($_SESSION['nao autenticado']);
					
				} ?>
	     </p>

	</div>

<div class="footer">
	<p>&copy; 2020 - Sistema de Horários</p>
</div>

		

		
</body> 
</html>