<?php
	$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
	$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

	$_SG['caseSensitive'] = true;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

	$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
	// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

//	$_SG['servidor'] = 'localhost';    // Servidor MySQL
//	$_SG['usuario'] = 'root';          // Usuário MySQL
//	$_SG['senha'] = '';       			// Senha MySQL 
//	$_SG['banco'] = 'mydb';            // Banco de dados MySQL

	@$url = $_SERVER['HTTP_HOST'];

	$_SG['paginaLogin'] = 'http://'.$url.'/Peixao/index.php'; // Página de login
