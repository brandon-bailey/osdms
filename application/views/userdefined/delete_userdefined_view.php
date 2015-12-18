<div class="modal fade" role="dialog" id="deleteUdfModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <div class="centered">
	<h3 >Delete User Defined Field</h3>
	</div>
  </div> 
  <div class="modal-body">
          <form role="form"  id="deleteUdfForm" enctype="multipart/form-data">
			
				<div class="form-group">	
					<select class="form-control" name="id" id="item">
						<?php foreach($fields as $field) : ?>
							<option value="<?php echo $field->id; ?>"><?php echo $field->display_name ?></option>
						<?php endforeach;?>
					</select>
				</div>	
				
              
                    <div class="centered">
					<div class="btn-group">
                        <button class="btn btn-danger" id="deleteUdf" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete User Defined Field"><i class="fa fa-trash-o"></i> Delete Field</button>
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
	$('button#deleteUdf').on('click', function(e){
	e.preventDefault();
	swal({
		title: "Are you sure?",
		text: "This will delete this User Defined Field",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete!',
		closeOnConfirm: true
	},
	function(){	
			$.ajax({
				type:'POST',
				url: "userdefinedfields/delete",
				dataType:'json',
				data:$("#deleteUdfForm").serialize(),	
				beforeSend:function(){
					// this is where we append a loading image
					$('#deleteUdfModal .modal-body').html('<div class="centered"><i class="fa fa-cog fa-spin fa-5x"></i><p>Please wait while we safely delete the appropriate fields.</p></div>');
				},
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						$('#deleteUdfModal').modal('hide');
						$('.modal-backdrop').remove();
						$('#deleteUdfModal').remove();
						alertify.success(data.msg,null);
					}
				
				}
			})	
	})	
});	
</script>