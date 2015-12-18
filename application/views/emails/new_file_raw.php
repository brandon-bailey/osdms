<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width" name="viewport">
    <title><?php echo $this->config->item('site_title');?></title>	
<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <header class="navbar navbar-inverse navbar-fixed-top" ><!--Begin Navbar-->
	    <div class="container">  
		<div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" rel="home" href="<?php echo base_url(); ?>index.php/home" 
		  style="margin-top: -7px;" title="<?php echo $this->config->item('site_title');?>">
		  <img alt="<?php echo $this->config->item('site_title');?>" src="<?php echo base_url() . $this->config->item('site_logo') ?>"></a>  
		</div>		         
          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" role="navigation">
            <ul class="nav navbar-nav" id="navigation">
              <li><a href="<?php echo base_url(); ?>index.php/home">Home</a></li>
	   
     </ul>
	 

           </div><!--/.nav-collapse -->
          </div>
    </header><!--End Navbar-->
<div class="container">
<div class="row">
<div class="col-md-12 col-xs-12">
<div class="well">
<h2>Dear, <?php echo $title?></h2>
<p><?php echo $fileName . ' ' . $msg . ' ' . $uploader ?></p>
<p>Comments from <?php echo $uploader ?>: </p>
<p> <blockquote>
         <em><?php echo $comments ?></em>
          </blockquote>
</p>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12">
<table class="table table-striped table-bordered">
<tbody>
<tr>
<td>Filename: </td>
<td><?php echo $fileName?></td>
</tr>
<tr>
<td>Uploader: </td>
<td><?php echo $uploader?></td>
</tr>
<tr>
<td>Date: </td>
<td><?php echo $date ?></td>
</tr>
</tbody>
</table>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12">
<div class="alert alert-danger">
<p>To view this document in your browser <a href="<?php echo base_url() ?>" >Click Here</a> </p>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12">
<blockquote>
<p>Thank you, </p>
<a href="<?php echo base_url() ?>">
<footer><cite title="<?php echo $this->config->item('site_title');?>"><?php echo $this->config->item('site_title');?></cite></footer>
</a>
</blockquote>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12">

<div class="well">
<h3>Contact Info</h3>
<address>
  <strong><?php echo $uploader ?></strong><br>
  <?php echo $department ?><br>
  <abbr title="Phone">P:</abbr><a href="tel:<?php echo $phoneNumber ?>"> <?php echo $phoneNumber ?></a><br>
  <abbr title="Email">E:</abbr> <a href="mailto:<?php echo  $email ?>"> <?php echo  $email ?></a>
</address>

</div>
</div>
</div>

</div>


</div>

</body>
</html>