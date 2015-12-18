<div class="container">
	<div class="row-fluid">

		<a href="#" id="add" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-user-plus fa-2x"></i><br />Add</a>
		<a href="#" id="delete"  class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-user-times fa-2x"></i><br />Delete</a>
        <a href="#" id="modify" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-refresh fa-2x"></i><br />Modify</a>

       <a href="#" id="display" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-eye fa-2x"></i><br />Display</a>
</div>
</div>

<div class="modal fade" role="dialog" id="departmentPageModal" >
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" ><i class="fa fa-times"></i></a>
    <div class="text-center"><h3 style="text-transform: capitalize;"></h3></div>
  </div> 
  <div class="modal-body">
  <?php echo form_open('','class="form-vertical" enctype="multipart/form-data" id="departmentForm"') ?>
	<div class="text-center">
		<div class="row">
            <div class=" col-md-offset-3  col-md-6">
				<div class="form-group">
                        <select  class="form-control " id="departmentToDelete" name="id">
						<option value="default">Select a Department</option>
                        <?php	foreach($allDepartments as $row): ?>
								<option value="<?php echo $row->id ?>">
								<?php echo $row->name ?>
								</option>
								<?php endforeach; ?>
                        </select>
				</div>		
			</div>
		</div>	
	</div>
	<br/>
			<div class="text-center">        
				<div class="row">	
                    <div class="btn-group">
							<button id="departmentFormAction" class="btn btn-primary" style="text-transform: capitalize;" type="button" name="submit" value="">
								<i class="fa fa-trash"></i>
							</button>
							<button class="btn btn-warning" name="cancel" data-dismiss="modal">
								Cancel
							</button>
					</div>
				</div>	
            </div>
</form>
  
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" >Close</a>
  </div>
  </div>
  </div>
</div>
<script>
$(document).on('click', 'a.triggerModal' ,function(){	
	var action = $(this).attr('id')
		console.log(action);
	if(action=="add"){
			$.ajax({
				type:'post',
			data: {<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>'},
				url: "department/"+action+"department",			
				success:function(data){					
					$('body').append(data);
					$('#addDepartmentModal').modal('show');
				}
			})
			return;
	}	
		if(action.length !='')	
		{
				$('#departmentPageModal .modal-header h3').html(action+" Department");				
				$('#departmentPageModal button#departmentFormAction').html(action);			
				$('#departmentPageModal button#departmentFormAction').val(action);		
				$('#departmentPageModal').modal('show');			
		}
				else{					
					alertify.error('There was a problem with your selection',null);
				}
});
$(document).on('click','[name="closeModal"]',function(){
	var modalid = $(this).closest('div.modal').attr('id');	
	$('#'+modalid).remove();	
	$('.modal-backdrop').remove();
});

$('button#departmentFormAction').on('click', function(e){
	var action = $(this).val();
	var deptId = $('form #departmentToDelete').find('option:selected').val();
	console.log(action);
	if(action =="delete")
	{
			$.ajax({
				type:'post',
				url: "department/getalldepartmentsexcept",				
				data:{id:deptId,<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>'},				
				success:function(data){
					$('#departmentPageModal').modal('hide');
					$('body').append(data);
					$('#deleteDepartmentModal').modal('show');
				}
			})	
	}
	if(action =="display")
	{
			$.ajax({
				type:'post',
				url: "department/displaydepartment",				
				data:{id:deptId,<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>'},				
				success:function(data){
					$('#departmentPageModal').modal('hide');
					$('body').append(data);
					$('#displayDepartmentModal').modal('show');
				}
			})	
	}
	if(action =="modify")
	{
			$.ajax({
				type:'post',
				url: "department/modifydepartment",				
				data:$('form#departmentForm').serialize(),				
				success:function(data){
					$('#departmentPageModal').modal('hide');
					$('body').append(data);
					$('#modifyDepartmentModal').modal('show');
				}
			})	
	}	
});
</script>