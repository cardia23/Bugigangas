<!DOCTYPE html>
<html>
<head>
    <title>Sistema Acadêmico - Bugigangas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        table {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php
    require_once "config.php";

    // Função para excluir um empréstimo
    function excluirEmprestimo($id_emprestimo) {
        global $con;

        // Exclui o empréstimo da tabela 'emprestimos'
        $delete_emprestimo_query = "DELETE FROM emprestimos WHERE id = '$id_emprestimo'";
        mysqli_query($con, $delete_emprestimo_query);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se foi acionado o botão de exclusão
        if (isset($_POST["excluir"])) {
            $id_emprestimo = $_POST["excluir"];
            excluirEmprestimo($id_emprestimo);
            echo "<div class='container'><div class='alert alert-success'>Empréstimo excluído com sucesso!</div></div>";
        } else {
            // Obtém os dados do formulário
            $nome = $_POST["nome"];
            $descricao_item = $_POST["descricao_item"];
            $nome_locatario = $_POST["nome_locatario"];
            $telefone_locatario = $_POST["telefone_locatario"];
            $data_emprestimo = $_POST["data_emprestimo"];
            $data_devolucao = $_POST["data_devolucao"];

            // Limpa os dados para evitar injeção de SQL
            $nome = mysqli_real_escape_string($con, $nome);
            $descricao_item = mysqli_real_escape_string($con, $descricao_item);
            $nome_locatario = mysqli_real_escape_string($con, $nome_locatario);
            $telefone_locatario = mysqli_real_escape_string($con, $telefone_locatario);

            // Insere o item na tabela 'itens'
            $insert_item_query = "INSERT INTO itens (nome, descricao) VALUES ('$nome', '$descricao_item')";
            mysqli_query($con, $insert_item_query);
            $id_item = mysqli_insert_id($con);

            // Insere o locatário na tabela 'locatarios'
            $insert_locatario_query = "INSERT INTO locatarios (nome_locatario, telefone) VALUES ('$nome_locatario', '$telefone_locatario')";
            mysqli_query($con, $insert_locatario_query);
            $id_locatario = mysqli_insert_id($con);

            // Insere o empréstimo na tabela 'emprestimos'
            $insert_emprestimo_query = "INSERT INTO emprestimos (id_item, id_locatario, data_emprestimo, data_devolucao) VALUES ('$id_item', '$id_locatario', '$data_emprestimo', '$data_devolucao')";
            mysqli_query($con, $insert_emprestimo_query);

            echo "<div class='container'><div class='alert alert-success'>Empréstimo registrado com sucesso!</div></div>";
        }
    }
    ?>

    <div class="container">
        <h1>Sistema Acadêmico - Bugigangas</h1>

        <form method="POST">
            <h2>Registrar Empréstimo</h2>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Item:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="mb-3">
                <label for="descricao_item" class="form-label">Descrição do Item:</label>
                <input type="text" class="form-control" id="descricao_item" name="descricao_item" required>
            </div>

            <div class="mb-3">
                <label for="nome_locatario" class="form-label">Nome do Locatário:</label>
                <input type="text" class="form-control" id="nome_locatario" name="nome_locatario" required>
            </div>

            <div class="mb-3">
                <label for="telefone_locatario" class="form-label">Telefone do Locatário:</label>
                <input type="text" class="form-control" id="telefone_locatario" name="telefone_locatario" required>
            </div>

            <div class="mb-3">
                <label for="data_emprestimo" class="form-label">Data de Empréstimo:</label>
                <input type="date" class="form-control" id="data_emprestimo" name="data_emprestimo" required>
            </div>

            <div class="mb-3">
                <label for="data_devolucao" class="form-label">Data de Devolução:</label>
                <input type="date" class="form-control" id="data_devolucao" name="data_devolucao" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <h2>Empréstimos</h2>

        <?php
        // Obtém todos os empréstimos da tabela 'emprestimos'
        $select_emprestimos_query = "SELECT emprestimos.id, itens.nome, locatarios.nome_locatario, emprestimos.data_emprestimo, emprestimos.data_devolucao FROM emprestimos JOIN itens ON emprestimos.id_item = itens.id JOIN locatarios ON emprestimos.id_locatario = locatarios.id";
        $result = mysqli_query($con, $select_emprestimos_query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th>ID</th><th>Item</th><th>Locatário</th><th>Data de Empréstimo</th><th>Data de Devolução</th><th></th></tr></thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["nome_locatario"] . "</td>";
                echo "<td>" . $row["data_emprestimo"] . "</td>";
                echo "<td>" . $row["data_devolucao"] . "</td>";
                echo "<td><form method='POST'><button type='submit' class='btn btn-danger' name='excluir' value='" . $row["id"] . "'>Excluir</button></form></td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='container'><div class='alert alert-danger'>Nenhum empréstimo encontrado.</div></div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
