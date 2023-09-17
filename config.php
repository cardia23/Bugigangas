<?php
$servername = "**";
$username = "**";
$password = "**";
$database = "**";

// Cria a conexão com o banco de dados
$con = mysqli_connect($servername, $username, $password, $database);

// Verifica a conexão
if (!$con) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
