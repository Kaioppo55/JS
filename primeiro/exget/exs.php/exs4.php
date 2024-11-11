<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nome do Mês Correspondente</title>
</head>
<body>
    <h1>Digite um número para saber o nome do mês correspondente</h1>
    
    <form method="post">
        <label for="mes">Digite um número (1-12):</label>
        <input type="number" id="mes" name="mes" min="1" max="12" required><br><br>
        <input type="submit" value="Verificar Mês">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Array com os nomes dos meses
        $meses = [
            1 => "Janeiro", 
            2 => "Fevereiro", 
            3 => "Março", 
            4 => "Abril", 
            5 => "Maio", 
            6 => "Junho", 
            7 => "Julho", 
            8 => "Agosto", 
            9 => "Setembro", 
            10 => "Outubro", 
            11 => "Novembro", 
            12 => "Dezembro"
        ];

        // Pegando o número digitado pelo usuário
        $numeroMes = (int)$_POST['mes'];

        // Exibindo o nome do mês correspondente
        if ($numeroMes >= 1 && $numeroMes <= 12) {
            echo "<h2>O mês correspondente ao número $numeroMes é: " . $meses[$numeroMes] . "</h2>";
        } else {
            echo "<h2>Número inválido! Por favor, digite um número entre 1 e 12.</h2>";
        }
    }
    ?>
</body>
</html>
