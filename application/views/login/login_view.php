<?php 
if (isset($this->session->userdata['logged_in'])) {
header("location: index.php/user_authentication/user_login_process");
}
?>
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
width: 300px;
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
<?php if($this->config->item('allow_signup')==TRUE): ?>		
<body>		
<?php
if (isset($logout_message)) {
	?>
<script >
swal({   title: "Log Out!", type: "warning",  text: "<?php echo $logout_message ?>",   timer: 2000,   showConfirmButton: false });
</script>
<?php
}
?>
<?php
if (isset($message_display)) {
?>
<script >
swal({   title: "Message!", type: "warning",  text: "<?php echo $message_display ?>",   timer: 2000,   showConfirmButton: false });
</script>
<?php
}
?>
		
	<div class="login">	
		<div class="login-screen">
		<div class="app-title">
				<h1>Login</h1>
			</div>        
		<div class="login-form" >
<?php
			echo "<div class='error_msg'>";
				echo validation_errors();
			echo "</div>";
			echo form_open('user_authentication/new_user_registration');

				echo form_label('Create Username : ');
			echo"<br/>";
				echo form_input('username');
			echo "<div class='error_msg'>";
				if (isset($message_display)) {
					echo $message_display;
				}
			echo "</div>";
				echo"<br/>";
			echo form_label('Email : ');
			echo"<br/>";
			$data = array(
				'type' => 'email',
				'name' => 'email_value'
			);
			echo form_input($data);
			echo"<br/>";
			echo"<br/>";
			echo form_label('Password : ');
			echo"<br/>";
			echo form_password('password');
			echo"<br/>";
			echo"<br/>";
			echo form_submit('submit', 'Sign Up');
			echo form_close();
?>
	<a href="<?php echo base_url() ?> ">For Login Click Here</a>
		
</div>
</div>
</div>
<?php endif; ?>
</body>

</html>