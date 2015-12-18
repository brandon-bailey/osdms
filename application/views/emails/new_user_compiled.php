<!DOCTYPE html>
<html lang="en" style="font-family: sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-size: 10px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<meta content="width=device-width" name="viewport">
<title>
<?php echo $this->config->item('site_title');?>
            </title>
</head>
<body style="padding-top: 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.42857143; color: #333; background-color: #fff; margin: 0;" bgcolor="#fff">

            <!--End Navbar-->
            <div class="container" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto; width: 1170px;">
                  <div class="row" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-right: -15px; margin-left: -15px;">
                        <div class="col-md-12 col-xs-12" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float: left; width: 100%;">
                              <div class="well" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; min-height: 20px; margin-bottom: 20px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); background-color: #f5f5f5; padding: 19px; border: 1px solid #e3e3e3;">
                                    <h2 style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-family: inherit; font-weight: 500; line-height: 1.1; color: inherit; margin-top: 20px; margin-bottom: 10px; font-size: 30px;">Dear, <?php echo $newUser ?>
</h2>
                                    <p style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin: 0 0 10px;">
                                          <?php echo $creator . ' ' . $msg  ?></p>
                              </div>
                        </div>
                  </div>
                  <div class="row" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-right: -15px; margin-left: -15px;">
                        <div class="col-md-12 col-xs-12" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float: left; width: 100%;">
                              <table class="table table-striped table-bordered" style="border-spacing: 0; border-collapse: collapse; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; width: 100%; max-width: 100%; margin-bottom: 20px; background-color: transparent; border: 1px solid #ddd;" bgcolor="transparent"><tbody style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
<tr style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; background-color: #f9f9f9;" bgcolor="#f9f9f9">
<td style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; line-height: 1.42857143; vertical-align: top; padding: 8px; border: 1px solid #ddd;" valign="top">Username:</td>
                                                <td style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; line-height: 1.42857143; vertical-align: top; padding: 8px; border: 1px solid #ddd;" valign="top">
                                                      <?php echo $username ?>
</td>
                                          </tr>
<tr style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
<td style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; line-height: 1.42857143; vertical-align: top; padding: 8px; border: 1px solid #ddd;" valign="top">Password:</td>
                                                <td style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; line-height: 1.42857143; vertical-align: top; padding: 8px; border: 1px solid #ddd;" valign="top">
                                                      <?php echo $password ?>
</td>
                                          </tr>
</tbody></table>
</div>
                  </div>
                  <div class="row" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-right: -15px; margin-left: -15px;">
                        <div class="col-md-12 col-xs-12" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float: left; width: 100%;">
                              <div class="alert alert-danger" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-bottom: 20px; border-radius: 4px; color: #a94442; background-color: #f2dede; padding: 15px; border: 1px solid #ebccd1;">
                                    <p style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin: 0;">To reset your temporary password <a href="<?php echo $link ?>" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #337ab7; text-decoration: none; background-color: transparent;">Click Here</a></p>
                              </div>							
                        </div>
                  </div>
                  <div class="row" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-right: -15px; margin-left: -15px;">
                        <div class="col-md-12 col-xs-12" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float: left; width: 100%;">
                              <blockquote style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-size: 17.5px; border-left-width: 5px; border-left-color: #eee; border-left-style: solid; margin: 0 0 20px; padding: 10px 20px;">
                                    <p style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin: 0 0 10px;">Thank you,</p>
                                    <a href="<?php echo base_url() ?>" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #337ab7; text-decoration: none; background-color: transparent;">
                                          <footer style="display: block; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-size: 80%; line-height: 1.42857143; color: #777;"><cite title="<?php echo $this->config->item('site_title');?>" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                                                      <?php echo $this->config->item('site_title');?>
                                                </cite>
                                          </footer></a>
                              </blockquote>
                        </div>
                  </div>
                  <div class="row" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-right: -15px; margin-left: -15px;">
                        <div class="col-md-12 col-xs-12" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float: left; width: 100%;">
                              <div class="well" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; min-height: 20px; margin-bottom: 20px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); background-color: #f5f5f5; padding: 19px; border: 1px solid #e3e3e3;">
                                    <h3 style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; font-family: inherit; font-weight: 500; line-height: 1.1; color: inherit; margin-top: 20px; margin-bottom: 10px; font-size: 24px;">Contact Info</h3>
                                    <address style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin-bottom: 20px; font-style: normal; line-height: 1.42857143;">
                                    <strong style="font-weight: bold; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                                          <?php echo $creator ?></strong>
                                    <br style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo $department ?><br style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><abbr title="Phone" style="border-bottom-width: 1px; border-bottom-style: dotted; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; cursor: help; border-bottom-color: #777;">P:</abbr>
                                    <a href="tel:<?php echo $phoneNumber ?>" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #337ab7; text-decoration: none; background-color: transparent;">
                                          <?php echo $phoneNumber ?></a>
                                    <br style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><abbr title="Email" style="border-bottom-width: 1px; border-bottom-style: dotted; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; cursor: help; border-bottom-color: #777;">E:</abbr> 
                                    <a href="mailto:<?php echo $email ?>" style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #337ab7; text-decoration: none; background-color: transparent;">
                                          <?php echo  $email ?></a>
</address>
                              </div>
                        </div>
                  </div>
            </div>
      </body>
</html>
