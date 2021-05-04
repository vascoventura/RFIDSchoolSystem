<?php
	include_once 'includes/dbh.inc.php';
	session_start();
	error_reporting(E_ALL & ~E_NOTICE);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Presenças</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg" />
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


  <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Lato:ital@1&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@1,700&display=swap" rel="stylesheet">


 
</head>		  	  
<body>

	<!--Navbar-->

		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		  <!-- Brand/logo -->
		  <a class="navbar-brand" href="projetoFinal.php">
			<img src="img/logo.jpg" alt="Logo" style="width:80px;">
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
		  
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
	           <div class="collapse navbar-collapse" id="collapsibleNavbar">
		  		<ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link" href="pagina_presencas.php">Presenças</a>
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
					<li class="saudacao"><a class="nome_link" href="palavra-passe.php">Olá, <?php echo ($nome_user);?></a>
					</li>
				</ul>
				</div> 
			
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
	            <div class="collapse navbar-collapse" id="collapsibleNavbar">
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
						<li class="saudacao"><a class="nome_link" href="palavra-passe.php">Olá, prof. <?php echo ($nome_user);?></a>
						</li>
					</ul>
				</div>
			<?php 

			} else {

			?>
			     <div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav"> 
					<li class="nav-item">
			  			<a class="nav-link" href="login.php">Login</a>
					</li>
				</ul>
				</div>

			<?php			

			}

		  ?>
		</nav>

		<article class="all-browsers">
    		<h1>Presenças</h1>
    		<?php
    		if(isset($_SESSION['aluno'])){
    			$sql = "select DISTINCT(disciplinas.Nome_Disciplina), disciplinas.Semestre, professores.Nome_Professor
                        from inscricoes, presencas, disciplinas, aulas, alunos, professores, users
                        where inscricoes.DisciplinaId = disciplinas.Id_Disciplina 
                        and inscricoes.AlunoId = alunos.Id_Aluno 
                        and alunos.Id_Aluno = users.AlunoId 
                        and users.Id_User = '".$_SESSION['aluno']."'
                        and presencas.AulaId = aulas.Id_Aula
                        and professores.Id_Professor = aulas.ProfessorId 
                        and inscricoes.EstadoId = 1
                        and alunos.Id_Aluno = presencas.AlunoId
                        and disciplinas.Id_Disciplina = aulas.DisciplinaId"; 

			$result = mysqli_query($conn, $sql);
	        $resultCheck = mysqli_num_rows($result);          
        
           	if ($resultCheck > 0) {?>
				<div class="table-responsive">          
					<table class="table center">
						<thead>
							<tr>
								<th>Disciplina</th>
								<th>Semestre</th>
								<th>Docente</th>
							</tr>
						</thead>
						<tbody>							
							<?php
							while ($row = mysqli_fetch_assoc($result)): ?> 
							<tr>
								<td><a href="presencas.php?disciplina=<?php echo $row['Nome_Disciplina']?>"><?= $row['Nome_Disciplina'] ?></a></td>
								<td><?= $row['Semestre']?></td>
								<td><?= $row['Nome_Professor']?></td>
							</tr>
							<?php endwhile;?>
					
						</tbody>
					</table>
				</div>
						
				<?php
			} else { 
			?>
				<h2>Não Foram Encontrados Resultados!</h2>
			<?php
			}
            

		}else{
			?>
				<h2>Não Foram Encontrados Resultados!</h2>
			<?php
		}

		?>
	</article>
	
	<div class="page-wrapper">
	</div>
	
	<div class="footer">
		<p>&copy; 2020 - Sistema de Horários</p>
	</div>

</body>
</html>