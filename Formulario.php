<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Formulário de Contato</title>
    
    <style>
        body {
            background: linear-gradient(to bottom right, #4B0082, #DC143C);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container-blur {
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 600px;
            text-align: center;
            margin-top: 20px;
        }

        .form-group {
            text-align: left;
        }

        .form-control {
            background-color: rgba(50, 50, 50, 0.5);
            color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            border: 2px solid gray;
            padding: 15px;
            width: 150px;
            transition: width 0.5s, background-color 0.4s;
            margin-left: 15px;
        }

        .form-control.hovered,
        .form-control.filled {
            width: 540px; /* Largura expandida quando a classe é adicionada */
        }

        .form-control:hover {
            background-color: rgba(100, 100, 100, 0.9);
        }

        .btn {
            width: 100%;
        }

        footer {
            text-align: center;
            margin-top: 30px;
        }

        .footer-images img {
            width: 110px;
            margin: 0 10px;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            overflow-y: auto;
            width: 100%;
        }

        /* Ajuste para a tabela */
        table {
            width: 100%; /* Define a largura da tabela para ocupar todo o espaço disponível */
        }

        th, td {
            text-align: center; /* Centraliza o conteúdo das células */
            overflow: hidden; /* Oculta conteúdo que excede a largura da célula */
            white-space: nowrap; /* Impede quebra de linha dentro da célula */
            text-overflow: ellipsis; /* Adiciona reticências se o texto for muito longo */
        }
    </style>
</head>
<body>
<?php
session_start();

// Tratamento de submissão do formulário e ações de deletar/limpar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['limpar'])) {
        $_SESSION['registros'] = [];
    } elseif (isset($_POST['deletar'])) {
        $index = (int)$_POST['index'];
        if (isset($_SESSION['registros'][$index])) {
            unset($_SESSION['registros'][$index]);
            $_SESSION['registros'] = array_values($_SESSION['registros']); // Reindexar o array
        }
    } else {
        $nome = htmlspecialchars($_POST['nome'] ?? '');
        $telefone = htmlspecialchars($_POST['telefone'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');

        $_SESSION['registros'][] = [
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email
        ];
    }
}
?>

<header>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="img/MexicuLindo.png" style="width: 110px">
        <h1 style="font-family: Courier New, monospace; font-size: 25px; margin-top: 10px;">Mexico Hermoso</h1>
    </div>
</header>

<div class="content-wrapper">
    <div class="container-blur">
        <h1>Formulário de Contato</h1>
        <form id="contactForm" method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
                <small id="erroNome" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
                <small id="erroTelefone" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                <small id="erroEmail" class="text-danger"></small>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="submit" name="limpar" class="btn btn-danger mt-2">Limpar Registros</button>
        </form>
    </div>

    <div class="container-blur mt-5">
        <h2>Registros Enviados</h2>
        <?php if (empty($_SESSION['registros'])): ?>
            <p>Nenhum registro encontrado.</p>
        <?php else: ?>
            <table class="table table-bordered table-dark mt-3">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['registros'] as $index => $registro): ?>
                        <tr>
                            <td><?= htmlspecialchars($registro['nome']) ?></td>
                            <td><?= htmlspecialchars($registro['telefone']) ?></td>
                            <td><?= htmlspecialchars($registro['email']) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" name="deletar" class="btn btn-danger">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<footer>
    <hr>
    Todos os direitos reservados &copy; Mexicu Lindo e Restaurantes
    <div class="footer-images mt-2">
        <img src="https://www.scuadra.com.br/blog/wp-content/uploads/2018/11/guiamichelin-1050x580-1-810x447.jpg?x97018">
        <img src="https://logospng.org/download/masterchef/masterchef-512.png">
        <img src="https://logodownload.org/wp-content/uploads/2017/03/inmetro-logo-18.png" style="width: 150px;">
    </div>
</footer>

<script>
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('mouseover', () => {
            input.classList.add('hovered');
        });
        input.addEventListener('mouseout', () => {
            if (!input.classList.contains('filled')) {
                input.classList.remove('hovered');
            }
        });
        input.addEventListener('input', () => {
            input.classList.add('filled');
        });
    });

    function validarFormulario() {
        document.getElementById("erroNome").textContent = "";
        document.getElementById("erroTelefone").textContent = "";
        document.getElementById("erroEmail").textContent = "";

        let nome = document.getElementById("nome").value.trim();
        let telefone = document.getElementById("telefone").value.trim();
        let email = document.getElementById("email").value.trim();
        let isValid = true;

        if (nome === "") {
            document.getElementById("erroNome").textContent = "Por favor, insira um nome.";
            isValid = false;
        }

        if (telefone === "" || !/^\d{10,11}$/.test(telefone)) {
            document.getElementById("erroTelefone").textContent = "Por favor, insira um telefone válido.";
            isValid = false;
        }

        if (email === "" || !/\S+@\S+\.\S+/.test(email)) {
            document.getElementById("erroEmail").textContent = "Por favor, insira um email válido.";
            isValid = false;
        }

        return isValid;
    }
</script>

</body>
</html>
