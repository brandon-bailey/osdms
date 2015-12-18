<div class="modal fade" role="dialog" id="deleteDepartmentModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal" ><i class="fa fa-times"></i></a>
    <div class="text-center">
	<h3 style="text-transform: capitalize;">Delete <?php echo $currentDept->name ?></h3>
	</div>
  </div> 
  <div class="modal-body">
  <?php echo form_open('','id="deleteDeptForm" class="form-vertical" enctype="multipart/form-data"')?>
    <form class="form-vertical" enctype="multipart/form-data"> 
	<div class="text-center">
		<div class="row">
            <div class="col-md-12">			
                    <div class="jumbotron">
					<div class="text-center">
					<div class="row">
					<h3>ID# : <?php echo $currentDept->id ?></h3>
					<input type="hidden" name="deleteId" id="deleteDept" value="<?php echo $currentDept->id ?>">
							 </div>
							 </div>
							 <div class="text-center">
					 <div class="row">					
					<h3> Name: <?php echo $currentDept->name ?></h3>		
					 </div>
				</div>
					</div> 
			</div>
		</div>	
	</div>
	<div class="row">
	          <div class=" col-md-offset-3  col-md-6">
				<div class="form-group" id="assignDept" >
				<label class="control-label">Department to Reassign:</label>
                        <select  class="form-control " name="assignId" id="departmentToAssign" name="item">
						<option value="default">Select a Department</option>
                        <?php	foreach($assignDept as $row): ?>
								<option value="<?php echo $row->id ?>">
								<?php echo $row->name ?>
								</option>
								<?php endforeach; ?>
                        </select>
						<span class="help-block">All documents and users assigned to the deleted department will be transferred to this department.</span>
				</div>		
			</div>
	</div>
			<div class="text-center">         
				<div class="row">	
                    <div class="btn-group">
							<button id="deleteDepartment" class="btn btn-danger" style="text-transform: capitalize;" type="button" name="submit">
								<i class="fa fa-trash"></i>Delete
							</button>
							<button class="btn btn-warning" data-dismiss="modal" name="closeModal">
								Cancel
							</button>
					</div>
				</div>	
            </div>
</form>  
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal">Close</a>
  </div>
  </div>
  </div>
</div>
<script>
	$('button#deleteDepartment').on('click', function(e){
	e.preventDefault();
	var assignDept = $('select#departmentToAssign');
	var deleteDept = $('input#deleteDept');
	if (assignDept.val() !="default"){
	swal({
		title: "Are you sure?",
		text: "This will delete "+deleteDept.attr('name'),
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete!',
		closeOnConfirm: true
	},
	function(){		
			$.ajax({
				type:'post',
				url: "department/deletedepartment",
				dataType:'json',
				data:$('form#deleteDeptForm').serialize(),				
				success:function(data){
					$('#deleteDepartmentModal').modal('hide');
					$('#deleteDepartmentModal').remove();
					$('.modal-backdrop').remove();
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						alertify.success(data.msg,null);
						window.setTimeout(function(){location.reload()},3000);
					}
					
				}
			})	
	});
	}
	else{
		alertify.error("Please select a department before attempting to delete.",null);
	}
});	
</script>
