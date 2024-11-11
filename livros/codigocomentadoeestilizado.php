<?php
// Inicia a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ?page=login");
    exit;
}


// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'biblioteca';
$user = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


// Variáveis iniciais
$codigo = $nome = $autor = $editora = $ano = $busca = '';
$modoEdicao = false;


// Processamento de Formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    $nome = $_POST['nome'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $ano = $_POST['ano'];


    if ($_POST['acao'] == 'salvar') {
        if (isset($_POST['codigo']) && $_POST['codigo'] !== '') {
            $codigo = $_POST['codigo'];
            $stmt = $pdo->prepare('UPDATE livros SET nome = ?, autor = ?, editora = ?, ano = ? WHERE codigo = ?');
            $stmt->execute([$nome, $autor, $editora, $ano, $codigo]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO livros (nome, autor, editora, ano) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nome, $autor, $editora, $ano]);
        }


        $codigo = $nome = $autor = $editora = $ano = '';
        $modoEdicao = false;
    } elseif ($_POST['acao'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];


        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();


        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ?page=catalogo");
            exit;
        } else {
            $error = "Nome de usuário ou senha incorretos.";
        }
    }
}


// Processamento de Exclusão
if (isset($_GET['excluir'])) {
    $codigo = $_GET['excluir'];
    $stmt = $pdo->prepare('DELETE FROM livros WHERE codigo = ?');
    $stmt->execute([$codigo]);
}


// Carregamento dos dados para edição
if (isset($_GET['editar'])) {
    $codigo = $_GET['editar'];
    $stmt = $pdo->prepare('SELECT * FROM livros WHERE codigo = ?');
    $stmt->execute([$codigo]);
    $livro = $stmt->fetch();


    $nome = $livro['nome'];
    $autor = $livro['autor'];
    $editora = $livro['editora'];
    $ano = $livro['ano'];
    $modoEdicao = true;
}


// Busca de livros
if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
    $stmt = $pdo->prepare('SELECT * FROM livros WHERE nome LIKE ? OR autor LIKE ? OR editora LIKE ? OR ano LIKE ?');
    $stmt->execute(["%$busca%", "%$busca%", "%$busca%", "%$busca%"]);
} else {
    $stmt = $pdo->query('SELECT * FROM livros');
}
$livros = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { width: 80%; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1, h2 { text-align: center; }
        form { display: flex; flex-direction: column; }
        label, input { margin-bottom: 10px; }
        input[type="text"], input[type="number"], input[type="password"] { padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"], button { padding: 10px; font-size: 16px; color: white; background-color: #28a745; border: none; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover, button:hover { background-color: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f8f8; }
        .actions a { margin-right: 10px; }
        .search-container { text-align: right; margin-bottom: 20px; }
        .search-container input { padding: 6px; border-radius: 4px; border: 1px solid #ccc; }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_GET['page']) && $_GET['page'] == 'login'): ?>
        <!-- Página de Login -->
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form action="" method="post">
            <input type="hidden" name="acao" value="login">
            <label>Usuário:</label>
            <input type="text" name="username" required>
            <label>Senha:</label>
            <input type="password" name="password" required>
            <button type="submit">Entrar</button>
        </form>
    <?php else: ?>
        <!-- Página de Catálogo -->
        <h1>Catálogo de Livros</h1>
        <a href="?page=login&logout=true">Logout</a>


        <!-- Formulário de Busca -->
        <div class="search-container">
            <form action="" method="get">
                <input type="text" name="busca" placeholder="Buscar livro..." value="<?= $busca ?>">
                <input type="submit" value="Buscar">
            </form>
        </div>


        <!-- Formulário de Inclusão/Edição -->
        <h2><?= $modoEdicao ? 'Editar Livro' : 'Incluir Livro' ?></h2>
        <form action="" method="post">
            <input type="hidden" name="codigo" value="<?= $codigo ?>">
            <input type="hidden" name="acao" value="salvar">
            <label for="nome">Nome do Livro:</label>
            <input type="text" name="nome" value="<?= $nome ?>" required>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" value="<?= $autor ?>" required>
            <label for="editora">Editora:</label>
            <input type="text" name="editora" value="<?= $editora ?>" required>
            <label for="ano">Ano:</label>
            <input type="number" name="ano" value="<?= $ano ?>" required>
            <input type="submit" value="<?= $modoEdicao ? 'Salvar Alterações' : 'Incluir Livro' ?>">
        </form>


        <!-- Tabela de livros cadastrados -->
        <h2>Livros Cadastrados</h2>
        <table>
            <thead>
            <tr>
                <th>Nome</th>
                <th>Autor</th>
                <th>Editora</th>
                <th>Ano</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($livros as $livro): ?>
                <tr>
                    <td><?= $livro['nome'] ?></td>
                    <td><?= $livro['autor'] ?></td>
                    <td><?= $livro['editora'] ?></td>
                    <td><?= $livro['ano'] ?></td>
                    <td class="actions">
                        <a href="?editar=<?= $livro['codigo'] ?>">Editar</a>
                        <a href="?excluir=<?= $livro['codigo'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>


<?php
// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}
?>

