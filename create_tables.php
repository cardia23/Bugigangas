<?php
require_once "config.php";

// Cria a tabela 'locatarios'
$create_locatarios_table = "CREATE TABLE IF NOT EXISTS locatarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_locatario VARCHAR(255) NOT NULL,
    telefone VARCHAR(255) NOT NULL,
    data_emprestimo DATE DEFAULT NULL,
    data_devolucao DATE DEFAULT NULL
)";

mysqli_query($con, $create_locatarios_table);

// Cria a tabela 'itens'
$create_itens_table = "CREATE TABLE IF NOT EXISTS itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    status ENUM('disponivel', 'emprestado') DEFAULT 'disponivel'
)";

mysqli_query($con, $create_itens_table);

// Cria a tabela 'emprestimos'
$create_emprestimos_table = "CREATE TABLE IF NOT EXISTS emprestimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_item INT NOT NULL,
    id_locatario INT NOT NULL,
    data_emprestimo DATE DEFAULT NULL,
    data_devolucao DATE DEFAULT NULL,
    FOREIGN KEY (id_item) REFERENCES itens(id),
    FOREIGN KEY (id_locatario) REFERENCES locatarios(id)
)";

mysqli_query($con, $create_emprestimos_table);
?>
