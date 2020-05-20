<?php
	/* Credenciais de banco de dados. Supondo que você esteja executando o MySQL
	servidor com configuração padrão (usuário 'root' sem senha)*/
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'aps');
	 
	/* Tenta se conectar ao banco de dados MySQL */
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	// Checa conexão
	if($link === false){
		die("ERRO: Não é possível realizar a conexão. " . mysqli_connect_error());
	}
?>