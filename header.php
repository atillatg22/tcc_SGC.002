<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/header.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .profile-details {
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .profile-details img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .profile-details .name_job {
            display: flex;
            flex-direction: column;
        }
        .profile-details .name {
            font-weight: bold;
        }
        .swal2-file-label{
            background-color: transparent;
            border-radius: 20px;
            margin-bottom: -4px;
            border: 1px solid black;
            color: black;
            padding: 12px;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .swal2-file-label:hover{
            color: white;
            background-color: rgb(41, 37, 37);
            border: 1px solid rgb(41, 37, 37);
        }
    </style>
</head>

<body>
    <div class="sidebar open">
        <div class="logo-details">
            <div class="logo_name">Menu Principal</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="dashboard.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="chaves.php">
                    <i class='bx bxs-key'></i>
                    <span class="links_name">Cadastro de Chaves</span>
                </a>
                <span class="tooltip">Cadastro de Chaves</span>
            </li>
            <li>
                <a href="alunos.php">
                    <i class='bx bx-user-plus'></i>
                    <span class="links_name">Cadastro de Alunos</span>
                </a>
                <span class="tooltip">Cadastro de Alunos</span>
            </li>
            <li>
                <a href="emprestimo-de-chave.php">
                    <i class='bx bxs-alarm-exclamation'></i>
                    <span class="links_name">Empréstimo de Chaves</span>
                </a>
                <span class="tooltip">Empréstimo de Chaves</span>
            </li>
            <li>
                <a href="relatorio.php">
                    <i class='bx bx-file'></i>
                    <span class="links_name">Devolução</span>
                </a>
                <span class="tooltip">Devolução</span>
            </li>
            <li>
                <a href="historico.php">
                    <i class='bx bx-history'></i>
                    <span class="links_name">Histórico</span>
                </a>
                <span class="tooltip">Histórico</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="./images/user.png" alt="profileImg">
                    <div class="name_job">
                        <div class="name">Patrícia</div>
                        <div class="job">Administrador</div>
                    </div>
                </div>
                <a href="index.php" id="log_out">
                    <i class='bx bx-log-out' id="log_out"></i>
                </a>
            </li>
        </ul>
    </div>
</body>
<script>
$(document).ready(function() {
    // Função para atualizar o perfil
    function updateProfile(name, imageUrl) {
        // Atualiza o nome na div .name
        $('.name').text(name);

        // Atualiza a imagem de perfil
        $('.profile-details img').attr('src', imageUrl);

        // Armazena os dados no localStorage
        localStorage.setItem('profileName', name);
        localStorage.setItem('profileImage', imageUrl);
    }

    // Verifica se há dados de perfil armazenados no localStorage
    var storedName = localStorage.getItem('profileName');
    var storedImage = localStorage.getItem('profileImage');

    if (storedName && storedImage) {
        // Se houver dados armazenados, atualiza o perfil
        updateProfile(storedName, storedImage);
    }

    // Evento de clique para editar perfil
    $('.profile-details').on('click', function() {
        Swal.fire({
            title: 'Editar Perfil',
            html:
                `<input id="swal-input1" class="swal2-input" value="${$('.name').text()}">` +
                `<input id="swal-input3" class="swal2-input" type="password" placeholder="Nova senha">` +
                `<label for="swal-input2" class="swal2-file-label">Escolha sua Foto</label>` +
                '<input id="swal-input2" type="file" class="swal2-file" accept="image/*" style="display: none;">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Salvar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    const name = $('#swal-input1').val();
                    const newPassword = $('#swal-input3').val();
                    const file = $('#swal-input2')[0].files[0];

                    // Processamento do arquivo de imagem, se fornecido
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Simula um tempo de processamento
                            setTimeout(() => {
                                // Atualiza o perfil com o novo nome, senha e imagem
                                updateProfile(name, e.target.result);
                                // Envia os dados para processamento no PHP
                                $.post('process.php', {
                                    update_profile: true,
                                    username: name,
                                    new_password: newPassword,
                                    profile_image: e.target.result
                                }).done(function(data) {
                                    Swal.fire('Perfil atualizado!', '', 'success');
                                    resolve();
                                }).fail(function(error) {
                                    Swal.showValidationMessage(`Request failed: ${error}`);
                                    resolve();
                                });
                            }, 1000); // Tempo de espera simulado de 1 segundo
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Apenas atualiza o nome e senha se não houver imagem nova
                        updateProfile(name, storedImage); // mantém a imagem existente
                        // Envia os dados para processamento no PHP
                        $.post('process.php', {
                            update_profile: true,
                            username: name,
                            new_password: newPassword,
                            profile_image: null // sem nova imagem
                        }).done(function(data) {
                            Swal.fire('Perfil atualizado!', '', 'success');
                            resolve();
                        }).fail(function(error) {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                            resolve();
                        });
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
});

</script>



</html>
