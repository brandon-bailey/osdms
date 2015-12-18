<!DOCTYPE html>
<html lang="en">
      <head>
            <meta charset="utf-8" />
            <meta content="width=device-width" name="viewport" />
            <title>
                  <?php echo $this->config->item('site_title');?>
            </title>
            <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
      </head>
      <body>
            <!--End Navbar-->
            <div class="container">
                  <div class="row">
                        <div class="col-md-12 col-xs-12">
                              <div class="well">
                                    <h2>Dear, <?php echo $newUser ?></h2>
                                    <p>
                                          <?php echo $creator . ' ' . $msg  ?>
                                    </p>
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-12 col-xs-12">
                              <table class="table table-striped table-bordered">
                                    <tbody>
                                          <tr>
                                                <td>Username:</td>
                                                <td>
                                                      <?php echo $username ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td>Password:</td>
                                                <td>
                                                      <?php echo $password ?>
                                                </td>
                                          </tr>
                                    </tbody>
                              </table>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-12 col-xs-12">
                              <div class="alert alert-danger">
                                    <p>To reset your temporary password <a href="<?php echo $link ?>" >Click Here</a></p>
                              </div>							
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-12 col-xs-12">
                              <blockquote>
                                    <p>Thank you,</p>
                                    <a href="<?php echo base_url() ?>">
                                          <footer>
                                                <cite title="<?php echo $this->config->item('site_title');?>">
                                                      <?php echo $this->config->item('site_title');?>
                                                </cite>
                                          </footer>
                                    </a>
                              </blockquote>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-12 col-xs-12">
                              <div class="well">
                                    <h3>Contact Info</h3>
                                    <address>
                                    <strong>
                                          <?php echo $creator ?>
                                    </strong>
                                    <br /><?php echo $department ?>
                                    <br />
                                    <abbr title="Phone">P:</abbr>
                                    <a href="tel:<?php echo $phoneNumber ?>">
                                          <?php echo $phoneNumber ?>
                                    </a>
                                    <br />
                                    <abbr title="Email">E:</abbr> 
                                    <a href="mailto:<?php echo $email ?>">
                                          <?php echo  $email ?>
                                    </a></address>
                              </div>
                        </div>
                  </div>
            </div>
      </body>
</html>
