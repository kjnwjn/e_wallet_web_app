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
<div class="main login-main" style="background-image: linear-gradient(45deg, #222D73 0%, #78ebfc 100%)">
    <form action="" method="POST" class="form" id="register-form">
        <h3 class="heading">Register</h3>
        <p class="desc"></p>
        <div class="md-form mb-3 form-group form-validation">
            <label class="form-label" for="email">Your email address</label>
            <input type="email" name="email" placeholder="email" id="email" class="form-control" rules="required&email">     
            <span class="error-message"></span>
        </div> 
        <div class="md-form mb-3 form-group form-validation">
            <label class="form-label" for="phoneNumber">PhoneNumber</label>
            <input type="phoneNumber" name="phoneNumber" placeholder="Phone Number" id="phoneNumber" class="form-control" rules="required&min=10">     
            <span class="error-message"></span>
        </div> 
        <div class="form-group form-validation">
            <label for="fullname" class="form-label">Full name</label>
            <input id="fullname" name="fullname" placeholder="fullname" type="text" class="form-control" rules="required" />
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="gender" class="form-label">Gender</label>
            <div class="form_gender">
                <div class="gender_input">
                    <input
                        id = "male_gender"
                        name="gender"
                        type="radio"
                        class="form-control"
                        value="Male"
                    />
                    <label for="male_gender" class="form-label" style="margin-top: 6px">Male</label>
                </div>
                <div class="gender_input">
                    <input
                        id = "female_gender"
                        name="gender"
                        type="radio"
                        class="form-control"
                        value="Female"
                    /><label for="female_gender" class="form-label" style="margin-top: 6px">Female</label>
                </div>
            </div>
        </div>
      
        <div class="form-group form-validation">
            <label for="address" class="form-label">Address</label>
            <input id="address" name="address" placeholder="address" type="text" class="form-control" rules="required" />
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="birthday" class="form-label">Birthday</label>
            <input id="birthday" name="birthday" placeholder="birthday" type="text" class="form-control" rules="required" />
            <span class="error-message"></span>
        </div> 
        <!-- <div class="form-group form-validation">
            <label for="idCard_front" class="form-label">ID Card front</label>
            <input id="idCard_front" name="idCard_front" placeholder="idCard_front" type="file" class="form-control" rules="required" multipart/>
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="idCard_back" class="form-label">ID Card back</label>
            <input id="idCard_back" name="idCard_back" placeholder="idCard_back" type="file" class="form-control" rules="required" multipart/>
            <span class="error-message"></span>
        </div> -->
        <button type="submit" id="btnSubmit" class="form-submit btn" >Đăng ký</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="/main.js"> </script>
<script>
    url = 'http://localhost/api/account/register'
    
    if($('form')){
        Validation("form", {
            onSubmit: function(data) {
                var formData = new FormData();
                for (i in data) {
                    if(i == 'idCard_front' || i == 'idCard_back'){
                        element = $('#'+ i +'');
                        formData.append(i,element[0].files[0]);
                        continue;
                    }
                    if (i == 'birthday'){
                        formData.append(i,toTimestamp(data[i]));
                        continue;
                    }
                        formData.append(i,data[i]);
                }
               
            
                // Display the values
                // for (var value of formData.values()) {
                //     console.log(value);
                // }
                $.ajax({                                                                               
                        url,
                        method: 'POST',
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        data: formData,                                                            
                        success: function (response) {   
                        if(response.status) {
                            alertify.success(response.msg);
                            if(response.redirect) {
                                window.location.href = response.redirect;
                            }
                        }else{
                            alertify.error(response.msg);

                        }                                                        
                    },                                                                                 
                });  
              
            },
        });
    }
    function toTimestamp(strDate){
        var datum = Date.parse(strDate);
        return datum/1000;
    }
</script>
