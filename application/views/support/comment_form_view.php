<div class="row-fluid">
<form class="form" name="authorNoteForm" id="authorNoteForm">
	<div class="form-group">
	<label for="to">Email To</label>
		<div class="control">
		<input type="text" class="form-control" name="to" id="emailTo" value="Author(s)" <?php echo isset($accessMode)?> required>
                 </div>                    
                    </div>                
          <div class="form-group">
		  <input type="text" class="form-control" name="subject" id="emailSubject" placeholder="Email Subject"<?php echo isset($accessMode)?>>
                       </div>
            <div class="form-group">
			<textarea rows="4" class="form-control" id="emailComments" name="comments" <?php echo isset($accessMode)?>id="comment" placeholder="Comments"></textarea>
			</div>             

			 <div class="checkbox">
                           <label class="checkbox" for="sendToAll">                     
                               <input type="checkbox" id="sendToAll" name="sendToAll" >
                                           Email all Users</label>                
                               </div>
                     
		 <div class="checkbox">
                          <label for="sendToDept" class="checkbox">                            
                                <input type="checkbox" id="sendToDept" name="sendToDept">
                                Email whole department</label>
								</div>                       
			<div class="form-group">
                            <label for="sendToUsers[]" class="checkbox">
                           Email only these users: </label>
                                <select name="sendToUsers[]" id="sendToUsers" class="form-control" multiple >
                                    <option value="0">No One</option>
                                    <option value="owner" selected="selected">File Owners</option>
							<?php foreach($userInfo as $user):?>
                                    <option value="<?php echo $user->id?>"><?php echo $user->last_name . ', ' . $user->first_name?></option>
                                  <?php 
								  endforeach; ?>
                                </select>
								</div>                               
    <div class="form-group">		
             <button type="button" name="submit" style="text-transform: capitalize;" id="submitRequest" class="btn btn-primary btn-lg" value="<?php echo strtolower($submitValue) ?>">
					<i class="fa fa-paper-plane"></i> <?php echo $submitValue ?>
				</button>
                                                    
                                                 
                <button type="button" name="submit" id="cancelRequest" class="btn btn-primary btn-lg" value="cancel">
						<i class="fa fa-undo"></i> Cancel
				</button>

	</div>
</form>
</div>
                <script>
			
	jQuery('button#cancelRequest').on('click',function(){
		swal({  
			title: "Are you sure?",  
			text: "These files will remain unpublished.",  
			type: "warning",   
			showCancelButton: true, 
			confirmButtonColor: "#DD6B55", 
			confirmButtonText: "Yes, cancel!",   
			closeOnConfirm: true },
			function(){  
			jQuery('#commentForm .modal-body').html('');
			jQuery('#commentForm').modal('hide');
			jQuery('form#mainForm')[0].reset();
			alertify.log('Successfully canceled.',null);
			});
	});		

	jQuery('button#submitRequest').on('click',function(){
		var actionType = jQuery(this).val();
		var subject = jQuery('input#emailSubject');
		var emailTo = jQuery('input#emailTo');
		var comments = jQuery('#emailComments');
		
	if(emailTo.val() == ''){
		jQuery('input#emailTo').parent().addClass('has-error');
	}
		
		if(subject.val() == '' || emailTo.val() == ''|| comments.val() == ''){			
			alertify.error('All fields need to the completed.');
		}else{
			
		swal({  
			title: "Are you sure you want to " + actionType + " the file(s)?",  
			text: "We have to ask.",  
			type: "warning",   
			showCancelButton: true, 
			confirmButtonColor: "#27ae60", 
			confirmButtonText: "Yes, "+actionType+"!",   
			closeOnConfirm: true
			},
			function(){ 
				var formData = jQuery('#authorNoteForm').serialize();
				jQuery.ajax({
					type:'post',
					url: "tobepublished/submitFile",
					dataType:'json',
					data:{formData,<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>',type:actionType,files:<?php echo json_encode($checkBox)?>},
					success:function(data){
							alertify.log(data.msg,null);
							jQuery('#commentForm').modal('hide');
							jQuery('#commentForm .modal-header h3').html('');
							jQuery('#commentForm .modal-body').html('');
					}
				})
			});
		}
	});		
				
	jQuery('input#sendToDept').on('change',function(){
		console.log("Send to Dept changed");
			jQuery("input#sendToAll").prop('disabled', function (_, val) { return ! val; });				
			});			
			
	jQuery('input#sendToAll').on('change',function(){
		console.log("Send to All changed");
		jQuery("select#sendToUsers").prop('disabled', function (_, val) { return ! val; });
		jQuery("input#sendToDept").prop('disabled', function (_, val) { return ! val; });
	});		
	</script>