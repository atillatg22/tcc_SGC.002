<?php
include 'db.php';
$sql = "SELECT * FROM historico";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['chave_id']; ?></td>
        <td><?php echo $row['aluno_cpf']; ?></td>
        <td><?php echo $row['data_emprestimo']; ?></td>
        <td><?php echo $row['data_devolucao']; ?></td>
    </tr>
<?php endwhile; ?>