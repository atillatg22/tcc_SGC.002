<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="assets/css/alunos.css">

<section class="home-section">
    <div class="container">
        <div class="text">Histórico de Empréstimos de Chaves</div>
        
        <div class="table-responsive table-container">
            <table class="table table-striped" id="historico-table">
                <thead>
                    <tr>
                        <th>Chave</th>
                        <th>CPF</th>
                        <th>Data do Empréstimo</th>
                        <th>Data da Devolução</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        function atualizarHistorico() {
            $.ajax({
                url: 'atualizar-historico.php',
                type: 'GET',
                success: function (data) {
                    $('#historico-table tbody').html(data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        atualizarHistorico();
    });
</script>
