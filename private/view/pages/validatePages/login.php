
<style>
    .form-validation .error-message {
        color: red;
        margin-top: 12px;
        font-size: 12px;
    }
    .login-main{
        background-image: linear-gradient(45deg, #8b5aed 0%, #78ebfc 100%);
    }
</style>
<div class="main login-main" style="background-image: linear-gradient(45deg, #8b5aed 0%, #78ebfc 100%)">
    <form action="" method="POST" class="form" id="login-form">
        <h3 class="heading">Login</h3>
        <p class="desc"></p>
        <div class="spacer"></div>
        <div class="form-group form-validation">
            <label for="phoneNumber" class="form-label">phoneNumber</label>
            <input id="phoneNumber" name="phoneNumber" placeholder="phoneNumber" type="text" class="form-control" rules="required" />
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="password" class="form-label">password</label>
            <input id="password" name="password" placeholder="Type 6 characters" type="password" class="form-control" rules="required&min=6" />
            <span class="error-message"></span>
        </div>
        <button type="" id="btnSubmit" class="form-submit btn"  >Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/main.js"> </script>
<script>
    url = 'http://localhost/api/account'
    
    if($('#login-form')){
        validation_submitform(url + '/login' )
    }
</script>

