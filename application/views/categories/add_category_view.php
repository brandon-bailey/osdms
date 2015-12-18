<div class="modal fade" role="dialog" id="addCategoryModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <center>
	<h3 >Add Category</h3>
	</center>
  </div> 
  <div class="modal-body">
    <form style="text-align:center;" id="categoryAddForm"  enctype="multipart/form-data">
          <div class="form-group">
                <label for="category"><b>Category</b></label>               
                <input id="categoryName" name="category" type="text" class="form-control" maxlength="40">
          </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="addCategory" type="button" value="Add Category">Add Category</button>          
               
                    <button class="btn btn-danger" type="submit" name="cancel" value="Cancel">Cancel</button>
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
	jQuery('button#addCategory').on('click', function(e){
	e.preventDefault();
	var categoryName = jQuery('input#categoryName');
	if (categoryName.val() !=""){	
			jQuery.ajax({
				type:'post',
				url: "category/createcategory",
				dataType:'json',
				data:{name:categoryName.val()},				
				success:function(data){				
					if (data.status == "error")
					{
						alertify.error(data.msg,null);
					}
					else{
						jQuery('#addCategoryModal').modal('hide');
						jQuery('.modal-backdrop').remove();
						jQuery('#addCategoryModal').remove();
						alertify.success(data.msg,null);
						//window.setTimeout(function(){location.reload()},4000);
					}
				
				}
			})	
	}
	else{
		alertify.error("Please enter a category name before attempting to save.",null);
	}
});	
</script>