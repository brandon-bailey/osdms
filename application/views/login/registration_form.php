<?php 
if (isset($this->session->userdata['logged_in'])) {

header("location: index.php/user_authentication/userLoginProcess");
}
?>

<!doctype html> 
 <html>
        <head>
	<meta content="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#FF5858">
    <meta name="description" content="Document Management System">
    <meta name="author" content="Brandon Bailey">
	<link rel="icon" href="<?php echo base_url();?>assets/images/logo-32.png">
	<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">	
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<title><?php echo $siteTitle; ?></title>
  
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
		
		<?php
if (isset($logout_message)) {
	?>
<script >
alertify.success("<?php echo $logout_message ?>",null);
</script>
<?php
}
?>
<?php
if (isset($message_display)) {
?>
<script >
alertify.log("<?php echo $message_display ?>",null);
</script>
<?php
}
?>
		
	<div class="login">	
		<div class="login-screen">
		<div class="app-title">
				<h1>
				<small>Register</small>
				</h1>
			</div>        
		<div class="login-form" >
<?php
			echo "<div class='error_msg'>";
				echo validation_errors();
			echo "</div>";
			echo form_open('user_authentication/newUserRegistration');
				
			echo "<div class='error_msg'>";
				if (isset($message_display)) {
					echo $message_display;
				}
			echo "</div>";
?>
		<div class="control-group">
					<input type="text" class="login login-field"  placeholder="Username" name="username" id="username" >
				<label class="login-field-icon fui-lock" for="username"></label>
        </div>
	
			<?php if(!$this->config->item('require_password_reset')==TRUE): ?>
		<div class="control-group">
					<input type="password" class="login login-field"  placeholder="Password" name="password" id="login-pass" >
				<label class="login-field-icon fui-lock" for="login-pass"></label>
        </div>
		<?php else:?>
		<div class="control-group">
		<span class="help-block">You will be emailed a one time password to reset on your first login.</span>
		</div>
	<?php endif; ?>
		<div class="control-group">
					<input type="email" class="login login-field"  placeholder="Email" name="email" id="email" >
				<label class="login-field-icon fui-lock" for="email"></label>
        </div>
		<div class="control-group">
					<input type="text" class="login login-field"  placeholder="First Name" name="firstName" id="firstName" >
				<label class="login-field-icon fui-lock" for="firstName"></label>
        </div>
		<div class="control-group">
					<input type="text" class="login login-field"  placeholder="Last Name" name="lastName" id="lastName" >
				<label class="login-field-icon fui-lock" for="lastName"></label>
        </div>
		<div class="control-group">
					<input type="tel" class="login login-field"  placeholder="123-456-7890" name="phone" id="phone" >
				<label class="login-field-icon fui-lock" for="phone"></label>
        </div>		
		
		
		
			<?php if (isset($allow_password_reset)&&$allow_password_reset == 'True'){ ?>
                <a href="<?php echo base_url();?>forgot_password" >Forgot Password</a>
					<?php }?>
           <button class="login-btn btn-lg btn-block" type="submit" name="login" >Create</button>
   <br/>

	<?php
			echo form_close();
?>
	<a class="login-btn btn-lg btn-block" href="<?php echo base_url() ?>index.php/user_authentication">For Login Click Here</a>
		
</div>
</div>
</div>