<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    
    <form method="post">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <div>
                <label for="nome<?php echo $i; ?>">Nome do Aluno <?php echo $i; ?>:</label>
                <input type="text" id="nome<?php echo $i; ?>" name="nome<?php echo $i; ?>" required><br>
                
                <label for="nota<?php echo $i; ?>">Nota do Aluno <?php echo $i; ?>:</label>
                <input type="number" id="nota<?php echo $i; ?>" name="nota<?php echo $i; ?>" min="0" max="10" step="0.1" required><br><br>
            </div>
        <?php endfor; ?>
        
        <input type="submit" value="Calcular">
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $alunos = [];
        $somaNotas = 0;
        $maiorNota = 0;
        $alunoMaiorNota = "";

        // Coletando os dados dos alunos do formulário
        for ($i = 1; $i <= 10; $i++) {
            $nome = $_POST['nome' . $i];
            $nota = (float)$_POST['nota' . $i];
            
            $alunos[] = ['nome' => $nome, 'nota' => $nota];
            
            // Somando as notas
            $somaNotas += $nota;
            
            // Verificando o aluno com a maior nota
            if ($nota > $maiorNota) {
                $maiorNota = $nota;
                $alunoMaiorNota = $nome;
            }
        }

        // Calculando a média da turma
        $media = $somaNotas / count($alunos);

        // Exibindo os resultados
        echo "<h2>Resultados:</h2>";
        echo "<p>A média da turma é: " . number_format($media, 2) . "</p>";
        echo "<p>O aluno com a maior nota é: " . $alunoMaiorNota . " com nota " . $maiorNota . "</p>";
    }
    ?>
</body>
</html>
