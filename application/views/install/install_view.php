<div class="header">
    <img src="<?php echo base_url() ?>assets/images/logo-128.png" class="center-block img-responsive" alt="Open Source Document Management System">
</div>
<div class="container">
    <h2>Welcome to the Open Source Document Management Systems Installation Page</h2>
</div>
<div class="container">
    <div class="row-fluid">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#configuration" aria-controls="configuration" role="tab" data-toggle="tab">Configuration</a></li>
                <li role="presentation"><a href="#database" aria-controls="database" role="tab" data-toggle="tab">Database</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="configuration">
                    <form name="userSettingsForm" action="javascript:submitUserSettings();" id="userSettingsForm" class="form-horizontal">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                        <!--User Login Credentials-->
                        <div class="form-group">
                            <label class="control-label">Admin Email<span class="star">&nbsp;*</span></label>
                            <input type="email" id="adminEmail" name="adminEmail" class=" form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Admin Username<span class="star">&nbsp;*</span></label>
                            <input type="text" id="adminUsername" name="adminUsername" class="form-control" value="admin" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Admin Password<span class="star">&nbsp;*</span></label>
                            <input type="password" id="adminPassword" name="adminPassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Admin Password<span class="star">&nbsp;*</span></label>
                            <input type="password" id="adminPasswordConfirm" name="adminPasswordConfirm" class="form-control" required>
                        </div>
                        <div class="form-group">
                        	<button type="submit" id="confirmUserAccountSettings" class="btn btn-primary">Confirm Settings</button>
                        </div>
                    </form>

                </div>
                <div role="tabpanel" class="tab-pane" id="database">
                    <form method="post" id="adminForm" class="form-validate form-horizontal">
                        <div class="form-group">
                            <label id="databaseTypeLbl" for="databaseType" class="control-label required">
                                Database Type<span class="star">&nbsp;*</span></label>
                            <select id="databaseType" name="databaseType" class="form-control required" required="required" aria-required="true">
                                <option value="mysql">MySQL</option>
                                <option value="mysqli" selected="selected">MySQLi</option>
                                <option value="pdomysql">MySQL (PDO)</option>
                            </select>
                            <p class="help-block">
                                This is probably "MySQLi" </p>
                        </div>
                        <div class="form-group">
                            <label id="databaseHostLbl" for="databaseHost" class="control-label required">
                                Host Name<span class="star">&nbsp;*</span></label>
                            <input type="text" name="databaseHost" id="databaseHost" value="localhost" class="form-control required" required="required" aria-required="true">
                            <p class="help-block">
                                This is usually "localhost" </p>
                        </div>
                        <div class="form-group">
                            <label id="databaseUserLbl" for="databaseUser" class="control-label required">
                                Username<span class="star">&nbsp;*</span></label>
                            <input type="text" name="databaseUser" id="databaseUser" value="admin" class="form-control required" required="required" aria-required="true">
                            <p class="help-block">
                                Either something as "root" or a username given by the host </p>
                        </div>
                        <div class="form-group">
                            <label id="databasePasswordLbl" for="databasePassword" class="control-label">
                                Password<span class="star">&nbsp;*</span></label>
                            <input type="password" name="databasePassword" id="databasePassword" value="" class="form-control" maxlength="99">
                            <p class="help-block">
                                For site security using a password for the database account is mandatory </p>
                        </div>
                        <div class="form-group">
                            <label id="databaseNameLbl" for="databaseName" class="control-label required">
                                Database Name<span class="star">&nbsp;*</span></label>
                            <div class="controls">
                                <input type="text" name="databaseName" id="databaseName" value="" class="form-control required" required="required" aria-required="true">
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/validate.js"></script>
<script>


function submitUserSettings()
{
 	var password = $('form#userSettingsForm input#adminPassword').val();
 	var confirmPassword = $('form#userSettingsForm input#adminPasswordConfirm').val();

 	if(password == confirmPassword)
 	{
		$.ajax({
            url: '<?php echo site_url(); ?>install/userSettings',
            type: "POST",
			dataType:'json',
            data:  $('form#userSettingsForm').serialize(),
            success: function(data){
				console.log(data);
            }
        });
	}
	else
	{
		return false;
	}
}

</script>
