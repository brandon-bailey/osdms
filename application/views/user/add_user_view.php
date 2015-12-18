<script src="<?php echo base_url()?>assets/js/validate.js"></script>
<div class="container">
		<div class="row">
		<div class="well">
		<?php echo form_open('','role="form" class="form" name="addUser" id="addUser" enctype="multipart/form-data"') ?>
			<div class="form-group">
              <label  for="last_name" class="control-label">Last Name</label>			
			  <input name="last_name" type="text" class="form-control" minlength="2" maxlength="255" required>			 
              </div>
			  
			  <div class="form-group">
						<label for="first_name" class="control-label">First Name</label>				
						<input name="first_name" type="text"  class="form-control"  minlength="2" maxlength="255" required>			
				</div>
				
				<div class="form-group">
						<label for="username" class="control-label">Username</label>		
					<input name="username" type="text" class="form-control" minlength="5" maxlength="25" autocomplete="off" required >		      
				</div>
			 
				<div class="form-group">
                <label for="phone" class="control-label">Phone Number</label>				
                <input name="phone" class="form-control" type="tel" maxlength="20" autocomplete="off" required >
               </div>
	   
    <?php if($this->config->item('authen') == 'mysql'): ?>
             <div class="form-group">
			        <label for="password" class="control-label" title="Passwords are strongly encrypted, but longer is better the minimum is 8 characters">Password</label>
				<span class="help-block">Users will be emailed with their first time password to login and change.</span>
			</div>
<?php  endif; ?>
		<div class="form-group">
              <label for="email" class="control-label" title="What is this users email address?">Email Address</label>			  
				<input name="email" id="email" type="email" class="form-control email" maxlength="50" required>				
		</div>
				<div class="form-group">
					<label for="department" class="control-label" title="Which Department does this user belong to?">Department</label> 
                <select name="department" class="form-control">
				<?php $availDepartments = Department_model::getAllDepartments();	
				foreach($availDepartments as $row):?>
					<option id="department" value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
			<?php endforeach; ?>
                </select>
			</div>
			<div class="checkbox"  >
                <label for="admin" title="Click Here if this user will be an admin">		
                <input name="admin" type="checkbox" class="checkbox" value="1" id="admin" >
						Admin?</label> 
			</div>	
			
			<div class="checkbox">
				<label for="canAdd" title="Can this user add documents?">
					<input name="canAdd" type="checkbox" value="1" id="canAdd"  checked="checked">
					Can Add?</label>			
			</div>
		
		<div class="checkbox">
              <label for="canCheckin" title="Can this user check documents in?">           
                <input name="canCheckin" type="checkbox" value="1" id="canCheckin"  checked="checked">
				Can Check-In?</label>
		</div>
			
			
		<div class="form-group">
				<label for="departmentReview[]" class="control-label">Reviewer</label>
                <select class="form-control multiView" name="departmentReview[]" id="userReviewDepartmentsList" multiple />
<?php foreach($availDepartments as $row) :?>
					<option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
				<?php endforeach; ?>
		</select>
		</div>

<div class="text-center">
<div class="form-group">
        <div class="btn-group">
            <button id="submitButton" class="btn btn-success positive" type="submit" name="submit" value="Add User" title="Add User"><i class="fa fa-user-plus"></i> Add User</button>
            <button id="cancelButton" class="btn btn-warning negative cancel" name="cancel" title="Cancel">Cancel</button>
        </div>
</div>	
</form><!--Add User Form-->
</div>
</div>		
</div>
</div>
</div>
  <script>
$('button#submitButton').on('click', function(e){
	e.preventDefault();
	var formStatus = $('#addUser').validate().form();
	if (formStatus == true){
	swal({
		title: "Are you sure?",
		text: "This will create a new user!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, create!',
		closeOnConfirm: true
	},
	function(){		
			$.ajax({
				type:'post',
				url: "createnewuser",
				dataType:'json',
				data:$('#addUser').serialize(),				
				success:function(data){
					console.log(data);
				}
			})	
	});
	}
				else{
					alertify.error("Please fill all of the required fields",null);
				}
});	

  </script>