<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiplicação de Vetor</title>
</head>
<body>
    <h1>Digite 10 números e multiplique todos por um valor</h1>
    
    <form method="post">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <label for="numero<?php echo $i; ?>">Número <?php echo $i; ?>:</label>
            <input type="number" id="numero<?php echo $i; ?>" name="numero<?php echo $i; ?>" required><br><br>
        <?php endfor; ?>

        <label for="multiplicador">Digite um número para multiplicar todos os valores:</label>
        <input type="number" id="multiplicador" name="multiplicador" required><br><br>

        <input type="submit" value="Multiplicar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numeros = [];
        $multiplicador = (int)$_POST['multiplicador'];

        // Coletando os números digitados
        for ($i = 1; $i <= 10; $i++) {
            $numero = (int)$_POST['numero' . $i];
            $numeros[] = $numero;
        }

        // Exibindo os números multiplicados
        echo "<h2>Resultados da multiplicação:</h2>";
        echo "<ul>";
        foreach ($numeros as $numero) {
            $resultado = $numero * $multiplicador;
            echo "<li>$numero x $multiplicador = $resultado</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
