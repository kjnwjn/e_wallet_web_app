<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./public/assest/css/validate.css" />
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
        <form action="" method="POST" class="form" id="register" enctype="multipart/form-data">
            <h3 class="heading">Register</h3>
            <p class="desc"></p>
            <div class="spacer"></div>
            <div class="form-group form-validation">
                <label for="fullName" class="form-label">Full Name</label>
                <input id="fullName" name="fullName" type="text" placeholder="VD: Sơn Đặng" class="form-control" rules="required" />
                <span class="error-message"></span>
            </div>

            <div class="form-group form-validation">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input id="phoneNumber" name="phoneNumber" type="number" placeholder="Phone Number" class="form-control" rules="required" />
                <span class="error-message"></span>
            </div>

            <div class="form-group form-validation">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="text" placeholder="VD: email@domain.com" class="form-control" rules="required&email" />
                <span class="error-message"></span>
            </div>

            <div class="form-group form-validation">
                <label for="address" class="form-label">Address</label>
                <input id="address" name="address" type="text" placeholder="Address" class="form-control" rules="required" />
                <span class="error-message"></span>
            </div>

            <div class="form-group form-validation">
                <label for="date" class="form-label">Date</label>
                <input id="date" name="date" type="date" placeholder="Date" class="form-control" rules="required" />
                <span class="error-message"></span>
            </div>
            <div class="form-group form-validation">
                <label for="idCard1" class="form-label">Id Image 1</label>
                <input id="idCard1" name="idCard1" type="file" placeholder="File ID 1" class="form-control" rules="required" accept="image/png, image/gif, image/jpeg" />
                <span class="error-message"></span>
            </div>
            <div class="form-group form-validation">
                <label for="idCard2" class="form-label">Id Image 2</label>
                <input id="idCard2" name="idCard2" type="file" placeholder="File ID 2" class="form-control" rules="required" accept="image/png, image/gif, image/jpeg" />
                <span class="error-message"></span>
            </div>
            <button class="form-submit btn">Register</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../../public/js/validator.js"></script>

    <script>
        Validation('#register', {
            onSubmit: function(e) {
                e.btnDisable();
                var data = e.formValues();
                var formData = new FormData();
                for (const property in data) {
                    if (!property.includes('idCard')) {
                        formData.append(property, data[property]);
                    }
                }
                var date = (new Date($('#date').val())).getTime()
                formData.append('date', date);
                var img1 = document.querySelector('#idCard1')
                var img2 = document.querySelector('#idCard2')
                formData.append('idCard1', img1.files[0]);
                formData.append('idCard2', img2.files[0]);


                // var data = e.formValues()
                var url = '../api/register'
                $.ajax({
                    url,
                    method: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data: formData,
                }).done(response => {
                    if (!response.status) {
                        toastr.error(response.msg);
                    } else {
                        toastr.success(response.msg);
                        console.log(response.redirect);
                        setTimeout(link => {
                            window.location.href = response.redirect;
                        }, 3000)
                        // window.location.reload();

                    }
                });
            }
        })
    </script>
</body>

</html>