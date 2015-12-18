<script src="<?php echo base_url() ?>assets/js/fileinput.js"></script>
<!-- file upload form using ENCTYPE -->
<div class="container">
    <div class="row">
        <div class="well">
            <?php echo form_open('', $formDetails); ?>
                <?php foreach ($addDocumentData->tName as $name): ?>
                    <input type="hidden" id="secondary<?php echo $name ?>" name="secondary<?php echo $name ?>" value="" />
                    <input type="hidden" id="tablename<?php echo $name ?>" name="tablename<?php echo $name ?>" value="<?php echo $name ?>" />
                    <?php endforeach;?>
                        <label for="userfile">
                            <a class="body" tabindex="1" href="#" data-toggle="popover" title="File Location" data-content='<p>  This box allows you to browse your local computer to find a file. Click
the "Browse..." button to bring up a popup prompt. Navigate to your file,
then click "Open". Once you have done this, the location of your file should
show up in the text box, and you can continue to fill out the rest of the
form.</p>'>File Location</a>
                        </label>
                        <input id="uploadFile" name="userfile[]" type="file" class="file" multiple>
                        <?php if ($this->session->admin == TRUE): ?>
                            <div class="form-group">
                                <div class="col-md-4 col-xs-12 col-sm-6">
                                    <label for="file_owner"> Assign to Owner</label>
                                    <select name="file_owner" id="file_owner" class="form-control">
                                        <?php foreach ($addDocumentData->availUsers as $user): ?>
                                            <option value="<?php echo $user->id ?>" <?php echo $user->selected ?>>
                                                <?php echo $user->last_name . ', ' . $user->first_name ?>
                                            </option>
                                            <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-xs-12 col-sm-6">
                                    <label for="file_department"> Assign to Department</label>
                                    <select name="file_department" id="file_department" class="form-control bootstro" data-bootstro-title="Assign Department" data-bootstro-content="Select the department that you wish to assign this file to.">
                                        <?php foreach ($addDocumentData->allDepartments as $dept):
	$selected = '';
	if ($dept->selected == 'checked'):
		$selected = 'checked';
	endif;
	?>
																				                                            <option value="<?php echo $dept->id ?>" <?php echo $selected ?>>
																				                                                <?php echo $dept->name ?>
																				                                            </option>
																				                                            <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php endif;?>
                                <div class="form-group">
                                    <div class="col-md-4 col-xs-12 col-sm-6">
                                        <label for="category"> <a class="body" href="#" data-toggle="popover" title="Category" data-content='<p>
  This box allows you to define which category your document corresponds
to. Make sure this fits, because many people will search for documents based
on this field.</p>'>Category</a></label>
                                        <select tabindex=2 id="category" name="category" class="form-control">
                                            <?php foreach ($addDocumentData->availCategories as $cat): ?>
                                                <option value="<?php echo $cat->id ?>">
                                                    <?php echo $cat->name ?>
                                                </option>
                                                <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Set Department rights on the file -->
                                <div class="well" style="background-color:#fff;">
                                    <div id="departmentSelect">
                                        <a class="body" href="#" style="text-decoration:none" data-toggle="popover" title="Add Permissions" data-content='<p>This box allows you to define a specific type of access for departments.</p>'>Permissions</a>
                                        <div class="tabbable" id="tabs-690341">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#department" data-toggle="tab">Departments</a>
                                                </li>
                                                <li>
                                                    <a href="#user" data-toggle="tab">Users</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active table-responsive" id="department">

                                                    <table id="departmentPermissionsTable" class="table table-striped table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <td>Department</td>
                                                                <td>Forbidden</td>
                                                                <td>None</td>
                                                                <td>View</td>
                                                                <td>Read</td>
                                                                <td>Write</td>
                                                                <td>Admin</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
foreach ($addDocumentData->deptPerms as $dept):
	$selected = '';
	$noneselected = '';
	echo $dept->selected;
	if ($dept->selected === 'checked'):
		$selected = 'checked';
	else:
		$noneselected = 'checked';
	endif;?>
																				                                                                <tr>
																				                                                                    <td>
																				                                                                        <?php echo $dept->name ?>
																				                                                                    </td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="-1">
																				                                                                    </td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="0" <?php echo $noneselected; ?>></td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="1" <?php echo $selected; ?> ></td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="2">
																				                                                                    </td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="3">
																				                                                                    </td>
																				                                                                    <td>
																				                                                                        <input type="radio" name="department_permission[<?php echo $dept->id ?>]" value="4">
																				                                                                    </td>
																				                                                                </tr>
																				                                                                <?php endforeach;?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane table-responsive" id="user">

                                                    <table id="userPermissionsTable" class="table table-striped table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <td>User</td>
                                                                <td>Forbidden</td>
                                                                <td>View</td>
                                                                <td>Read</td>
                                                                <td>Write</td>
                                                                <td>Admin</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
foreach ($addDocumentData->availUsers as $user):
?>
                                                                <tr>
                                                                    <td><small><?php echo $user->last_name . ', ' . $user->first_name ?></small></td>
                                                                    <td>
                                                                        <input type="radio" name="user_permission[<?php echo $user->id; ?>]" value="-1">
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" name="user_permission[<?php echo $user->id; ?>]" value="1">
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" name="user_permission[<?php echo $user->id; ?>]" value="2">
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" name="user_permission[<?php echo $user->id; ?>]" value="3">
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" name="user_permission[<?php echo $user->id; ?>]" value="4" <?php echo $user->selected ?>></td>
                                                                </tr>
                                                                <?php endforeach;?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">
                                        <a class="body" href="#" data-toggle="popover" title="Description" data-content='<p>This field serves as a short description for the file.
 Try to include keywords in the description that help users find this file in the search functions.<p>'>
 Description</a></label>
                                    <input type="text" id="description" name="description" size="50" class="form-control" placeholder="ie... Weekly Sales Report">
                                </div>
                                <div class="form-group">
                                    <label for="comment">
                                        <a class="body" href="#" data-toggle="popover" title="Comments" data-content='<p>No one knows this file as good as you do.
 Be sure to write any neccesary instructions for this file here,
 these will show up on the file details page among other places.<p>'>
Comments</a></label>
                                    <textarea id="comment" name="comment" class="form-control" placeholder="To view this file, you must download..."></textarea>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit" id="addDocumentsForm" title="Add Document">
                                        <i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
<script src="<?php echo base_url() ?>assets/js/ajaxfileupload.js"></script>
<script>
$(document).ready(function() {
    $('#addDocForm').ajaxUpload({
        global: true, // Trigger global ajax events
        url: 'add/doUploadAjax', // Replaces the form url
        iframeID: 'iframe-post-form', // Iframe ID.
        json: true, // Parse server response as a json object.
        post: function() {}, // Executed on submit
        complete: function(r) { // Executed after response from the server has been received
            console.log(r);
            if (r.status == "success") {
                alertify.success(r.msg, null);
                $('#addDocForm').each(function() {
                    this.reset();
                });
            } else if (r.status == "error") {
                alertify.error(r.msg, null);
            }
        }
    });

    $('[data-toggle="popover"]').popover({
        html: true,
        trigger: 'hover'
    });

    (function($) {
        var allPanels = $('.accordion > dd').hide();
        $('.accordion > dt > a').click(function() {
            allPanels.slideUp();
            $(this).parent().next().slideDown();
            return false;
        });
    })($);

    departmentPermissionsTable = $('#departmentPermissionsTable');

    if (departmentPermissionsTable && departmentPermissionsTable.length > 0) {
        var oTable = departmentPermissionsTable.dataTable({
            "bPaginate": false,
            "bAutoWidth": false
        });
    }
    //$('input[name="user_permission[<?php echo $this->session->id; ?>]"][value="4"]').attr('checked','checked');
    userPermissionsTable = $('#userPermissionsTable');
    if (userPermissionsTable && userPermissionsTable.length > 0) {
        var oTable2 = userPermissionsTable.dataTable({
            "bPaginate": false,
            "bAutoWidth": true
        });
    }

});
</script>
</body>

</html>
