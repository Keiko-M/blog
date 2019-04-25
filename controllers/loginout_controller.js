$(document).ready(function(){
    /* handling form validation */
    $("#login-form").validate({
        rules: {
            password: {
                required: true,
            },
            username: {
                required: true,
                email: true
            },
        },
        messages: {
            password:{
                required: "Please enter your password"
             },
            username: {
                required: "Please enter your email address"
            },
        },
        submitHandler: submitForm	
    })	
        
    function submitForm() {		
        var data = $("#login-form").serialize();

        $.ajax({				
                type : 'POST',
                url  : '../../controllers/login_controller.php?action=login',
                data : data,
                beforeSend: function(){	
                        $("#error").fadeOut();
                },
                success : function(response){			
                        if($.trim(response) === "1"){
                                $("#login-submit").html('Signing In ...');
                                setTimeout(' window.location.href = "welcome.php"; ',2000);
                        } else {									
                                $("#error").fadeIn(1000, function(){						
                                        $("#error").html(response).show();
                                });
                        }
                }
        });
        return false;
    }
});

