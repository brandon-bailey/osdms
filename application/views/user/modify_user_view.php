<div class="container">
	<div class="row-fluid">
		<div class="text-center">
			<h3>Modify <?php echo $userDetails->username ?></h3>
		</div>

    <?php echo form_open('','id="changeAvatarForm" '); ?>
    <div class="text-center">
					<img id="userAvatar" class="img-responsive img-rounded" 
		src="data:image/jpeg;base64,<?php echo base64_encode($newUserObj->getAvatar())?>" 
		alt="<?php echo $userDetails->first_name .' '. $userDetails->last_name?>" 
		data-toggle="tooltip" data-placement="bottom" title="<?php echo $userDetails->first_name .' '. $userDetails->last_name ?>" >
		
			<div class="form-group">			
				<h3 itemprop="name"><?php echo $userDetails->first_name .' '. $userDetails->last_name ?></h3>			
				<input type="file" name="userfile" class="file" id="changeAvatar" >		
		</div>
	</div>
  <?php echo form_close();?>
  
  <?php echo form_open('',$formDetails); ?>	

				<div class="form-group">
						 <label for="id" class="col-sm-2 control-label">ID</label>
							<div class="col-sm-8">
								<p><?php echo $userDetails->id ?></p>								
								<input class="form-control" type="hidden" name="id" value="<?php echo $userDetails->id ?>">
							</div>
				</div> 
					
					<div class="form-group">							
						<label for="last_name" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-8">
						<input class="form-control" name="last_name" type="text" value="<?php echo $userDetails->last_name ?>" minlength="2" maxlength="255" required>
						</div>
					</div> 
						
					<div class="form-group">
						<label for="first_name" class="col-sm-2 control-label">First Name</label>	
						<div class="col-sm-8">
						<input class="form-control" name="first_name" type="text" value="<?php echo $userDetails->first_name ?>" minlength="2" maxlength="255" required>
						</div>
					</div> 
						
					<div class="form-group">
						<label for="username" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-8">
						<input class="form-control" name="username" type="text" value="<?php echo $userDetails->username ?>" minlength="2" maxlength="25" required>
							</div>
							</div> 
						
						<div class="form-group">
						<label for="phone" class="col-sm-2 control-label">Phone Number</label>
						<div class="col-sm-8">
						<input class="form-control" name="phone" type="tel" value="<?php echo $userDetails->phone ?>" maxlegnth="20">
							</div>
							</div> 		 
<?php if($this->config->item('authen') == 'mysql' && $this->uid == $userDetails->id): 
?>
                   <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-8">
                    <input class="form-control" name="password" type="password" minlength="8">
					  <span class="help-block">Leave empty if unchanged</span>
					</div>                  
              </div>
<?php  endif; ?>
			<div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>     
				<div class="col-sm-8">
                <input name="email" type="email" value="<?php echo $userDetails->email; ?>" class="form-control email" maxlength="50" required>
				</div>
				</div>
				
		<div class="form-group">             
                <label for="department" class="col-sm-2 control-label">Department</label>
				<div class="col-sm-8">
                <select class="form-control " name="department" <?php echo $mode; ?>>
<?php		foreach($allDepts as $row) :
					if ($row->id == $newUserObj->getDeptID()):?>
                               <option selected value="<?php echo $row->id ?>"><?php echo $row->name ?></option>                      
						<?php else:    ?>                    
                                <option value=" <?php echo $row->id ?>"><?php echo $row->name ?></option>
        <?php  endif;
                endforeach;?>
                </select>
				</div>
				</div> 
				

<?php if($this->userObj->isAdmin()): ?>		  
	<div class="form-group">               
					<label for="reviewer_list" class="col-sm-2 control-label">Reviewer For</label>
               <div class="col-sm-8">
                <select class="form-control multiView" id="reviewer_list" name='department_review[]' multiple="multiple" <?php echo $mode; ?>>
<?php 	foreach($allDepts as $all):
					$found = false;
					if(isset($userReviewDepts)):
						foreach($userReviewDepts as $depts) :							
							if($all->id == $depts->dept_id): ?>
								<option value="<?php echo $all->id ?>" selected><?php echo $all->name?></option>
								 <?php $found = true;?>						
					<?php	endif;						
					endforeach;
					endif;
						if(!$found):?>
								<option value="<?php echo $all->id ?>"><?php echo $all->name?></option>						
			<?php endif;	endforeach;	?>
                        </select>
						</div>
						</div> 
					<?php	 endif;	
                $canAdd = '';
                $canCheckin = '';
                if($newUserObj->canAdd() == 1) {
                    $canAdd = "checked";
                }
                if($newUserObj->canCheckin() == 1) {
                    $canCheckin = "checked";
                }
                ?>
				<div class="form-group">                 				
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label for="admin" data-toggle="tooltip" title="Can this user create, delete, and modify certain settings?">
								<?php if($newUserObj->isAdmin()):?>           
									<input name="admin" type="checkbox" value="1" checked <?php echo $mode ?> id="cb_admin">          
										<?php else:  ?>              
										<input name="admin" type="checkbox" value="1"  <?php echo $mode ?> id="cb_admin">
								<?php  endif; ?>
							Admin</label> 
						</div>
					</div>
				</div>  					
					
					
				<div class="form-group">
					 <div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>               
								<input name="can_add" type="checkbox" value="1" <?php echo $canAdd; ?> id="cb_can_add">
							Can Add?</label>  
						</div> 
					</div>
				</div>
			
				 <div class="form-group">
					 <div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>                 
								<input name="can_checkin"  type="checkbox" value="1" <?php echo $canCheckin; ?> id="cb_can_checkin">
							Can Checkin?  </label>
						</div> 
				   </div>
				 </div> 
				   
				 <div class="text-center;">
					<div class="btn-group">
						<button class="btn btn-primary positive" type="button" id="submitModificationForm" name="submit" title="Click Here to Update User">
							<i class="fa fa-refresh"></i> Update
						</button>		
						
						<a class="btn btn-warning cancel" name="closeModal"  title="Click Here to Cancel">
							Cancel
						</a>
					</div>
                </div>  
  <?php echo form_close() ?>
  </div>
  </div>


<script src="<?php echo base_url()?>assets/js/fileinput.js"></script>
<script src="<?php echo base_url()?>assets/js/ajaxfileupload.js"></script>
<script>
$(document).ready(function(){
var $input = $("#changeAvatar");
$input.fileinput({
	showCaption: false,
	showPreview: false,
	showRemove: false,
	dropZoneEnabled: false,
    allowedFileExtensions: ["jpg", "png", "gif"]
}).on("filebatchselected", function(event, files) 
{
	$( "#changeAvatarForm" ).submit();	
});

$('#changeAvatarForm').ajaxUpload({
			global : true,                     // Trigger global ajax events
			url : 'profile/changeavatar',                    // Replaces the form url
			iframeID : 'iframe-post-form',       // Iframe ID.			            
			post : function () {},            // Executed on submit
			complete: function (r) {     // Executed after response from the server has been received				
			 $('img#userAvatar').attr( "src", 'data:image/jpeg;base64,'+r);
			 $('div.btn-file').attr('class','hidden');
			 $('div.caption').append('<form id="avatarAction">'+
			 '<button class="btn btn-success" id="keepNewAvatar" value="save" title="Keep New Upload">'+
			 '<i class="fa fa-thumbs-up"></i></button>'+
			 '<button class="btn btn-danger" id="deleteNewAvatar" value="delete" title="Revert"><i class="fa fa-thumbs-down"></i></button></form>');
			}
});

$(document).on('click', 'button#keepNewAvatar', function(e){
e.preventDefault();
			var img = $('img#userAvatar').prop('src');
			var baseImg = img.split(',')[1];	
			$.ajax({
				type:'post',
				datatype:'json',
				url: "profile/saveavatar",				
				data:{'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',image:baseImg},				
				success:function(data)
				{
					console.log(data);
				}
			})
});		

$(document).on('click', 'button#deleteNewAvatar', function(){	
			$.ajax({
				type:'post',
				datatype:'json',
				url: "profile/deleteavatar",				
				data:{'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'},				
				success:function(data)
				{
					 $('img#userAvatar').attr( "src", 'data:image/jpeg;base64,'+data);
				}
			})	
});	

$(document).on('click','button#submitModificationForm',function(){
	swal({
		title: "Are you sure?",
		text: "This will change the settings immediately",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, submit!',
		closeOnConfirm: true
	},
	function(){		
			$.ajax({
				type:'post',
				url: "user/saveUserChanges",
				dataType:'json',
				data:$('form#modifyUserForm').serialize(),				
				success:function(data){
					console.log(data);
					if (data.status == "error")
					{
					alertify.error(data.msg,null);
					}
					else{
						$('#modifyUserModal').remove();	
						$('.modal-backdrop').remove();						
						alertify.success(data.msg,null);
					}					
				}
			})	
	});	
});
});
</script>