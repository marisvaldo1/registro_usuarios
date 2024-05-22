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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/api/usuarios',
                    method: 'POST',
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val(),
                    },
                    success: function(response) {
                        $('#errors').html('<div class="alert alert-success">' + response.message + '</div>');
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
        });
    </script>
</body>
</html>
