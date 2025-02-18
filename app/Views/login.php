<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Resgiter </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
            margin-top: 50px;
        }

        .form-toggle {
            text-align: center;
            margin-top: 10px;
        }

        .image-upload-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .profile-img-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }

        .image-upload-input {
            flex-shrink: 0;
        }

        .form-section {
            margin-top: 20px;
        }

        .placeholder-text {
            font-size: 24px;
            color: #6c757d;
        }
    </style>
    <style>
        .toastbox {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .maintoast {
            display: flex;
            align-items: center;
            background-color: #333;
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            width: 100%;
            justify-content: space-between;
            font-size: 16px;
        }

        .maintoast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .icon {
            margin-right: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .msg {
            flex-grow: 1;
        }

        .offtoast {
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            padding: 0 5px;
            background-color: transparent;
            border: none;
            color: white;
        }

        .success {
            background-color: #28a745;
        }

        .warning {
            background-color: #ffc107;
        }

        .error {
            background-color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Login Form -->
        <div id="loginForm">
            <h2 class="text-center">Login</h2>
            <form id="login">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="loginEmail" name="email">
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password">
                </div>
                <input type="reset" value="Reset" class="btn btn-primary">
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="form-toggle">
                <p>Don't have an account? <a href="#" id="showRegisterForm">Register here</a></p>
            </div>
        </div>

        <!-- Register Form -->
        <div id="registerForm" style="display: none;">
            <h2 class="text-center">Register</h2>
            <form id="register" action="<?= base_url('/register') ?>" method="post" enctype="multipart/form-data">
                <!-- Profile Picture Upload Section -->
                <div class="image-upload-wrapper">
                    <div class="image-upload-input">
                        <label for="profileImage" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profileImage" name="profile_image" accept="image/*">
                    </div>
                    <div>
                        <img id="profileImgPreview" class="profile-img-preview" src="/image/images.jpg"
                            alt="Profile Image Preview">
                    </div>
                </div>
                <!-- Form Fields -->
                <div class="form-section">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="registerName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="registerEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="registerPassword" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                        <small id="sec_text"></small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="form-toggle">
                <p>Already have an account? <a href="#" id="showLoginForm">Login here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showToast(type, message) {
            const toast = $('<div class="maintoast"></div>');
            let icon;
            if (type === 'success') {
                toast.addClass('success');
                icon = '✔';
            } else if (type === 'warning') {
                toast.addClass('warning');
                icon = '⚠';
            } else if (type === 'error') {
                toast.addClass('error');
                icon = '❌';
            }
            toast.html(`
        <div class="icon">${icon}</div>
        <div class="msg">${message}</div>
        <button class="offtoast" onclick="closeToast(this)">X</button>
      `);
            $('#toast-container').append(toast);
            setTimeout(function () {
                toast.addClass('show');
            }, 10);
            setTimeout(function () {
                toast.removeClass('show');
                setTimeout(function () {
                    toast.remove();
                }, 500);
            }, 3000);
        }
        function closeToast(button) {
            const toast = $(button).closest('.maintoast');
            toast.removeClass('show');
            setTimeout(function () {
                toast.remove();
            }, 500);
        }
    </script>

    <script>
        // Toggle between login and register forms
        $('#showRegisterForm').click(function () {
            $('#loginForm').hide();
            $('#registerForm').show();
        });

        $('#showLoginForm').click(function () {
            $('#registerForm').hide();
            $('#loginForm').show();
        });

        // Profile image preview and fallback
        $('#profileImage').change(function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#profileImgPreview').attr('src', e.target.result).show();
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                $('#profileImgPreview').attr('src', '/image/images.jpg').show();
            }
        });

        // Login form submission
        $('#login').submit(function (e) {
            e.preventDefault();
            var form = document.querySelector('#login');
            var formData = new FormData(form);
            console.log("Login FormData: ", formData);  // Debugging FormData
            $.ajax({
                type: 'POST',
                url: '<?= base_url('/login') ?>', // Adjust your login URL here
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if (res.code == 400) {
                        showToast('error', res.msg);
                    } else if (res.code == 200) {
                        showToast('success', 'You are LoggedIn');
                        window.location.href = '/chat-app/dashboard';
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });

        // Register form submission
        $('#register').submit(function (e) {
            e.preventDefault();
            var form = document.querySelector('#register');
            var formData = new FormData(form);
            console.log("Register FormData: ", formData);  // Debugging FormData
            $.ajax({
                url: '<?= base_url('register') ?>', // Adjust your register URL here
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    showToast('success', 'You are Registered');
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    </script>

</body>

</html>