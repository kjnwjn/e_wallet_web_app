<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./public/assest/css/validate.css" />
    <title>Document</title>
</head>

<body>

    <style>
        .form-validation .error-message {
            color: red;
            margin-top: 12px;
            font-size: 12px;
        }
    </style>
    <div class="main">
        <form action="" method="POST" class="form" id="Login">
            <h3 class="heading">Login</h3>
            <p class="desc"></p>
            <div class="spacer"></div>
            <div class="form-group form-validation">
                <label for="username" class="form-label">Username</label>
                <input id="username" name="username" placeholder="Username" type="text" class="form-control" rules="required" />
                <span class="error-message"></span>
            </div>
            <div class="form-group form-validation">
                <label for="password" class="form-label">password</label>
                <input id="password" name="password" placeholder="Type 6 characters" type="password" class="form-control" rules="required&min=6" />
                <span class="error-message"></span>
            </div>
            <button type="submit" id="btnSubmit" class="form-submit btn">Đăng ký</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../../public/js/validator.js"></script>

    <script>
        Validation('#Login', {
            onSubmit: function(e) {
                e.btnDisable();
                var data = e.formValues()
                var url = 'http://localhost/api/login'
                $.ajax({
                    url,
                    method: 'POST',
                    data: data
                }).done(response => {
                    console.log(response);
                    if (!response.status) {
                        if (response.abnormal === 1) {
                            toastr.error(response.msg);
                        } else {
                            toastr.error(response.msg);
                        }
                    } else {
                        toastr.success(response.msg)
                        window.location.href = response.redirect;
                    }
                });
            }
        })
    </script>
</body>

</html>