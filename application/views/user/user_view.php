<div id="userPageContent" style="overflow:auto;">
<div class="container">
	<div class="row-fluid">

		<a href="user/adduser" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg"><i class="fa fa-user-plus fa-2x"></i><br />Add</a>
		<a href="#" id="delete" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-user-times fa-2x"></i><br />Delete</a>
        <a href="#" id="modify" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-refresh fa-2x"></i><br />Modify</a>
       <a href="#" id="display" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-eye fa-2x"></i><br />Display</a>

</div>
</div>

<div class="modal fade" role="dialog" id="userPageModal" >
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" ><i class="fa fa-times"></i></a>
    <div class="text-center">
	<h3 style="text-transform: capitalize;"></h3>
	</div>
  </div> 
  <div class="modal-body">
  <?php echo form_open('','class="form-vertical" id="userForm" enctype="multipart/form-data"')?>
	<div class="text-center">
		<div class="row">
            <div class=" col-md-offset-3  col-md-6">
				<div class="btn-group">
                        <select  class="form-control" name="id">
						<option value="default">Select a User</option>
                        <?php	foreach($allUsers as $row): ?>
								<option value="<?php echo $row->id ?>" id="<?php echo $row->username ?>">
								<?php echo $row->last_name . ', ' . $row->first_name . ' - ' . $row->username ?>
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
							<button id="userFormAction" class="btn btn-primary" style="text-transform: capitalize;" type="button" name="submit" value="">
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
</div>
<script>
$(document).ready(function(){
$(document).on('click', 'a.triggerModal' ,function(){	
	var action = $(this).attr('id')
		console.log(action);
		if(action.length !='')	
		{			
				$('#userPageModal .modal-header h3').html(action+" User");	
				$('#userPageModal .modal-body form select').attr('id',action);
				$('#userPageModal .modal-body form').prop('action', action +'user');
				$('#userPageModal button#userFormAction').html(action);			
				$('#userPageModal button#userFormAction').val(action);		
				$('#userPageModal').modal('show');			
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
$('button#userFormAction').on('click',function(){
	var actionValue = $(this).val();
	var user = $('select#'+actionValue);
			if(actionValue=="display"){
			$.ajax({
				type:'post',
				url: "user/"+actionValue+"user",				
				data:$('form#userForm').serialize(),				
				success:function(data){
					$('#userPageModal').modal('hide');
					$('body').append(data);
					$('#displayUserModal').modal('show');
				}
			})		
		return;
		}		
	if (user.val() !="default"){		
			swal({
		title: "Are you sure?",
		text: "This will  " + actionValue +"<strong> "+ user.find('option:selected').html()+ "</strong>" ,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, '+actionValue +'!',
		closeOnConfirm: true,
		html: true
	},
	function(){		
	if(actionValue=="modify"){		
		console.log("should be submitting");			
		$.ajax({
				type:'post',
				url: "user/modifyuser",
				data:$('form#userForm').serialize(),				
				success:function(data){					
					$('div#userPageContent').html(data);
						$('.modal-backdrop').remove();
						var deviceWidth = 0;
						$(window).bind('resize', function () {
							deviceWidth = $('[data-role="page"]').first().width()
						}).trigger('resize');
				}
			})	
		
		return;
		}
			$.ajax({
				type:'post',
				url: "user/"+actionValue+"user",
				dataType:'json',
				data:$('form#userForm').serialize(),				
				success:function(data){
					if (data.status == "error")
					{
					alertify.error(data.msg,null);
					}
					else{
						alertify.success(data.msg,null);
					}					
				}
			})	
	});
	}
	else{
		alertify.error("Please select a user before attempting to "+ actionValue + " a user",null);
	}	
});
});
</script>