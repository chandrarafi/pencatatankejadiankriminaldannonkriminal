<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Polsek Lunang Silaut</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-box {
            width: 400px;
            margin: 5% auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 25px;
            border: 2px solid #e3f2fd;
            padding: 12px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .input-group-text {
            border-radius: 25px 0 0 25px;
            border: 2px solid #e3f2fd;
            border-right: none;
            background: #f8f9fa;
        }

        .input-group .form-control {
            border-radius: 0 25px 25px 0;
            border-left: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 40px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        .police-badge {
            font-size: 48px;
            color: #3498db;
            margin-bottom: 15px;
        }

        .loading {
            display: none;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline">
            <div class="card-header">
                <div class="police-badge">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>POLSEK LUNANG SILAUT</h3>
                <p class="mb-0">Sistem Pencatatan Kejadian</p>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silakan login untuk melanjutkan</p>

                <form id="loginForm">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="login" name="login"
                            placeholder="Username atau Email" required>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" required>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
                                <span class="normal-text">
                                    <i class="fas fa-sign-in-alt mr-2"></i>LOGIN
                                </span>
                                <span class="loading">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- <div class="mt-4">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle mr-2"></i>Akun Default:</h6>
                        <small>
                            <strong>SPKT:</strong> spkt_admin / password123<br>
                            <strong>Kasium:</strong> kasium_admin / password123<br>
                            <strong>Reskrim:</strong> reskrim_admin / password123<br>
                            <strong>Kapolsek:</strong> kapolsek_admin / password123
                        </small>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const loginBtn = $('#loginBtn');
                const normalText = $('.normal-text');
                const loadingText = $('.loading');

                // Show loading state
                normalText.hide();
                loadingText.show();
                loginBtn.prop('disabled', true);

                // Get form data
                const formData = {
                    login: $('#login').val(),
                    password: $('#password').val()
                };

                // Ajax request
                $.ajax({
                    url: '<?= base_url('auth/login') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: response.message,
                                confirmButtonColor: '#3498db'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
                            confirmButtonColor: '#3498db'
                        });
                    },
                    complete: function() {
                        // Reset loading state
                        normalText.show();
                        loadingText.hide();
                        loginBtn.prop('disabled', false);
                    }
                });
            });

            // Enter key to submit
            $('#login, #password').on('keypress', function(e) {
                if (e.which == 13) {
                    $('#loginForm').submit();
                }
            });
        });
    </script>
</body>

</html>