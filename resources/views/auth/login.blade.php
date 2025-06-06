<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - TSPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font & AdminLTE -->
    <link rel="stylesheet" href="{{ asset('Adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 400px;
        }

        .login-card-body {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 3rem 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 15px rgba(66, 133, 244, 0.3);
        }

        .logo-circle .fas {
            color: white;
            font-size: 2rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .login-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: #dc3545;
        }
    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="card login-card-body">
            <!-- Logo Section -->
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h4 class="login-title">Sign In</h4>
                <p class="login-subtitle">Tracer Study Information System Malang State Polytechnic - TSPM</p>
            </div>

            <!-- Login Form -->
            <form id="form-login" action="{{ url('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email / Username</label>
                    <input type="text" name="email" class="form-control" placeholder="Email / Username" required>
                    <span class="invalid-feedback" id="error-email"></span>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="invalid-feedback" id="error-password"></span>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </form>
        </div>

        <div class="text-center mt-3 text-muted">
            <p><strong>TSPM</strong> - Tracer Study of Malang State Polytechnic</p>
            <p class="mb-0">&copy; 2025</p>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('Adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('Adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#form-login").validate({
                rules: {
                    email: { required: true, minlength: 4 },
                    password: { required: true, minlength: 5 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        method: form.method,
                        data: $(form).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.invalid-feedback').text('');
                                $('input').removeClass('is-invalid');
                                $.each(response.msgField, function (field, message) {
                                    $(`input[name="${field}"]`).addClass('is-invalid');
                                    $(`#error-${field}`).text(message[0]);
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'An error occurred on the server.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>

</body>

</html>