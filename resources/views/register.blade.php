<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuários</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Usuários</h2>
        <form id="registerForm" method="POST" >

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmação de senha</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div id="errors" class="mt-3"></div>

        <h2 class="mt-5">Lista de Usuários</h2>
        <table class="table table-bordered mt-3" id="usuariosTable">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Usuários serão carregados aqui -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Função para carregar usuários
            function loadUsuarios() {
                $.ajax({
                    url: '/api/usuarios',
                    method: 'GET',
                    success: function(response) {
                        let usuariosHtml = '';
                        $.each(response.data, function(key, usuario) {
                            usuariosHtml += '<tr>';
                            usuariosHtml += '<td>' + usuario.name + '</td>';
                            usuariosHtml += '<td>' + usuario.email + '</td>';
                            usuariosHtml += '<td>';
                            usuariosHtml += '<button class="btn btn-warning btn-sm edit-btn" data-id="' + usuario.id + '">Editar</button> ';
                            usuariosHtml += '<button class="btn btn-danger btn-sm delete-btn" data-id="' + usuario.id + '">Excluir</button>';
                            usuariosHtml += '</td>';
                            usuariosHtml += '</tr>';
                        });
                        $('#usuariosTable tbody').html(usuariosHtml);
                    }
                });
            }

            // Carregar usuários ao carregar a página
            loadUsuarios();

            // Handle form submission for creating and updating users
            $('#registerForm').on('submit', function(event) {
                event.preventDefault();
                let method = 'POST';
                let url = '/api/usuarios';
                let id = $(this).data('id');
                if (id) {
                    method = 'PUT';
                    url += '/' + id;
                }
                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val(),
                    },
                    success: function(response) {
                        $('#errors').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#registerForm').trigger("reset").removeData('id');
                        loadUsuarios();
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        errorsHtml += '</ul></div>';
                        $('#errors').html(errorsHtml);
                    }
                });
            });

            // Handle edit button click
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: '/api/usuarios/' + id,
                    method: 'GET',
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#registerForm').data('id', response.id);
                    }
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                if (confirm('Tem certeza que deseja excluir este usuário?')) {
                    $.ajax({
                        url: '/api/usuarios/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            $('#errors').html('<div class="alert alert-success">' + response.message + '</div>');
                            loadUsuarios();
                        },
                        error: function(response) {
                            let errors = response.responseJSON.errors;
                            let errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            errorsHtml += '</ul></div>';
                            $('#errors').html(errorsHtml);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
