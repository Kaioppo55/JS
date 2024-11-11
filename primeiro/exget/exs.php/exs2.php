<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada de 10 Números</title>
</head>
<body>
    <h1>Digite 10 números</h1>
    
    <form method="post">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <label for="numero<?php echo $i; ?>">Número <?php echo $i; ?>:</label>
            <input type="number" id="numero<?php echo $i; ?>" name="numero<?php echo $i; ?>" required><br><br>
        <?php endfor; ?>

        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numeros = [];
        $negativos = 0;
        $positivos = 0;
        $pares = 0;
        $impares = 0;

        // Coletando os números digitados
        for ($i = 1; $i <= 10; $i++) {
            $numero = (int)$_POST['numero' . $i];
            $numeros[] = $numero;

            // Contando negativos e positivos
            if ($numero < 0) {
                $negativos++;
            } elseif ($numero > 0) {
                $positivos++;
            }

            // Contando pares e ímpares
            if ($numero % 2 == 0) {
                $pares++;
            } else {
                $impares++;
            }
        }

        // Ordenando os números
        sort($numeros);

        // Exibindo os resultados
        echo "<h2>Resultados:</h2>";
        echo "<p>Quantidade de números negativos: $negativos</p>";
        echo "<p>Quantidade de números positivos: $positivos</p>";
        echo "<p>Quantidade de números pares: $pares</p>";
        echo "<p>Quantidade de números ímpares: $impares</p>";

        // Exibindo os números ordenados
        echo "<h3>Números em ordem crescente:</h3>";
        echo "<ul>";
        foreach ($numeros as $numero) {
            echo "<li>$numero</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
