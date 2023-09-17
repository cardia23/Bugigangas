<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_locatario = $_POST["nome_locatario"];
    $telefone_locatario = $_POST["telefone_locatario"];
    $data_emprestimo = isset($_POST["data_emprestimo"]) ? $_POST["data_emprestimo"] : null;
    $data_devolucao = isset($_POST["data_devolucao"]) ? $_POST["data_devolucao"] : null;
    

    // Verifica se os campos estão preenchidos
    if (empty($nome_locatario) || empty($telefone_locatario) || empty($data_emprestimo) || empty($data_devolucao)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Insere os dados na tabela de locatários
        $query_locatario = "INSERT INTO locatarios (nome, telefone) VALUES ('$nome_locatario', '$telefone_locatario')";

        if (mysqli_query($con, $query_locatario)) {
            // Obtém o ID do locatário recém-cadastrado
            $locatario_id = mysqli_insert_id($con);

            // Insere os dados na tabela de empréstimos
            $query_emprestimo = "INSERT INTO emprestimos (id_locatario, data_emprestimo, data_devolucao) VALUES ('$locatario_id', '$data_emprestimo', '$data_devolucao')";

            if (mysqli_query($con, $query_emprestimo)) {
                echo "Locatário e empréstimo cadastrados com sucesso!";
            } else {
                echo "Erro ao cadastrar empréstimo: " . mysqli_error($con);
            }
        } else {
            echo "Erro ao cadastrar locatário: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}
?>
