<?php
require_once "config.php";

// Verifica se o ID do item foi fornecido
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Exclui o item do banco de dados
    $query = "DELETE FROM itens WHERE id = $id";

    if (mysqli_query($con, $query)) {
        echo "Item excluído com sucesso!";
    } else {
        echo "Erro ao excluir item: " . mysqli_error($con);
    }

    mysqli_close($con);
}

// Redireciona de volta para a página principal
header("Location: index.php");
exit();
?>
