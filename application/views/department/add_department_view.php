<div class="modal fade" role="dialog" id="addDepartmentModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <div class="text-center">
	<h3>Add Department</h3>
	</div>
  </div> 
  <div class="modal-body">
  <?php echo form_open('','role="form"  id="addDepartmentForm" enctype="multipart/form-data"') ?>
				<div class="form-group">		
                    <label for="departmentName">Department Name</label>          
                    <input name="name" id="departmentName" type="text" class="form-control" minlength="2" required placeholder="Human Resources">
					<span class="help-block">The name of the department</span>
				</div>				
				<div class="form-group">		
                    <label for="departmentColor">Color </label>          
                    <input name="color" id="departmentColor"  type="color" class="form-control" value="#ff0000">
					<span class="help-block">This color will help identify documents assigned to a particular department faster.</span>
				</div>                  
                    <div class="text-center">
					<div class="btn-group">
                        <button class="btn btn-success" id="addDepartment" type="button" title="Add this Department"><i class="fa fa-users"></i> Add Department</button>
						<button class="btn btn-warning" type="button"  name="closeModal" value="Cancel">Cancel</button>
                    </div>
					</div>
           </form>                        
  </div>
  
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal" >Close</a>
  </div>
  </div>
  </div>
</div>	

<script>
	$('button#addDepartment').on('click', function(e){
	e.preventDefault();
	var departmentName = $('input#departmentName');
	if (departmentName.val() !=""){	
			$.ajax({
				type:'post',
				url: "department/createdepartment",
				dataType:'json',
				data:$('form#addDepartmentForm').serialize(),				
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						$('#addDepartmentModal').modal('hide');
						$('.modal-backdrop').remove();
						$('#addDepartmentModal').remove();
						alertify.success(data.msg,null);
						window.setTimeout(function(){location.reload()},4000);
					}
				
				}
			})	
	}
	else
	{
		alertify.error("Please select a department before attempting to delete.",null);
	}
});	
</script>