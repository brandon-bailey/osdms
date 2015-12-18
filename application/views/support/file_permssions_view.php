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
					<div class="tab-pane active" id="department">
						        <table id="department_permissions_table" class="table table-striped table-condensed">
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
                <?php foreach ($availDepts as $dept){ ?>
                    <?php if ($dept->selected == 'selected'):
                         $selected=="checked='checked'";
                     else:
                        $noneselected=="checked='checked'"?>
                    <?php endif;?>
                <tr>
                    <td><?php echo $dept->name?></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="-1" <?php if ($dept->rights == '-1'):?>checked="checked"<?php endif;?> /></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="0" <?php if ($dept->rights == '0'):?>checked="checked"<?php endif; $noneselected;?>/></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="1" <?php if ($dept->rights == '1'):?>checked="checked"<?php endif; $selected;?> /></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="2" <?php if ($dept->rights == '2'):?>checked="checked"<?php endif;?> /></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="3" <?php if ($dept->rights == '3'):?>checked="checked"<?php endif;?>/></td>
                    <td><input type="radio" name="department_permission[<?php $dept->id?>]" value="4" <?php if ($dept->rights == '4'):?>checked="checked"<?php endif;?> /></td>
                </tr>
                    <?php $selected =""?>
                <?php };?>      
            </tbody>
        </table>
					</div>
					<div class="tab-pane" id="user">
						      <table id="user_permissions_table" class="table table-striped table-condensed">
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
                <?php foreach($availUsers as $user){
                if ($user->rights ==''):
                    $selected =="checked='checked'";				
                endif;?>

                <tr>
                    <td><small><?php echo $user->last_name.','. $user->first_name?></small></td>
                    <td><input type="radio" name="user_permission[<?php $user->id?>]" value="-1" <?php if($user->rights == '-1'): ?>checked="checked"<?php endif;?>/></td>
                    <td><input type="radio" name="user_permission[<?php $user->id?>]" value="1" <?php if($user->rights == '1'): ?>checked="checked"<?php endif;?>/></td>
                    <td><input type="radio" name="user_permission[<?php $user->id?>]" value="2" <?php if($user->rights == '2'): ?>checked="checked"<?php endif;?> /></td>
                    <td><input type="radio" name="user_permission[<?php $user->id?>]" value="3" <?php if($user->rights == '3'): ?>checked="checked"<?php endif;?> /></td>
                    <td><input type="radio" name="user_permission[<?php $user->id?>]" value="4" <?php if($user->rights == '4' || $user->id == $userId && $user->rights == ''): ?>checked="checked"<?php endif;?> /></td>
                </tr>
                <?php }?>       
            </tbody>
        </table>
					</div>
				</div>
			</div>

<script>
    jQuery(document).ready(function() {        
        (function(jQuery) {
            var allPanels = jQuery('.accordion > dd').hide();           
            jQuery('.accordion > dt > a').click(function() {
                allPanels.slideUp();
                jQuery(this).parent().next().slideDown();
                return false;
                });
         })(jQuery);

    department_permissions_table = jQuery('#department_permissions_table');
    
    if (department_permissions_table && department_permissions_table.length > 0) {
       var oTable = department_permissions_table.dataTable({
           
            "bPaginate": false,
            "bAutoWidth": false,
            "oLanguage": {
                "sUrl": "assets/language/DataTables/datatables." + langLanguage + ".txt"
            }
        });
    }
    
    user_permissions_table = jQuery('#user_permissions_table');
    if (user_permissions_table && user_permissions_table.length > 0) {
       var oTable2 = user_permissions_table.dataTable({
           
            "bPaginate": false,
            "bAutoWidth": true,
            "oLanguage": {
                "sUrl": "assets/language/DataTables/datatables." + langLanguage + ".txt"
            }
        });
    }
    });
</script>
