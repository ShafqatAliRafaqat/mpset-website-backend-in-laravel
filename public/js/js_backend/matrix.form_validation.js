
$(document).ready(function(){

    $('#old_pass').blur( function(){
        var old_pass = $('#old_pass').val();
        $.ajax({
            type: 'get',
            url: '/settings/check-password',
            data: { old_pass:old_pass },
            success:function(resp){
                // alert(resp);
                if(resp == 'false'){
                    $('#chk_pwd').html('<font color="red"> You have Entered Invalid Password!!! </font>');
                }
                if(resp == 'true'){
                    $('#chk_pwd').html('<font color="green"> Old Passwoprd is correct </font>');
                }
            }, error:function(){
                alert("Error");
            }
        });
    });


	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#password_validate").validate({
		rules:{
			old_pass:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pass:{
				required: true,
				minlength:6,
				maxlength:20
			},
			cnew_pass:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pass"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});
