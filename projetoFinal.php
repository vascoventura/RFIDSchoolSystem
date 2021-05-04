<?php
	include_once 'includes/dbh.inc.php';
	session_start();
	date_default_timezone_set('Europe/Lisbon');
	
	//itens por pagina
		$itens_por_pagina = 3; 

    $pagina = $_GET['pagina'];

		if(isset($_GET['pagina'])){
		    
		}else{
			$pagina = 1;

		}
		

		//numero total de registos
		
		$query_aulas = "select
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
	                        and SUBSTRING_INDEX(Hora_Inicio, ' ', 1) = DAYNAME(curdate());";

		$result_numero_linhas = mysqli_query($conn, $query_aulas);
		$numero_registos = mysqli_num_rows($result_numero_linhas);

		$num_paginas = ceil($numero_registos/$itens_por_pagina);

		

		//calcular o inicio da visualização
		$inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;


		$registos = $inicio + $itens_por_pagina;
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Página Inicial</title>
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
<script src="https://kit.fontawesome.com/yourcode.js"></script>


 
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
						  <a class="nav-link" href="salas.php">Salas</a>
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

						
					<div class="jumbotron" style="background-color: #5db3de;">
					  <div class="container">
					    <h1 class="display-4">Instituto Politécnico da Guarda</h1>
					    <p class="lead">Bem-vindo à plataforma digital do IPG.</p>
					  </div>
					</div>

			<article class="all-browsers article">

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
										
										<button type="submit" name="submit" class="btn btn-dark">
										    <i class="fa fa-search"></i>
										    
										</button>
										
								</form>

							<?php


								$selected_val = $_POST['departamentos'];  // Storing Selected Value In Variable
								}
							?>
										  
				<?php
				
				    

					//query principal das salas de aulas de hoje 


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
							salas.Id_Sala,
							cursos.Nome_Curso,
							salas.EstadoId as estadoSala,
							professores.Id_Professor,
							professores.estadoId as estadoProfessor,
	                        departamentos.Nome_Departamento
							from aulas, professores, disciplinas, salas, cursos, departamentos
							where aulas.ProfessorId = professores.Id_Professor
							and aulas.DisciplinaId = disciplinas.Id_Disciplina
							and aulas.SalaId = salas.Id_Sala 
							and disciplinas.CursoId = cursos.Id_Curso
	                        and departamentos.Id_Departamento = salas.DepartamentoId
	                        and departamentos.Nome_Departamento = '".$selected_val. "'
	                        and SUBSTRING_INDEX(Hora_Inicio, ' ', 1) = DAYNAME(curdate())
	                        ORDER BY hora_inicio
	                        LIMIT $inicio,$itens_por_pagina;";
	                        

	                        
							

						}else{

							$sql = "select aulas.Id_Aula, professores.Nome_Professor, disciplinas.Nome_Disciplina, disciplinas.Ano, aulas.Hora_Inicio, aulas.Hora_Fim, aulas.EstadoId as estadoAula, salas.Numero_Sala, salas.Id_Sala, cursos.Nome_Curso, salas.EstadoId as estadoSala, professores.estadoId as estadoProfessor, professores.Id_Professor 
    							from aulas, professores, disciplinas, salas, cursos
    							where aulas.ProfessorId = professores.Id_Professor
    							and aulas.DisciplinaId = disciplinas.Id_Disciplina
    							and aulas.SalaId = salas.Id_Sala 
    							and disciplinas.CursoId = cursos.Id_Curso 
    							and SUBSTRING_INDEX(Hora_Inicio, ' ', 1) = DAYNAME(curdate())
    	                        LIMIT $inicio,$itens_por_pagina;";

							
							
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
											
											echo $hora_atual;

											$estado_sala = $row['estadoSala'];
											$id_sala = $row['Id_Sala'];
											$id_professor = $row['Id_Professor'];



											$hora_fim_hora_convertida = date_format($hora_fim,"G:i A");

											
											$endTime = strtotime("+15 minutes", $hora_fim);

											$end_time = date_format($end_time, 'G:i A');								

										//Atualiza o estado das aulas
											if (($data_atual >= $hora_inicio_convertida) and ($data_atual <= $hora_fim_convertida)){
												$sql_update = "update aulas set EstadoId = 1 where Id_Aula = '".$id_aula."';";

											}else{
												/*$sql_update = "update aulas set EstadoId = 2 where Id_Aula = '".$id_aula."' ";
												

												$sql_update_salas = "update salas set EstadoId = 2 where Id_Sala = '".$id_sala."';";
												
												$sql_update_professores = "update professores set EstadoId = 2 where Id_Professor = '".$id_professor."';"; */
											}
												
											

											//executar a query
											if ($conn->query($sql_update) === TRUE) {}
											if ($conn->query($sql_update_professores) === TRUE) {}
											if ($conn->query($sql_update_salas) === TRUE) {}


										?>
										
										<?php

									//ELABORAÇÃO DOS FUNDOS	


									//laranja

							if ($estado_sala == 3){  ?>
								<article class='browser' style="background-color: #f78934 ">						
									<h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>						
									<div class="NumeroSala">
										<h1><?= $row['Numero_Sala']?></h1>
									</div>
								</article> 

						<?php

							}else{


									if (($data_atual >= $hora_inicio_convertida) and ($data_atual < $hora_fim_convertida)) { ?>
											<?php
												//fundo verde
												if (($row['estadoSala'] == 1) and ($row['estadoProfessor'] == 1) and ($row['estadoAula'] == 1)){ 

											?>
												<article class='browser' style="background-color:#5fc960">			
                									<h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
                									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
                									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
                									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
                									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
                									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>		
                									<div class="NumeroSala">
                										<h1><?= $row['Numero_Sala']?></h1>
                									</div>
												</article> 

											<?php
												//fundo amarelo
												} elseif (($row['estadoSala'] == 2) and ($row['estadoProfessor'] == 2) and ($row['estadoAula'] == 1)) { 
											?>
												 		<article class='browser' style="background-color:#ede480">	
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
                        									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
                        									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>		
                        									<div class="NumeroSala">
                        										<h1><?= $row['Numero_Sala']?></h1>
                        									</div>
														</article> 
											<?php
												} else{
												    //fundo cinzento
													?>
												 		<article class='browser' style="background-color:#b8b6a7">	
                								<h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
                        									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
                        									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>		
                        									<div class="NumeroSala">
                        										<h1><?= $row['Numero_Sala']?></h1>
                        									</div>
														</article> 
													<?php

												}  
													

										}else if(time() >= $hora_fim){
											//fundo vermelho
											 ?>
											<article class='browser' style="background-color:#c95f5f">
											    <h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
                        									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
                        									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>		
                        									<div class="NumeroSala">
                        										<h1><?= $row['Numero_Sala']?></h1>
                        									</div>
											</article>
										<?php
										
										}else{

											//fundo cinzento ?>
											<article class='browser' style="background-color: #b8b6a7">
                									<h2 class="Nome-Disciplina"><?= $row['Nome_Disciplina']?></h2>
                        									<h2 class="Nome-Disciplina">Ano: <?= $row['Ano']?>º</h2>
                        									<h2 class="Nome-Disciplina">Hora Início: <?= substr($row['Hora_Inicio'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina">Hora de Fecho: <?= substr($row['Hora_Fim'], -5, 5)?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Professor']?></h2>
                        									<h2 class="Nome-Disciplina"><?= $row['Nome_Curso']?></h2>		
                        									<div class="NumeroSala">
                        										<h1><?= $row['Numero_Sala']?></h1>
                        									</div>
											</article>
	
										<?php
										}

									}


										}										
								?>						
							<?php
							}


							//Verificar a pagina anterior e posterior
							$pagina_anterior = $pagina - 1;
							$pagina_posterior = $pagina + 1;

						  	?>
                            
						  	<div class="paginacao">
						  	<nav aria-label="Navegação de página exemplo">
								<ul class="pagination">
							    	<?php
							    		if($pagina != 1){?>
							    			<li class="page-item">
								    			<a class="page-link" href="projetoFinal.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Anterior">
										        <span aria-hidden="true">&laquo;</span>
										        <span class="sr-only">Anterior</span>
									      		</a>
									      	</li>
							    <?php
							    		}
							    

							    	

							    	for($i=1; $i <= $num_paginas; $i++){
							    		$estilo ="";

								    	if ($pagina == $i){
								    		$estilo = "class\"active\"";
								    	} 
										?>

								    		<li <?php echo $estilo; ?>class="page-item">
								    			<a class="page-link" href="projetoFinal.php?pagina=<?php echo $i; ?>"><?php echo $i;?></a>
								    		</li>
								    		
							    	<?php 
							    	}

							    		if($pagina != $num_paginas){?>
							    			<li class="page-item">
								    			<a class="page-link" href="projetoFinal.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Seguinte">
										        <span aria-hidden="true">&raquo;</span>
										        <span class="sr-only">Seguinte</span>
									      		</a>
									      	</li>

						        <?php
						        	}
						    	?>
									    
							    
							    </ul>
							</nav>
							</div>
			</article>

				<div class="rodape">
					<div class="carrocel">					
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
								<div class="carousel-fundo">
							        <h3>Conceito P2B - Polytechnic To Business</h3>
							        <p>
							        	Polytechnic To Business – é a relação estreita e coesa entre a Instituição Politécnica e o tecido Empresarial. <br>

										Procura o desenvolvimento de ideias inovadoras com investigadores, profissionais e parceiros. <br>

										As competências politécnicas são inatas para a aplicação e desenvolvimento de projetos de âmbito empresarial, sejam eles despoletados numa perspetiva interna (spin offs) seja por iniciativa externa com colaboração do IP (start ups e/ou desenvolvimento de projetos). <br>
										<br>

										Os objetivos do P2B são: <br>
										• Promover a inovação; <br>
										• Estabelecer parceiras com o tecido empresarial; <br>
										• Promover o aparecimento de novos produtos / processo ou outros projetos; <br>
										• Efetivar a transferência do conhecimento aplicado ao mercado; <br>
										• Promover a criação de empresas. <br>
										<br>

										Neste sentido pretendem-se desenvolver uma série de ações que potenciem a relação P2B, em diferentes áreas de atividade, nomeadamente: <br>
										• Desenvolvimento e captação de Ideias – Lodging P2B; <br>
										• Transferência de I+DT – P2B Services; <br>
										• Aceleração e incubação de projetos de vocação empresarial - Policasulos; <br>
										• Desenvolvimento de competências empresariais feitas à medida - Boxes de Formação. <br>
									</p>
						        </div>   
							</div>
							<div class="carousel-item">
								<img src="img/rede.png" alt="Chicago" width="100" height="50">
								<div class="carousel-fundo">
							    	<h3>O que são os Cursos Técnicos Superiores Profissionais</h3>
							        <p>
							        	O Curso Técnico Superior Profissional (TeSP) criado pelo Decreto-Lei n.º 43/2014 de 18 de março, é uma formação de ensino superior politécnica, que confere uma qualificação de nível 5 do Quadro Nacional de Qualificações. O TeSP, não confere grau académico, atribuindo um “Diploma de Técnico Superior Profissional”. <br>

									Podem aceder aos TeSP: <br>
									» Os titulares de um curso de ensino secundário ou de habilitação legalmente equivalente; <br>
									» Os estudantes que tenham sido aprovados nas provas dos “maiores de 23 anos”, realizadas, para o curso em causa; <br>
									» Os titulares de um diploma de especialização tecnológica, de um diploma de técnico superior profissional ou de um grau de ensino superior, que pretendam a sua requalificação profissional. <br>
								</p>
						        </div>  
							</div>
							<div class="carousel-item">
								<img src="img/ipg.png" alt="Ipg" width="100" height="50">
								<div class="carousel-fundo" >
							    	<h3>Novo Plano Formação de Professores 2020</h3>
							        <p>
							        	Já se encontra disponível o catálogo formativo para educadores e professores dos ensinos básico e secundário. Este ano, o plano dispõe de 8 cursos de formação para educadores de infância e professores do 1.º ciclo do ensino básico. Para os docentes do 2.º, 3.º ciclos do ensino básico e secundário, são apresentados 10 cursos de formação. Todos os cursos têm a duração de 25 horas, atribuindo 1 crédito para a progressão em carreira. Não deixe de realizar a sua formação com valor!
										Para mais informações, consultar o site: http://www.ipg.pt/fcontinua
									</p>
						        </div>  
							</div>
							<div class="carousel-item">
								<img src="img/santader.png" alt="Santader" width="100" height="50">
								<div class="carousel-fundo">
							    	<h3>Santader</h3>
							        <p>
							        	Abre a tua conta à ordem sem custos <br>
										Conta à ordem sem comissão de manutenção até aos 25 anos <br>

										<br>

										Movimenta o teu dinheiro sem limites <br>
										Transferências para todos os bancos nacionais e europeus feitas pela App Santader gratuitas e ilimitadas <br>

	 									<br>
										Recebe o teu cartão de débito #Global U a custo zero <br>
										Cartão de débito sem comissão de disponibilização até 25 anos <br>

										<br>
										Usa o teu cartão de débito #Global U onde quiseres<br>
										Levantamentos e pagamentos no estrangeiro, até 1000€, sem custos<br>

										<br>
										Paga com o teu telemóvel<br>
									</p>
						        </div>
							</div>
							<a class="carousel-control-prev bg-dark" style="width: 40px; height: 40px; margin-top: 300px;" href="#demo" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
							</a>
						  	<a class="carousel-control-next bg-dark" style="width: 40px; height: 40px; margin-top: 300px;" href="#demo" data-slide="next">
								<span class="carousel-control-next-icon"></span>
						  	</a>
						</div>						  	
					</div>
				</div>
						
			</div>

			<div class="footer">
				<p>&copy; 2020 - Sistema de Horários</p>
			</div>	
			
			
	</body> 
	</html>