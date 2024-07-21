<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Atraente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .box {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .inputBox {
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        #submit {
            width: 100%;
        }
        .btn-danger {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="box">
        <form method="post">
            <fieldset>
                <legend>Formulário</legend>
                <div class="form-group inputBox">
                    <input type="text" name="nomw" class="form-control inputUser" placeholder="Nome" required>
                </div>
                <div class="form-group inputBox">
                    <input type="email" name="email" class="form-control inputUser" placeholder="Email" required>
                </div>
                <div class="form-group inputBox">
                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control">
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Enviar</button>
            </fieldset>
        </form>
    </div>

    <?php
    // Configuração da conexão com o banco de dados
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bank', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nomw']) && isset($_POST['email'])) {
                $nomw = $_POST['nomw'];
                $email = $_POST['email'];

                $sql = $pdo->prepare("INSERT INTO clientes (gmail, nomw) VALUES (?, ?)");
                $sql->execute([$email, $nomw]);

            } 
        }

        if (isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];

            $sql = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
            $sql->execute([$delete_id]);

        }

        $sql = $pdo->prepare("SELECT * FROM clientes");
        $sql->execute();

        $fetchClientes = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Clientes Cadastrados</h2>";
        echo "<ul class='list-group'>";
        foreach ($fetchClientes as $cliente) {
            echo "<li class='list-group-item'>";
            echo htmlspecialchars($cliente['nomw']) . " | " . htmlspecialchars($cliente['gmail']);
            echo "<form method='post' style='display:inline;'>";
            echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($cliente['id']) . "'>";
            echo "<button type='submit' class='btn btn-danger btn-sm'>Excluir</button>";
            echo "</form>";
            echo "</li>";
        }
        echo "</ul>";

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
