<?php
		include_once 'includes/dbh.inc.php';
		session_start();	
		date_default_timezone_set('Europe/Lisbon');
?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Página Query</title>
	</head>
		<body>
			<h1>Página das Queries</h1>
		<?php

			$numero_do_cartao = "290D7548";
			$sala = "42";

			$sql="select AlunoId, ProfessorId
			from users
			where RFID = '".$numero_do_cartao."';";

			$result = mysqli_query($conn, $sql);
			$resultCheck =  mysqli_num_rows($result);

			if ($resultCheck > 0) {
		
					?>		
						<h1>Alunos / Professores Encontrados</h1>
					<?php
							while ($row = mysqli_fetch_assoc($result)){
								$id_aluno =	$row['AlunoId'];
								$id_professor = $row['ProfessorId'];

					?>
							<h2>Professor: <?= $row['ProfessorId']?></h2>
							<h2>Aluno: <?= $row['AlunoId']?></h2>
					<?php
					}


						if($id_aluno != null){

							?>
							
							<h2>O Id do Aluno não é nulo</h2>
						<?php

							$sql_aulas = "select Id_Aluno, Id_Aula
									 from aulas, alunos, users, inscricoes, disciplinas, salas
									 where aulas.DisciplinaId = disciplinas.Id_Disciplina 
									 and inscricoes.DisciplinaId =disciplinas.Id_Disciplina 
									 and alunos.UserId = users.Id_User
									 and DATE_FORMAT(SYSDATE() + 10000, '%H:%i') > DATE_FORMAT(STR_TO_DATE(SUBSTRING(Hora_Inicio, -5, 5), '%H:%i'), '%H:%i') 
									 and DATE_FORMAT(SYSDATE() + 10000, '%H:%i') < DATE_FORMAT(STR_TO_DATE(SUBSTRING(Hora_Fim, -5, 5), '%H:%i'), '%H:%i') 
									 and substring_index(hora_inicio,' ',1) = date_format(sysdate(),'%W') 
									 and salas.Id_Sala = aulas.SalaId
									 and RFID = '".$numero_do_cartao."'
									 and Numero_Sala = '".$sala."';";

					
					$result_aulas = mysqli_query($conn, $sql_aulas);
					$resultCheck_aulas =  mysqli_num_rows($result_aulas);
					
					  
					
							if ($resultCheck > 0) {
								while ($row_aulas = mysqli_fetch_assoc($result_aulas)){ 

											$id_aula = 	$row_aulas['Id_Aula'];
											$id_aluno_aula = $row_aulas['Id_Aluno'];
														
								}
														

								?>
														<h2>Dados do Aluno</h2>
														<h2>Id_Aula: <?= $id_aula?></h2>
														<h2>Id_Aluno: <?= $id_aluno_aula?></h2>
								<?php




								$sql_presenca_marcada = "select Data_chegada
														from presencas, users, alunos														
														where Data_chegada = CURDATE()
                                                        and presencas.AlunoId = alunos.Id_Aluno
														and alunos.UserId = users.Id_User
														and presencas.AulaId = '".$id_aula."'														
														and presencas.AlunoId = '".$id_aluno."';";
							


								$result_pesquisa_presenca = mysqli_query($conn, $sql_presenca_marcada);
								$resultCheck_pesquisa_presenca =  mysqli_num_rows($result_pesquisa_presenca);

								if($resultCheck_pesquisa_presenca > 0){
					?>
														<h1>Já tem presença marcada</h1>
														
					<?php
								$Led_Vermelho = 1;
								}else{ //senao, marca presenca

									$sql_presenca_insert = "insert into presencas(Data_chegada, AlunoId, AulaId) values (CURDATE(), '".$id_aluno."', '".$id_aula."');";
									if ($conn->query($sql_presenca_insert) === TRUE) {}
									$Led_Azul = 1;
					?>				<h1>Presença marcada</h1>
					<?php
								}


							} else{
								?>
														<h1>Não Foram Encontradas Aulas do Aluno <?= $row['Id_Aluno']?></h1>
														
							<?php

							}
									
							}else if($id_professor != null){?>
							
							<h2>O Id do Professor não é nulo</h2>

						<?php

							$sql_aulas_professores = "select Id_Professor, Id_Aula
												 from aulas, users, salas, professores
												 where professores.Id_Professor = aulas.ProfessorId 
												 and professores.UserId = users.Id_User
												 and salas.Id_Sala = aulas.SalaId
												 and DATE_FORMAT(SYSDATE() + 10000, '%H:%i') > DATE_FORMAT(STR_TO_DATE(SUBSTRING(Hora_Inicio, -5, 5), '%H:%i'), '%H:%i') 
												 and DATE_FORMAT(SYSDATE() + 10000, '%H:%i') < DATE_FORMAT(STR_TO_DATE(SUBSTRING(Hora_Fim, -5, 5), '%H:%i'), '%H:%i') 
												 and substring_index(hora_inicio,' ',1) = date_format(sysdate(),'%W') 
												 and RFID = '".$numero_do_cartao."'
												 and Numero_Sala = '".$sala."';";
									 

					
					$result_aulas_professores = mysqli_query($conn, $sql_aulas_professores);
					$resultCheck_aulas_professores =  mysqli_num_rows($result_aulas_professores);
					
					  
					
							if ($resultCheck_aulas_professores > 0) {
								while ($row_aulas_professores = mysqli_fetch_assoc($result_aulas_professores)){ 

											$id_aula = $row_aulas_professores['Id_Aula'];
											$id_aula_professor = $row_aulas_professores['Id_Professor'];
														
								}
														

								?>
														<h2>Dados do Aluno</h2>
														<h2>Id_Aula: <?= $id_aula?></h2>
														<h2>Id_Professor: <?= $id_aula_professor?></h2>
								<?php

							$sql_professor = "update professores
												set EstadoId = 1
												where professores.Id_professor = '".$id_professor."';";
							//executar a query
							if ($conn->query($sql_professor) === TRUE) {}
								


							}


						?>	
								<h1>Estado do Professor Atualizado!</h1>
						
					<?php

						
					}else{
					?>	
						<h1>Não foram Encontrados Resultados!</h1>
						
					<?php
					}
				}

					?>
		</body>
	</html>