<?php
include_once 'includes/dbh.inc.php';
session_start();

if((empty($_POST['uname']) ) || (empty($_POST['psw']) )){
	header('Location: index.php');
	exit();
}

$utilizador = mysqli_real_escape_string($conn, $_POST['uname']);
$pass = hash('md5', mysqli_real_escape_string($conn, $_POST['psw']));

//$pass = mysqli_real_escape_string($conn, $_POST['psw']);


$sql = "Select * from users where Id_User = '" .$utilizador. "' and Password = '" .$pass."' ";

$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
				
				  
				
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)):
			if ($row['AlunoId'] != null){
				$_SESSION['aluno'] = $utilizador;
				header('Location: projetoFinal.php');
				exit();
			} else if ($row['ProfessorId'] != null){
				$_SESSION['professor'] = $utilizador;
				header('Location: projetoFinal.php');
				exit();
			} /*else {
				$_SESSION['nao autenticado'] = "Utilizador ou Password Inválidos" ;
				header('Location: index.php');
				exit();
			}*/
	

		endwhile;
	}  else {
	    
		            /*<div class="alert alert-danger" role="alert">
                          This is a danger alert—check it out!
                    </div>
		        */
		
		    $_SESSION['nao autenticado'] = "Utilizador ou Password Inválidos" ;
				header('Location: index.php');
				exit(); 
	}

?>
