<!doctype html> 
 <html>
        <head>
	<meta content="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#FF5858">
		<meta name="application-name" content="<?php echo $this->config->item('application_name');?>"/>
		<meta name="description" content="<?php echo $this->config->item('description');?>"/>
		<link rel="icon" href="<?php echo base_url() . $this->config->item('site_logo');?>">
	<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">	
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/validate.js"></script>
	<title><?php echo $this->config->item('site_name'); ?></title>
  
		<style>
* {
box-sizing: border-box;
}

*:focus {
	outline: none;
}
body {
font-family: Arial; 
   background-color: #FF5858;
padding-top: 15%;
}
.login {
margin: 20px auto;
width: 500px;
}
.login-screen {
box-shadow: 2px 2px 8px rgba(42, 103, 172, 0.5);
background-color: #FFF;
padding: 20px;
border-radius: 5px;
}

.app-title {
text-align: center;
color: #777;
}

.login-form {
text-align: center;
}
.control-group {
margin-bottom: 10px;
}

.login input {
text-align: center;
background-color: #ECF0F1;
border: 2px solid transparent;
border-radius: 3px;
font-size: 16px;
font-weight: 200;
padding: 10px 0;
width: 250px;
transition: border .5s;
}

.login input:focus {
border: 2px solid #3498DB;
box-shadow: none;
}

.login-btn {
  border: 2px solid transparent;
  background-color: #E86C6C;
  color: #ffffff;
  font-size: 16px;
  line-height: 25px;
  padding: 10px 0;
  text-decoration: none;
  text-shadow: none;
  border-radius: 3px;
  box-shadow: none;
  transition: 0.25s;
  display: block;
  width: 250px;
  margin: 0 auto;
}


.login-link {
  font-size: 12px;
  color: #444;
  display: block;
	margin-top: 12px;
}
		</style>
    </head>		
    <body>		
		<?php if (isset($logout_message)) :?>
			<script >
					swal({   title: "Log Out!", type: "warning",  text: "<?php echo $logout_message ?>",   timer: 2000,   showConfirmButton: false });
			</script>
		<?php endif; ?>
		<?php if (isset($message_display)) :?>
			<script >
				swal({   title: "Message", type: "warning",  text: "<?php echo $message_display ?>",   timer: 2000,   showConfirmButton: false });
			</script>
		<?php endif;?>
	<div class="login">	
		<div class="login-screen">
		<div class="app-title">
				<h1>Reset Password</h1>
				<h2><?php echo $username;?></h2>
		</div> 	
		<?php echo form_open('user_authentication/resetPassword','id="passwordReset" accept-charset="urf-8"') ?>
			<?php
					echo "<div class='error_msg'>";
							if (isset($error_message)) {
									echo $error_message;
							}
							echo validation_errors();
							echo "</div>";
			?>	
		<div class="login-form" >
            <div class="control-group">
					<input type="hidden" name="username" value="<?php echo $username;?>">
					<input type="hidden" name="oldPassword" value="<?php echo $oldPassword;?>">
					<input type="password" id="password" class="login login-field" placeholder="Enter Password" name="password" minlength="8">
					<label class="login-field-icon fui-user" for="password"></label>
            </div>			
			 <div class="control-group">
					<input type="password" class="login login-field"  placeholder="Confirm Password" name="confirmPassword" id="confirmPassword" minlength="8">
					<label class="login-field-icon fui-lock" for="confirmPassword"></label>
			 </div>
            <button class="login-btn btn-lg btn-block" type="submit" name="login" >Change Password</button>
					<?php echo form_close(); ?>		
		</div>
		</div>
	</div>
	<script>
	var formStatus = $('#passwordReset').validate({
    rules: {
        password: {
                        required: true,
                        minlength: 5
        },
        confirmPassword: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
        }
    }
}); 
	</script>
	
	
	</body>
	</html>