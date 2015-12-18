<div class="modal fade" role="dialog" id="modifyDepartmentModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <div class="text-center">
	<h3 >Displaying <?php echo $deptDetails[0]->name ?></h3>
	</div>
  </div> 
  <div class="modal-body">
		<div class="row-fluid">
			<div class="well">
			<div class="text-center">
			<?php echo form_open('','role="form" id="modifyDeptForm" method="POST" enctype="multipart/form-data"')?>                                      
										<div class="form-group">
                                            <label for="departmentName" class="control-label">Department</label>                    
                                            <input class="form-control" type="text" id="departmentName" name="name" value="<?php echo $deptDetails[0]->name; ?>" maxlength="40" required>
                                            <input type="hidden" id="departmentId" name="id" value="<?php echo $deptDetails[0]->id; ?>">
										</div>										
										<div class="form-group">
											<label for="departmentColor">Color </label>
											<input type="color" id="departmentColor" name="color" class="form-control" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $deptDetails[0]->color ?>">
										</div>                     
                                            <div class="btn-group">
                                                <button class="btn btn-primary" type="button" id="modifyDepartment" title="Update Department">Save</button>
                                                <button class="btn btn-warning" >Cancel</button>
                                            </div>                            
                           
                        </form>
						</div>
					</div>
			</div>	       
                      
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal" >Close</a>
  </div>
  </div>
  </div>
</div>	
<script>
	$('button#modifyDepartment').on('click', function(e){
	e.preventDefault();
	var departmentName = $('form#modifyDeptForm input#departmentName');
	if (departmentName.val() !=""){	
			$.ajax({
				type:'post',
				url: "department/savedepartmentmodification",
				dataType:'json',
				data:$('form#modifyDeptForm').serialize(),				
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						$('#modifyDepartmentModal').modal('hide');
						$('.modal-backdrop').remove();
						$('#modifyDepartmentModal').remove();
						alertify.success(data.msg,null);
						window.setTimeout(function(){location.reload()},4000);
					}
				
				}
			})	
	}
	else{
		alertify.error("Please select a department before attempting to delete.",null);
	}
});	
</script>