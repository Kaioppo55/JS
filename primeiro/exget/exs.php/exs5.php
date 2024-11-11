<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de 10 Pessoas</title>
</head>

<body>
    <h1>Cadastro de 10 Pessoas</h1>

    <form method="post">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <h2>Pessoa <?php echo $i; ?></h2>
            <label for="nome<?php echo $i; ?>">Nome:</label>
            <input type="text" id="nome<?php echo $i; ?>" name="nome<?php echo $i; ?>" required><br><br>

            <label for="cidade<?php echo $i; ?>">Cidade:</label>
            <input type="text" id="cidade<?php echo $i; ?>" name="cidade<?php echo $i; ?>" required><br><br>

            <label for="idade<?php echo $i; ?>">Idade:</label>
            <input type="number" id="idade<?php echo $i; ?>" name="idade<?php echo $i; ?>" required><br><br>

            <label for="sexo<?php echo $i; ?>">Sexo:</label>
            <select id="sexo<?php echo $i; ?>" name="sexo<?php echo $i; ?>" required>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
            </select><br><br>
        <?php endfor; ?>

        <input type="submit" value="Cadastrar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vetores para armazenar os dados das pessoas
        $pessoas = [];

        // Coletando os dados de cada pessoa
        for ($i = 1; $i <= 10; $i++) {
            $nome = $_POST['nome' . $i];
            $cidade = $_POST['cidade' . $i];
            $idade = (int) $_POST['idade' . $i];
            $sexo = $_POST['sexo' . $i];

            // Armazenando os dados em um array associativo
            $pessoas[] = [
                'nome' => $nome,
                'cidade' => $cidade,
                'idade' => $idade,
                'sexo' => $sexo
            ];
        }

        // 1. Listagem de todos os nomes e idades
        echo "<h2>1. Lista de todas as pessoas cadastradas (Nome e Idade):</h2>";
        echo "<ul>";
        foreach ($pessoas as $pessoa) {
            echo "<li>Nome: " . $pessoa['nome'] . ", Idade: " . $pessoa['idade'] . "</li>";
        }
        echo "</ul>";

        // 2. Listagem de nomes de quem tem mais de 18 anos
        echo "<h2>2. Lista de pessoas com mais de 18 anos:</h2>";
        echo "<ul>";
        foreach ($pessoas as $pessoa) {
            if ($pessoa['idade'] > 18) {
                echo "<li>Nome: " . $pessoa['nome'] . "</li>";
            }
        }
        echo "</ul>";

        // 3. Contagem de pessoas do sexo masculino
        $masculino = 0;
        foreach ($pessoas as $pessoa) {
            if ($pessoa['sexo'] === 'Masculino') {
                $masculino++;
            }
        }
        echo "<h2>3. Total de pessoas do sexo masculino: $masculino</h2>";
    }
    ?>
</body>

</html>