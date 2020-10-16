	<?php
		include_once 'includes/dbh.inc.php';
		session_start();	
		date_default_timezone_set('Europe/Lisbon');

		error_reporting(0);

		//itens por pagina
		$itens_por_pagina = 2;


		$pagina = intval($_GET['pagina']);

		//numero total de registos
		
		$query_aulas = "select
								Aulas.Id_Aula,
								Professores.Nome_Professor,
								Disciplinas.Nome_Disciplina,
								Aulas.Hora_Inicio,
								Aulas.Hora_Fim,
								Aulas.EstadoId as estadoAula,
								salas.Numero_Sala,
								cursos.Nome_Curso,
								salas.EstadoId as estadoSala,
								professores.estadoId as estadoProfessor
								from aulas, professores, disciplinas, salas, cursos
								where Aulas.ProfessorId = Professores.Id_Professor
								and Aulas.DisciplinaId = Disciplinas.Id_Disciplina
								and Aulas.SalaId = Salas.Id_Sala 
								and Disciplinas.CursoId = Cursos.Id_Curso;";

		$result_numero_linhas = mysqli_query($conn, $query_aulas);
		$numero_registos = mysqli_num_rows($result_numero_linhas);

	?>



	<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Páginal Inicial</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg" />
  <style>
		<?php include 'css/estilo.css'; ?>
  </style>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  
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
		  	
	           $nome = "select Nome_Aluno from alunos, users where alunos.Id_Aluno = users.AlunoId and Id_User = " .$_SESSION['aluno'];" "; 
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


						
					<div class="jumbotron" style="background-color: #5db3de;">
					  <div class="container">
					    <h1 class="display-4">Instituto Politécnico da Guarda</h1>
					    <p class="lead">Bem-vindo à plataforma digital do IPG.</p>
					  </div>
					</div>

			<div class="all-browsers article">

			  <h1>Salas de Aula</h1>

			  	<?php 

			  		$sql_dropdown = "Select departamentos.Nome_Departamento from departamentos";
			  		$result_dropdown = mysqli_query($conn, $sql_dropdown);


					$resultCheck_dropdown = mysqli_num_rows($result_dropdown);			 
					
							if ($resultCheck_dropdown > 0) {  ?>
								<form action="" method="post">
									   <label for="departamentos_label">Departamento:</label>
									   <select name="departamentos" id="departamentos">
									   <option id="padrão" value="0" name="departamento">----</option>
							<?php

								while ($row_dropdown = mysqli_fetch_assoc($result_dropdown)){ 
										echo "<option id='" .$row_dropdown['Nome_Departamento']. "' value='".$row_dropdown['Nome_Departamento']."' > " .$row_dropdown['Nome_Departamento']. " </option>";
									
						
								}
							?>
										</select>
										<input type="submit" name="submit" value="Submit" />
								</form>

							<?php


								$selected_val = $_POST['departamentos'];  // Storing Selected Value In Variable
								}
							?>
										  
				<?php
					//query principal das salas de aulas 


						if ($selected_val){

							$sql = "select
							aulas.Id_Aula,
							professores.Nome_Professor,
							disciplinas.Nome_Disciplina,
							disciplinas.Ano,
							aulas.Hora_Inicio,
							aulas.Hora_Fim,
							aulas.EstadoId as estadoAula,
							salas.Numero_Sala,
							cursos.Nome_Curso,
							salas.EstadoId as estadoSala,
							professores.estadoId as estadoProfessor,
	                        departamentos.Nome_Departamento
							from aulas, professores, disciplinas, salas, cursos, departamentos
							where aulas.ProfessorId = professores.Id_Professor
							and aulas.DisciplinaId = disciplinas.Id_Disciplina
							and aulas.SalaId = salas.Id_Sala 
							and disciplinas.CursoId = cursos.Id_Curso
	                        and departamentos.Id_Departamento = salas.DepartamentoId
	                        and departamentos.Nome_Departamento = '".$selected_val. "'
	                        and SUBSTRING_INDEX(Hora_Inicio, ' ', 1) = DAYNAME(curdate())";/*
	                        LIMIT " . $itens_por_pagina . ", " . $numero_registos . ";";*/
							

						}else{

							$sql = "select
								aulas.Id_Aula,
								professores.Nome_Professor,
								disciplinas.Nome_Disciplina,
								disciplinas.Ano,
								aulas.Hora_Inicio,
								aulas.Hora_Fim,
								aulas.EstadoId as estadoAula,
								salas.Numero_Sala,
								cursos.Nome_Curso,
								salas.EstadoId as estadoSala,
								professores.estadoId as estadoProfessor
								from aulas, professores, disciplinas, salas, cursos
								where aulas.ProfessorId = professores.Id_Professor
								and aulas.DisciplinaId = disciplinas.Id_Disciplina
								and aulas.SalaId = salas.Id_Sala 
								and disciplinas.CursoId = cursos.Id_Curso 
								and SUBSTRING_INDEX(Hora_Inicio, ' ', 1) = DAYNAME(curdate())";/*
								LIMIT " . $itens_por_pagina . ", " . $numero_registos . ";*/
							
						}

					
					$result = mysqli_query($conn, $sql);
					$resultCheck =  mysqli_num_rows($result);
					
					  
					
							if ($resultCheck > 0) {
								while ($row = mysqli_fetch_assoc($result)){ 

											$id_aula = 	$row['Id_Aula'];
											$hora_inicio = strtotime($row['Hora_Inicio']); //45445484
											$hora_fim = strtotime($row['Hora_Fim']); //45878154

											$hora_date = date_create(strtotime($row['Hora_Fim']));



											$hora_inicio_convertida = date("l G:i", $hora_inicio);
											$hora_fim_convertida = date("l G:i", $hora_fim);



											$data_atual = date("l G:i", time());

											$dia_atual = date("l", time());




											$hora_atual = date_format(time(),"G:i A");



											



											$hora_fim_hora_convertida = date_format($hora_fim,"G:i A");

											
											$endTime = strtotime("+15 minutes", $hora_fim);

											$end_time = date_format($end_time, 'G:i A');								


											/*echo("Hora_fim:" . $hora_fim. "\n");
											echo("c/ Intervalo" . $endTime. "\n");
											echo ("hora_atual" .time());*/

											
											/*print($hora_inicio_convertida);
											print($hora_fim_convertida);*/
											//print($data_atual);

						



											
											/*$minutes_to_add = 15;

											$tempo_intervalo = date_add($hora_date, new DateInterval('PT' . $minutes_to_add . 'M'));

											echo date_format($tempo_intervalo,"G:i");*/

										//Atualiza o estado das aulas
											if (($data_atual >= $hora_inicio_convertida) and ($data_atual <= $hora_fim_convertida)){
												$sql_update = "update aulas set EstadoId = 1 where Id_Aula = '".$id_aula."';";

											} else {
												$sql_update = "update aulas set EstadoId = 2 where Id_Aula = '".$id_aula."' ";
												$sql_update_professor = "update professores, aulas set professores.EstadoId = 2 where aulas.ProfessorId = professores.Id_Professor and aulas.Id_Aula = '".$id_aula."';";
											}

											//executar a query
											if ($conn->query($sql_update) === TRUE) {}
											if ($conn->query($sql_update_professor) === TRUE) {}


										?>
										
											<?php


									if (($data_atual >= $hora_inicio_convertida) and ($data_atual < $hora_fim_convertida)){ ?>
											<?php
												//fundo verde
												if (($row['estadoSala'] == 1) and ($row['estadoProfessor'] == 1) and ($row['estadoAula'] == 1)){ 

											?>
												<article class='browser' style="background-color: #51e823 ">						
															<h2 class='Nome-Disciplina'><?= $row['Nome_Disciplina']?></h2>
															<h2 class='Nome-Disciplina'>Ano: <?= $row['Ano']?>º</h2>
															<h2 class='Nome-Disciplina'>Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'>Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Professor']?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Curso']?></h2>						
															<span class='NumeroSala'>
																<h1><?= $row['Numero_Sala']?></h1>
															</span>
														</article> 

											<?php
												//fundo amarelo
												} elseif (($row['estadoSala'] == 1) and ($row['estadoProfessor'] == 2) and ($row['estadoAula'] == 1)){ ?>
												 		<article class='browser' style="background-color: #e8e523 ">						
															<h2 class='Nome-Disciplina'><?= $row['Nome_Disciplina']?></h2>
															<h2 class='Nome-Disciplina'>Ano: <?= $row['Ano']?>º</h2>
															<h2 class='Nome-Disciplina'>Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'>Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Professor']?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Curso']?></h2>						
															<span class='NumeroSala'>
																<h1><?= $row['Numero_Sala']?></h1>
															</span>
														</article> 
											<?php
												} 
													

										}else{
											//fundo vermelho
											if (time() >= $hora_fim and time() <= $endTime){?>
											<article class='browser' style="background-color: #b8341a ">
														<h2 class='Nome-Disciplina'><?= $row['Nome_Disciplina']?></h2>
															<h2 class='Nome-Disciplina'>Ano: <?= $row['Ano']?>º</h2>
															<h2 class='Nome-Disciplina'>Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'>Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Professor']?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Curso']?></h2>						
															<span class='NumeroSala'>
																<h1><?= $row['Numero_Sala']?></h1>
															</span>
											</article>
										<?php										 
										}else{											
											//fundo cinzento ?>
											<article class='browser' style="background-color: #a1a1a1">
												<h2 class='Nome-Disciplina'><?= $row['Nome_Disciplina']?></h2>
															<h2 class='Nome-Disciplina'>Ano: <?= $row['Ano']?>º</h2>
															<h2 class='Nome-Disciplina'>Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'>Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Professor']?></h2>
															<h2 class='Nome-Disciplina'><?= $row['Nome_Curso']?></h2>						
															<span class='NumeroSala'>
																<h1><?= $row['Numero_Sala']?></h1>
															</span>
											</article>
										<?php
											}
										}										
								?>						
							<?php
							}
						  	?>




						  	<div class="paginacao">
						  	<nav aria-label="Navegação de página exemplo" >
							  <ul class="pagination">
							    <li class="page-item">
							      <a class="page-link" href="projetoFinal.php?pagina=0" aria-label="Anterior">
							        <span aria-hidden="true">&laquo;</span>
							        <span class="sr-only">Anterior</span>
							      </a>
							    </li>

							    <?php

							    	$num_paginas = ceil($resultCheck/$itens_por_pagina);

							    	for($i=0;$i<$num_paginas;$i++){

							    		$estilo ="";

								    	if ($pagina == $i){
								    		$estilo = "class\"active\"";
								    	} ?>

								    		<li <?php echo $estilo; ?>class="page-item"><a class="page-link" href="projetoFinal.php?pagina=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
								    		
							    	<?php 
							    	}

							    	?>
							    
							    <li class="page-item">
							      <a class="page-link" href="projetoFinal.php?pagina=<?php echo $num_paginas-1; ?>" aria-label="Próximo">
							        <span aria-hidden="true">&raquo;</span>
							        <span class="sr-only">Próximo</span>
							      </a>
							    </li>
							  </ul>
							</nav>
							</div>

						  	<?php
								}else{
									echo "<h3>Não foram encontrados resultados!</h3>";
								}
							?>	
								
			 
			</div>

			



			<!--Carousel-->
		
			<!--
				<div class="legenda">
					<div style="text-align: center">					
						<div id="demo" class="carousel slide" data-ride="carousel">
						  <div class="carousel-inner">
							<div class="carousel-item active">
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, Los Angeles!</p>
					        </div>   
							</div>
							<div class="carousel-item">
							 
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, Chicago!</p>
					        	</div>  
							</div>
							<div class="carousel-item">
							  
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, New York!</p>
					        </div>  
							</div>
							<div class="carousel-item">
							  
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, IPG!</p>
					        </div>
							</div>
						  </div>
						</div>
					</div>

				</div>

			-->

				<div class="rodape">
					<div style="text-align: center">					
						<div id="demo" class="carousel slide" data-ride="carousel">
						  <ul class="carousel-indicators">
							<li data-target="#demo" data-slide-to="0" class="active"></li>
							<li data-target="#demo" data-slide-to="1"></li>
							<li data-target="#demo" data-slide-to="2"></li>
							<li data-target="#demo" data-slide-to="3"></li>
						  </ul>
						  <div class="carousel-inner">
							<div class="carousel-item active">
							  <img src="img/banner.png" alt="Los Angeles" width="100" height="50">
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, Los Angeles!</p>
					        </div>   
							</div>
							<div class="carousel-item">
							  <img src="img/2.jpg" alt="Chicago" width="100" height="50">
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, Chicago!</p>
					        	</div>  
							</div>
							<div class="carousel-item">
							  <img src="img/3.jpg" alt="New York" width="100" height="50">
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, New York!</p>
					        </div>  
							</div>
							<div class="carousel-item">
							  <img src="img/4.jpg" alt="Instituto Politécnico da Guarda" width="100" height="50">
							  <div class="carousel-caption">
						        <h3>Chicago</h3>
						        <p>Thank you, IPG!</p>
					        </div>
							</div>
						  </div>
						  	<a class="carousel-control-prev bg-dark" href="#demo" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
							</a>
						  	<a class="carousel-control-next bg-dark" href="#demo" data-slide="next">
								<span class="carousel-control-next-icon"></span>
						  	</a>
						</div>
					</div>
						
				</div>

			<div class="footer">
				<p>&copy; 2020 - Sistema de Horários</p>
			</div>	
			
			
	</body> 
	</html>