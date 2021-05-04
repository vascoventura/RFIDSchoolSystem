<?php
	include_once 'includes/dbh.inc.php';
	session_start();
	date_default_timezone_set('Europe/Lisbon');
	error_reporting(E_ALL & ~E_NOTICE);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Salas</title>
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
		  if(isset($_SESSION['professor'])){
				
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
						  <a class="nav-link" href="salas.php">Salas</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="logout.php">Logout</a>
						</li>
						<li class="saudacao"><a class="nome_link" href="palavra-passe.php">Olá, prof. <?php echo ($nome_user);?></a>
						</li>
					</ul>
				</div>
		</nav>

			<article class="all-browsers article">

			  <h1>Salas de Aula</h1>

			  	<?php 
			  		$sql_dropdown_escola = "Select escolas.Nome_Escola from escolas";
			  		$result_dropdown_escolas = mysqli_query($conn, $sql_dropdown_escola);

			  		$resultCheck_dropdown_escolas = mysqli_num_rows($result_dropdown_escolas);

			  		if($resultCheck_dropdown_escolas > 0){ ?>
			  			<form action="" method="post">
									   <label for="escolas_label">Escola:</label>
									   <select name="escolas" id="escolas">
									   <option id="padrão" value="0" name="escola">----</option>
						<?php

						while ($row_dropdown_escola = mysqli_fetch_assoc($result_dropdown_escolas)){ 
										echo "<option id='" .$row_dropdown_escola['Nome_Escola']. "' value='".$row_dropdown_escola['Nome_Escola']."' > " .$row_dropdown_escola['Nome_Escola']. " </option>";
						}
						
							?>
										</select>
										
										<button type="submit" name="submit" class="btn btn-dark">
										    <i class="fa fa-search"></i>
										</button>
										
								</form>

							<?php


								$selected_val_escola = $_POST['escolas'];  // Storing Selected Value In Variable
					}

								

			  			

			  		$sql_dropdown_departamento = "Select departamentos.Nome_Departamento from departamentos";
			  		$result_dropdown_departamentos = mysqli_query($conn, $sql_dropdown_departamento);


					$resultCheck_dropdown_departamentos = mysqli_num_rows($result_dropdown_departamentos);			 
					
							if ($resultCheck_dropdown_departamentos > 0) {  ?>
								<form action="" method="post">
									   <label for="departamentos_label">Departamento:</label>
									   <select name="departamentos" id="departamentos">
									   <option id="padrão" value="0" name="departamento">----</option>
								
							<?php

								while ($row_dropdown_departamento = mysqli_fetch_assoc($result_dropdown_departamentos)){ 
										echo "<option id='" .$row_dropdown_departamento['Nome_Departamento']. "' value='".$row_dropdown_departamento['Nome_Departamento']."' > " .$row_dropdown_departamento['Nome_Departamento']. " </option>";
								}
							?>
										</select>
										
										<button type="submit" name="submit" class="btn btn-dark">
										    <i class="fa fa-search"></i>
										    
										</button>
										
								</form>

							<?php


								$selected_val = $_POST['departamentos'];  // Storing Selected Value In Variable
								}



								if($selected_val_escola){
									$sql = "select
									        salas.Id_sala,
									        salas.Numero_Sala,
											estados_salas.estado,
											departamentos.Nome_Departamento,
											escolas.Nome_Escola
											from salas, estados_salas, departamentos, escolas 
											where salas.EstadoId = estados_salas.EstadoSalaId 
											and departamentos.Id_Departamento = salas.DepartamentoId 
											and escolas.Nome_Escola = '".$selected_val_escola."' 
											and departamentos.escolaId = escolas.Id_Escola
											order by Numero_Sala";

								}elseif($selected_val){
										$sql = "select 
										    salas.Id_sala,
										    salas.Numero_Sala,
											estados_salas.estado,
											departamentos.Nome_Departamento,
											escolas.Nome_Escola
											from salas, estados_salas, departamentos, escolas 
											where salas.EstadoId = estados_salas.EstadoSalaId 
											and departamentos.Id_Departamento = salas.DepartamentoId 
											and departamentos.Nome_Departamento = '".$selected_val."' 
											and departamentos.escolaId = escolas.Id_Escola
											order by Numero_Sala";


								}elseif($selected_val_escola and $selected_val){
									$sql = "select 
									        salas.Id_sala,
									        salas.Numero_Sala,
											estados_salas.estado,
											departamentos.Nome_Departamento,
											escolas.Nome_Escola
											from salas, estados_salas, departamentos, escolas 
											where salas.EstadoId = estados_salas.EstadoSalaId 
											and departamentos.Id_Departamento = salas.DepartamentoId 
											and departamentos.Nome_Departamento = '".$selected_val."'
											and escolas.Nome_Escola = '".$selected_val_escola."'
											and departamentos.escolaId = escolas.Id_Escola
											order by Numero_Sala";


								}else{
								    $sql = "select 
								            salas.Id_sala,
								            salas.Numero_Sala,
											estados_salas.estado,
											departamentos.Nome_Departamento,
											escolas.Nome_Escola
											from salas, estados_salas, departamentos, escolas 
											where salas.EstadoId = estados_salas.EstadoSalaId 
											and departamentos.Id_Departamento = salas.DepartamentoId 
											and departamentos.escolaId = escolas.Id_Escola
											order by Numero_Sala";

								}

								$result = mysqli_query($conn, $sql);
								$resultCheck = mysqli_num_rows($result);
				
								if ($resultCheck > 0) {?>
								 		<div class="table-responsive">          
										  <table class="table center">
											<thead>
											  <tr>
												<th>Sala</th>
												<th>Estado</th>
												<th>Departamento</th>
												<th>Escola</th>
											  </tr>
											</thead>
											<tbody>							
									<?php
									while ($row = mysqli_fetch_assoc($result)): ?> 
										<tr>
											<td><a href="sala.php?numeroSala=<?php echo $row['Numero_Sala']?>&dep=<?php echo $row['Nome_Departamento']?>"><?= $row['Numero_Sala'] ?></a></td>
											<td><?= $row['estado']?></td>
											<td><?= $row['Nome_Departamento']?></td>
											<td><?= $row['Nome_Escola']?></td>
										</tr>
									<?php endwhile;?>
									
											</tbody>
									</table>
									</div>
										
									<?php
								} else { ?>
									<h2>Não Foram Encontrados Resultados!</h2>
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