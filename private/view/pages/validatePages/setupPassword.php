<style>
    .form-validation .error-message {
        color: red;
        margin-top: 12px;
        font-size: 12px;
    }

    .login-main {
        background-image: linear-gradient(45deg, #222D73 0%, #78ebfc 100%);
    }
</style>
<div class="main login-main">
    <form action="" method="POST" class="form" id="setupPassword-form">
        <h3 class="heading">Setup Password</h3>
        <p class="desc">You need to change your password first.</p>
        <div class="form-group form-validation">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" placeholder="Type 6 characters" type="password" class="form-control" rules="required&min=6" />
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="confirm_password" class="form-label">Password confirm</label>
            <input id="confirm_password" name="confirm_password" placeholder="Type 6 characters" type="password" class="form-control" rules="required&min=6" />
            <span class="error-message"></span>
        </div>
        
        <button type="submit" id="btnSubmit" class="form-submit btn">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="/main.js"> </script>
<script>
    url = 'http://localhost/api/account'
    
    if($('#setupPassword-form')){
        validation_submitform(url + '/setup-password' )
    }
</script>
