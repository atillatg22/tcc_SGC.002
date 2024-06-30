<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emprestimo_id = $_POST['emprestimo_id'];

    // Buscar os dados do empréstimo
    $sql = "SELECT * FROM emprestimos WHERE id = $emprestimo_id";
    $result = $conn->query($sql);
    $emprestimo = $result->fetch_assoc();

    if ($emprestimo) {
        // Adicionar ao histórico
        $chave_id = $emprestimo['chave_id'];
        $aluno_cpf = $emprestimo['aluno_cpf'];
        $data_emprestimo = $emprestimo['data_emprestimo'];
        $data_devolucao = date('Y-m-d H:i:s');

        $sql = "INSERT INTO historico (chave_id, aluno_cpf, data_emprestimo, data_devolucao) VALUES ('$chave_id', '$aluno_cpf', '$data_emprestimo', NOW())";
        if ($conn->query($sql) === TRUE) {
            // Devolver chave (remover da tabela emprestimos)
            $sql = "DELETE FROM emprestimos WHERE id = $emprestimo_id";
            if ($conn->query($sql) === TRUE) {
                echo "Sucesso";
            } else {
                echo "Erro: " . $conn->error;
            }
        } else {
            echo "Erro: " . $conn->error;
        }
    } else {
        echo "Empréstimo não encontrado.";
    }
}
?>
