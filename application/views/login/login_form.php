<?php 
if (isset($this->session->logged_in)) 
{
header("location: {base_url()} index.php/user_authentication/userLoginProcess");
}
?>
<!doctype html> 
 <html lang="en">
        <head>
	<meta content="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#FF5858">
		<meta name="application-name" content="<?php echo $this->config->item('application_name');?>"/>
		<meta name="description" content="<?php echo $this->config->item('description');?>"/>
		<link rel="icon" href="<?php echo base_url() . $this->config->item('site_logo');?>">
	<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">	
	<title><?php if(isset($siteTitle)): echo $siteTitle; else: echo $this->config->item('site_title'); endif; ?></title>
  
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
		

	<div class="login">	
		<div class="login-screen">
		<div class="app-title">
				<h1>Login</h1>
			</div> 
		<?php echo form_open('user_authentication/userLoginProcess'); ?>
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
              <input type="text" class="login login-field" placeholder="Enter your name" name="username"  id="login-user" >
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>			
			 <div class="control-group">
        <input type="password" class="login login-field"  placeholder="Password" name="password" id="login-pass" >
		 <label class="login-field-icon fui-lock" for="login-pass"></label>
        </div>
					  <?php if (isset($allow_password_reset)&&$allow_password_reset == 'True'){ ?>
                <a href="<?php echo base_url();?>forgot_password" >Forgot Password</a>
					<?php }?>
            <button class="login-btn btn-lg btn-block" type="submit" name="login" >Enter</button></br>
   <?php if($this->config->item('allow_signup')==TRUE):?>
<a class="login-btn btn-lg btn-block" href="<?php echo base_url() ?>index.php/user_authentication/userRegistrationShow">To Sign Up Click Here</a>
<?php endif;?>
<?php echo form_close(); ?>		
</div>
</div>
</div>

	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<?php if (isset($logout_message)) :	?>
<script >
swal({   title: "Log Out!", type: "warning",  text: "<?php echo $logout_message ?>",   timer: 2000,   showConfirmButton: false });
</script>
<?php
endif;
if (isset($message_display)) :?>
<script >
swal({   title: "Message", type: "warning",  text: "<?php echo $message_display ?>",   timer: 2000,   showConfirmButton: false });
</script>
<?php endif; ?>
	
	</body>
	</html>