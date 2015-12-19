<div class="container">
<div class="jumbotron" >
<h1 class="text-center capitalize" >
<?php echo $file; ?> Configuration Settings
<a href="javascript:void(0);" title="Help" data-target="#helpModal" data-toggle="modal">
<i class="fa fa-question" ></i>
</a>
</h1>
</div>
    <div class="row-fluid">
        <div class="well">
            <?php echo form_open('', 'class="form" enctype="multipart/form-data" id="settingsForm"'); ?>
           		 <input type="hidden" name="file" id="file" value="<?php echo $file; ?>">
                <?php foreach ($settings as $key => $value):
	$value = str_replace(APPPATH, "", $value);
	?>
																																									                    <div class="form-group">
																																									                        <label style="text-transform:capitalize;" for="<?php echo $key ?>">
																																									                            <?php echo str_replace('_', ' ', $key) ?>
																																									                        </label>
																																									                        <?php if ($key == 'favicon'): ?>
																																									                            <?php if (file_exists(base_url() . $value)): ?>
																																									                                <img alt="favicon" src="<?php echo base_url() . $value ?>">
																																									                                <?php else: ?>
                                    <p>No current favicon set. </p>
                                    <?php endif;?>
                                        <input type="file" accept="image/*">
                                        <p class="help-block">For the best overall look, a PNG image is recommended with the same width x height.</p>
                                        <?php else: ?>
                                            <input type="text" class="form-control" id="<?php echo $key ?>" name="<?php echo $key ?>" value="<?php echo $value ?>">
                                            <?php endif;?>
                    </div>
                    <hr>
                    <?php endforeach;?>
                        <div class="text-center">
                            <div class="btn-group">
                                <button class="btn  btn-primary positive" type="button" id="saveButton" name="saveButton" value="Save">Save</button>
                                <button class="btn  btn-primary btn-danger" type="button" id="cancelButton" name="cancelButton" value="Cancel">Cancel</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
$('button#cancelButton').on('click', function() {
    swal({
            title: "Are you sure you want to cancel?",
            text: "If any settings were changed, they will not be saved.",
            type: "warning",
            confirmButtonColor: "#DD6B55",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Leave",
            animation: "slide-from-top"
        },
        function() {
            window.location = 'settings';
        })
});

$('button#saveButton').on('click', function() {
    swal({
            title: "Are you sure you want to save these changes?",
            text: "This will take effect immediately.",
            type: "warning",
            confirmButtonColor: "#DD6B55",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Save",
            animation: "slide-from-top"
        },
        function() {
            $.ajax({
                method: 'post',
                url: "saveSettings",
                dataType: 'json',
                data: $('form#settingsForm').serialize(),
                success: function(data) {
                    alertify.log("Your settings have successfully been saved.", null);
                }
            }); //end of ajax
        })
});
</script>
<?php
if (file_exists(APPPATH . 'views/admin/help/' . $file . '_help.php')) {
	$this->load->file(APPPATH . 'views/admin/help/' . $file . '_help.php');
}

?>