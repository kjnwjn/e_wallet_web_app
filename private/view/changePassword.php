<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Document</title>
    <link rel="stylesheet" href="./public/assest/css/validate.css" />
</head>

<style>
    .form-validation .error-message {
        color: red;
        margin-top: 12px;
        font-size: 12px;
    }
</style>

<body>

    <div class="main">
        <form action="" method="POST" class="form" id="changePassword">
            <h3 class="heading">Change Password</h3>
            <p class="desc"></p>
            <div class="spacer"></div>
            <div class="form-group form-validation">
                <label for="oldPassword" class="form-label">Old password</label>
                <input id="oldPassword" name="oldPassword" placeholder="Old password" type="password" class="form-control" rules="required&min=6" />
                <span class="error-message"></span>
            </div>
            <div class="form-group form-validation">
                <label for="newPassword" class="form-label">New password</label>
                <input id="newPassword" name="newPassword" placeholder="New password" type="password" class="form-control" rules="required&min=6" />
                <span class="error-message"></span>
            </div>
            <div class="form-group form-validation">
                <label for="confirmPassword" class="form-label">Confirm password</label>
                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" type="password" class="form-control" rules="required&min=6" />
                <span class="error-message"></span>
            </div>
            <button type="submit" class="form-submit btn">Đổi mật khẩu</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../../public/js/validator.js"></script>
    <script>
        Validation('#changePassword', {
            onSubmit: function(e) {
                e.btnDisable();
                var data = e.formValues()

                var url = 'http://localhost/api/changePassword'
                $.ajax({
                    url,
                    method: 'POST',
                    // enctype: 'multipart/form-data',

                    data: data
                }).done(response => {
                    console.log(response);
                    if (!response.status) {
                        toastr.error(response.msg);
                    } else {
                        toastr.success(response.msg);
                        // window.location.href = response.redirect;
                        // window.location.reload();
                    }
                });
            }
        })
    </script>

</body>

</html>