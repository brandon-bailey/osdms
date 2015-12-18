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
</head>

<body>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
