 <div class="container"> 
 	<div class="row">
	<div class="well">
	    <center>
			<h1>Pick a User to Delete</h1>
		</center>
  <form class="form-vertical" enctype="multipart/form-data"> 
	<center>
		<div class="row">
            <div class=" col-md-offset-4  col-md-4">
				<div class="btn-group">
                        <select  class="form-control " id="selectDeleteUser" name="item">
						<option value="default">Select a User</option>
                        <?php	foreach($allUsers as $row): ?>
								<option value="<?php echo $row->id ?>" id="<?php echo $row->username ?>"><?php echo $row->last_name . ', ' . $row->first_name . ' - ' . $row->username ?></option>
								<?php endforeach; ?>
                        </select>
				</div>		
			</div>
		</div>	
	</center>
	<br/>
			<center>         
				<div class="row">	
                    <div class="btn-group">
							<button id="deleteUser" class="btn btn-danger" type="button" name="submit" value="delete">
								<i class="fa fa-trash"></i> Delete
							</button>
							<button class="btn btn-warning" name="cancel" onclick="goBack()">
								Cancel
							</button>
					</div>
				</div>	
            </center>
</form>
</div>
</div>
</div>
<script>
jQuery('button#deleteUser').on('click', function(e){
	e.preventDefault();
	var user = jQuery('select#selectDeleteUser');
	if (user.val() !="default"){
	swal({
		title: "Are you sure?",
		text: "This will delete "+ user.find('option:selected').attr('id'),
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete!',
		closeOnConfirm: true
	},
	function(){		
			jQuery.ajax({
				type:'post',
				url: "deleteuser",
				dataType:'json',
				data:{id:user.val()},				
				success:function(data){
					if (data.status == "error")
					{
					alertify.error(data.msg,null);
					}
					else{
						alertify.success(data.msg,null);
					}
					window.setTimeout(function(){location.reload()},3000);
				}
			})	
	});
	}
	else{
		alertify.error("Please select a user before attempting to delete.",null);
	}
});	
</script>

<?php	   $this->load->view('templates/footer'); ?>