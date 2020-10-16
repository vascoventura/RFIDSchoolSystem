<?php
	include_once 'includes/dbh.inc.php';
	session_start();	
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Login</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <style>
		<?php include 'css/estilo.css'; ?>
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  
  <style>
  
  body {font-family: Arial, Helvetica, sans-serif; background-color: lightgray;}
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

.container {
  padding: 16px;
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

h1{
	margin:20px;
}

.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #04354a;
   color: white;
   text-align: center;
}

  
  .carousel-inner img{
    width: 55%;
    height: 55%;
  }
  
	  table {
	margin: 8px;
	}

	th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	background: #666;
	color: #FFF;
	padding: 2px 6px;
	border-collapse: separate;
	border: 1px solid #000;
	}

	td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	border: 1px solid #DDD;
	}
	
	.backgroundred {
		background: #f54c4c;
	}
	
	.backgroundgreen {
		background: #7de368;
	}
	
	.backgroundyellow {
		background: #fad66b;
	}
	
	.backgroundgrey {
	background: #bdbbb5;
	}

	.main-container1{		
		padding: 20px 20px 20px 20px;
		border: 2px solid #73AD21;
		margin: 10px;
		background: #000000;
		
	}
	
	.containerAula{
		float: left;
		margin-top: 10px;
		margin-bottom: 10px;
		height: 150px;
		
	}
	
	
	.containerInformacao{
		float: left;
		border: 1px black;
		border-style: solid;
		border-radius: 25px;		
	}
	
	
	.NumeroSala{
		padding:10px;
		border: 1px black;
		border-style: solid;
		border-radius: 25px;
		margin-right: 10px;
		margin-left: 10px;
		margin-top: 20px;
		margin-bottom: 20px;
		
	}
	
	header{
		margin-top: 10px;
		margin-bottom: 10px;
	}
	
	.all-browsers {
  margin: 0;
  padding: 5px;
  
}

.all-browsers > h1, .browser {
  margin: 10px;
  padding: 5px;
}

.browser {
  background: white;
  border: 1px black;
  border-style: solid;
  border-radius: 25px;
}

.browser > h2, p {
  margin: 4px;
  font-size: 90%;
}

footer {
  text-align: center;
  padding: 3px;
  background-color: #04354a;
  color: white;
}

article{
	margin:20px;
}

table{
	margin: 20px 20px 20px 20px;
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

<article class="all-browsers">
	<form action="login.php" method="post">
	   <div class="container">
		<label for="uname" style="margin-bottom: 0px;"><b>Utilizador</b></label>
		<input type="text" placeholder="Introduza o Nome de Utilizador" style="margin: 0px; margin-bottom: 20px;" name="uname" required>

		<label for="psw" style="margin-bottom: 0px;"><b>Palavra-Passe</b></label>
		<input type="password" placeholder="Introduza a Palavra-Passe" style="margin: 0px; margin-bottom: 10px;" name="psw" required>
			
		<button type="submit" class="cancelbtn green" name='login'>Login</button>
		<label>
		  <input type="checkbox" checked="checked" name="remember"> Remember me
		</label>
		<span class="psw"><a href="#">Forgot password?</a></span>
        </div>
	</form>
	<p class="text-center text-danger" >
         
           <?php
			if(isset($_SESSION['nao autenticado'])){
				echo $_SESSION['nao autenticado'] ;
				unset($_SESSION['nao autenticado']);
				
				} ?>
     </p>


</article>
			<div class="footer">
			<p>&copy; 2020 - Sistema de Horários</p>
		</div>	
		

		
</body> 
</html>