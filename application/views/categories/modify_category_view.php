<div class="modal fade" role="dialog" id="modifyCategoryModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <div style="text-align:center;"><h3 >Displaying <?php echo $categoryDetails->name ?></h3></div>
  </div> 
  <div class="modal-body">
		<div class="row-fluid">
			<div class="well">
			<div style="text-align:center;">
                        <form role="form" id="modifyCategoryForm" method="POST" enctype="multipart/form-data">                                        
										<div class="form-group">
                                            <label for="categoryName" class="control-label">Category</label>                    
                                            <input class="form-control" type="text" id="categoryName" name="categoryName" value="<?php echo $categoryDetails->name; ?>" maxlength="40" required>
                                            <input type="hidden" id="categoryId" name="id" value="<?php echo $categoryDetails->id; ?>">
										</div>										
		            
                                            <div class="btn-group">
                                                <button class="btn btn-primary" type="button" id="modifyCategory" title="Update Category">Save</button>
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
	jQuery('button#modifyCategory').on('click', function(e){
	e.preventDefault();
	var categoryName = jQuery('form#modifyCategoryForm input#categoryName');
	var id = jQuery('form#modifyCategoryForm input#categoryId');
	if (categoryName.val() !=""){	
			jQuery.ajax({
				type:'post',
				url: "category/savecategorymodification",
				dataType:'json',
				data:{id:id.val(),name:categoryName.val()},				
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						jQuery('#modifyCategoryModal').modal('hide');
						jQuery('.modal-backdrop').remove();
						jQuery('#modifyCategoryModal').remove();
						alertify.success(data.msg,null);
						window.setTimeout(function(){location.reload()},4000);
					}
				
				}
			})	
	}
	else{
		alertify.error("Please select a category before attempting to modify.",null);
	}
});	
</script>