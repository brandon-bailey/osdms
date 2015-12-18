<div class="modal fade" role="dialog" id="addUdfModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <div class="centered">
	<h3 >Add User Defined Field</h3>
	</div>
  </div> 
  <div class="modal-body">
          <form role="form"  id="addUdfForm" enctype="multipart/form-data">
				<div class="form-group">		
                    <label for="udfName">Name </label>          
                    <input name="udfName" id="udfName" type="text" class="form-control" required maxlength="40">	
					<span class="help-block">This is how it will be stored in the database, It is suggested to keep this one word<br>
					IE.. If your Display Name is Reason for Upload, name this reason.
					</span>
				</div>		
				
				<div class="form-group">		
                    <label for="udfName">Display Name</label>          
                    <input name="displayName" id="displayName" type="text" class="form-control" required maxlength="30">
					<span class="help-block">The name that will be displayed to users</span>
				</div>	
				
				<div class="form-group">		
                    <label for="udfType">Type</label>          
                    <select class="form-control" id="udfType" name="udfType" required>
						<option value=1>Select List</option>
						<option value=4>Sub Select List</option>
						<option value=2>Radio Button</option>
						<option value=3>Text</option>               
					</select>
					<span class="help-block">This is the form element of the choice the user will have</span>
				</div>	
              
                    <div class="centered">
					<div class="btn-group">
                        <button class="btn btn-success" id="addUdf" type="button" data-toggle="tooltip" data-placement="bottom" title="Add a User Defined Field"><i class="fa fa-keyboard-o"></i> Add Field</button>
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
<script src="<?php echo base_url()?>assets/js/validate.js"></script>
<script>
	$('button#addUdf').on('click', function(e){
	e.preventDefault();
	var udfName = $('input#udfName');
	
	if ($("#addUdfForm").valid()){	
			$.ajax({
				type:'POST',
				url: "userdefinedfields/createudf",
				dataType:'json',
				data:$("#addUdfForm").serialize(),
				beforeSend:function(){
					// this is where we append a loading image
					$('#addUdfModal .modal-body').html('<div class="centered"><i class="fa fa-cog fa-spin fa-5x"></i><p>Please wait while we update the database.</p></div>');
				},
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						$('#addUdfModal').modal('hide');
						$('.modal-backdrop').remove();
						$('#addUdfModal').remove();
						alertify.success(data.msg,null);						
					}
				
				}
			})	
	}
	else{
		alertify.error("Please select a department before attempting to delete.",null);
	}
});	
</script>