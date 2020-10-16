<?php
	include_once 'includes/dbh.inc.php';
	session_start();
	error_reporting(E_ALL & ~E_NOTICE);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Docentes</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg">
  <style>
		<?php include 'css/estilo.css'; ?>

		.search-container button {
	  padding: 6px 10px;
	  margin-right: 16px;
	  margin-bottom: 10px;
	  background: #ffffff;
	  font-size: 17px;
	  border: none;
	  cursor: pointer;
	}


  </style>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>			  
<body>

	<!--Navbar-->

		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		  <!-- Brand/logo -->
		  <a class="navbar-brand" href="projetoFinal.php">
			<img src="img/logo.jpg" alt="Logo" style="width:80px;">
		  </a>
		  
		  <?php
		  	if(isset($_SESSION['aluno'])){
		  	
	           $nome = "select Nome_Aluno 
	           from alunos, users where alunos.Id_Aluno = users.AlunoId and Id_User = " .$_SESSION['aluno'];" "; 
	                   $nome_numero_linhas = mysqli_query($conn, $nome);
	                   $nome_registos = mysqli_num_rows($nome_numero_linhas);
	           
	           	if ($nome_registos > 0){
	           		while ($row1 = mysqli_fetch_assoc($nome_numero_linhas)){ 
	                	$nome_user = $row1['Nome_Aluno'];
	                }
	         	}	             
	       ?>
	               	
		  		<ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link" href="presencas.php">Presenças</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="horario.php">Horário</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="docentes.php">Docentes</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="logout.php">Logout</a>
					</li>
					<li class="saudacao"> Olá, <?php echo ($nome_user);?> </li>
				</ul>
			
			<?php
			} elseif(isset($_SESSION['professor'])){ 
				
	                   $nome = "select Nome_Professor from professores, users where professores.Id_Professor = users.ProfessorId and Id_User = " .$_SESSION['professor'];" ";
	                   $nome_numero_linhas = mysqli_query($conn, $nome);
	                   $nome_registos = mysqli_num_rows($nome_numero_linhas);
	           
	           	if ($nome_registos > 0){
	           		while ($row1 = mysqli_fetch_assoc($nome_numero_linhas)){ 
	                	$nome_user = $row1['Nome_Professor'];
	                }
	         	} 
	        

	        ?> 
			  		<ul class="navbar-nav">
						<li class="nav-item">
						  <a class="nav-link" href="meusalunos.php">Meus Alunos</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="horario.php">Horário</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="logout.php">Logout</a>
						</li>
						<li class="saudacao"> Olá, prof. <?php echo ($nome_user);?> </li>
					</ul>
			<?php 

			} else {

			?>
			
				<ul class="navbar-nav"> 
					<li class="nav-item">
			  			<a class="nav-link" href="login.php">Login</a>
					</li>
				</ul>

			<?php			

			}

		  ?>
		</nav>				

		<article class="all-browsers">
		  <h1>Meus Alunos</h1>

		  <div class="search-container">
		    <form action="pesquisa_aluno.php" method="POST">
		      <input type="text" placeholder="Pesquisar Aluno..." name="search">
		      <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
		    </form>
		  </div>
		</div>

		  	<?php 

		  	//query da pesquisas

		if(isset( $_POST['submit-search'])){

		  		$pesquisa = mysqli_escape_string($conn, $_POST['search']);

		  		$query_pesquisa = "select distinct(inscricoes.AlunoId),
								 alunos.Nome_Aluno, 
								 alunos.Email,
								 disciplinas.Nome_Disciplina
								 from inscricoes,
								 disciplinas, 
								 aulas, 
								 alunos,
								 professores,
								 users
								 where inscricoes.AlunoId = alunos.Id_Aluno
								 and inscricoes.DisciplinaId = disciplinas.Id_Disciplina
								 and disciplinas.Id_Disciplina = aulas.DisciplinaId
								 and aulas.ProfessorId = professores.Id_Professor
								 and professores.Id_Professor = users.ProfessorId
								 and Id_User = " .$_SESSION['professor']. "
								 and Nome_Aluno LIKE '%$pesquisa%'
								order by Nome_Disciplina; ";
				

				$result_pesquisa = mysqli_query($conn, $query_pesquisa);

				$resultCheck_pesquisa = mysqli_num_rows($result_pesquisa);


				if ($resultCheck_pesquisa > 0){
				 ?>
					<div class="table-responsive1">          
						  <table class="table center">
							<thead>
							  <tr>
								<th>Nome</th>
								<th>Email</th>
								<th>Estado</th>
							  </tr>
							</thead>
							<tbody>							
					<?php

					while ($row = mysqli_fetch_assoc($result_pesquisa)): ?> 
						<tr>
							<td><?= $row['Nome_Aluno'] ?></td>
							<td><?= $row['Email']?></td>
							<td><?= $row['Nome_Disciplina']?></td>
						</tr>

					<?php endwhile;?>
					
							</tbody>
					</table>

						<a style="margin:10px;" href="meusalunos.php">Voltar</a>

					</div>
						
					<?php
				} else { ?>

					<h2>Não Foram Encontrados Resultados!</h2>

					<a style="margin:10px;" href="meusalunos.php">Voltar</a>
				<?php
				}


		  	}
				?>	
				
							
		  
		</article>
		
		<div class="footer">
			<p>&copy; 2020 - Sistema de Horários</p>
		</div>		
</body> 
</html>