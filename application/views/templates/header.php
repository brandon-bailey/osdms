<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="<?php echo $this->config->item('application_name'); ?>" />
    <meta name="description" content="<?php echo $this->config->item('description'); ?>" />
    <!--For mobile browsers, sets the windows color to this custom color-->
    <meta name="theme-color" content="#FF5858">
    <title>
        <?php echo $pageTitle; ?> |
            <?php echo $this->config->item('site_title'); ?>
    </title>
    <link rel="icon" href="<?php echo base_url() . $this->config->item('favicon') ? $this->config->item('favicon') : $this->config->item('site_logo'); ?>">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/data-tables/media/css/dataTables.bootstrap.css">
    <?php if (isset($bodyClass) && $bodyClass == 'edit'): ?>
        <link href="<?php echo base_url(); ?>assets/css/builder.css" rel="stylesheet" type="text/css" media="all">
        <?php endif;?>
</head>

<body class="<?php if (isset($bodyClass)): echo $bodyClass;endif;?>">
    <header class="navbar navbar-inverse navbar-fixed-top">
        <!--Begin Navbar-->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" rel="home" href="<?php echo site_url(); ?>home" style="margin-top: -7px;" title="<?php echo $this->config->item('site_title'); ?>">
      <img style="width:75%;" alt="<?php echo $this->config->item('site_title'); ?>" src="<?php echo base_url() . $this->config->item('site_logo') ?>"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" role="navigation">
                <ul class="nav navbar-nav" id="navigation">
                    <li><a href="<?php echo site_url(); ?>home">Home</a></li>
                    <?php if ($this->session->canCheckIn OR $this->session->admin === TRUE): ?>
                        <li><a href="<?php echo site_url(); ?>checkin">Check In</a></li>
                        <?php endif;?>
                            <li><a href="<?php echo site_url(); ?>search">Search</a></li>
                            <?php if ($this->session->canAdd OR $this->session->admin === TRUE): ?>
                                <li><a href="<?php echo site_url(); ?>add">Add Document</a></li>
                                <?php endif;?>
                                    <?php if ($this->session->admin): ?>
                                        <li>
                                            <a href="<?php echo site_url(); ?>admin">Admin</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url(); ?>dashboard">Dashboard</a>
                                        </li>
                                        <?php endif;?>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Create <i class="fa fa-caret-down"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="<?php echo site_url(); ?>builder/module">Create Module</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo site_url(); ?>builder/document">Create Document</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?php echo site_url(); ?>user_authentication/logout">Logout</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown" data-toggle="tooltip" data-placement="auto" title="View Profile and More">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-dismiss="tooltip">
      <img alt="@<?php echo $this->session->username; ?>" class="img-rounded"
    src="data:image/jpeg;base64,<?php echo base64_encode($this->userObj->getAvatar()); ?>"
     height="20" width="20">
     <span class="caret"></span>
     </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Logged in as <strong><?php echo $this->session->username; ?></strong></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url(); ?>profile">Your Profile</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </header>
    <!--End Navbar-->
    <div class="container">
        <div class="row">
            <nav class="breadcrumb">
                <span>You are here:</span>
            </nav>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <?php if (isset($bodyClass) && $bodyClass == 'edit'): ?>
        <script src="<?php echo base_url() ?>assets/js/jquery.htmlClean.js"></script>
        <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
        <script src="<?php echo base_url() ?>assets/ckeditor/ckeditor.js"></script>
        <?php endif;?>
