<div class="modal fade" role="dialog" id="deleteCategoryModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal" ><i class="fa fa-times"></i></a>
    <center><h3 style="text-transform: capitalize;">Delete <?php echo $deleteCategory->name ?></h3></center>
  </div> 
  <div class="modal-body">
	<div style="text-align:center">
		<div class="row">
            <div class="col-md-12">			
                    <div class="jumbotron">
						<div style="text-align:center">
							<div class="row">
								<h3>ID #: <?php echo $deleteCategory->id ?></h3>
							</div>
						</div>
						
							 <div style="text-align:center">
					 <div class="row">								
							<h3>Name : <?php echo $deleteCategory->name?></h3>
					 </div>
				</div>
					</div> 
			</div>
		</div>	
	</div>

    <form role="form" enctype="multipart/form-data">
	        <input type="hidden" name="<?php echo $deleteCategory->name ?>" id="categoryToDelete" value="<?php echo $deleteCategory->id ?>">   
			<div class="row">
	          <div class=" col-md-offset-3  col-md-6">
				<div class="form-group" id="assignCategory" >
               <label for="assignedId"> Reassign To:    </label>   
                  <select id="assignedId" name="assignedId" class="form-control">
                            <?php foreach($otherCategories as $row) : ?>
                             <option value="<?php echo  $row->id ?>"> <?php echo $row->name ?></option>
                           <?php endforeach; ?>
                    </select>
						<span class="help-block">All documents assigned to the deleted category will be transferred to this category.</span>
				</div>		
			</div>
	</div>	
	<div style="text-align:center">
		<div class="form-group" >
                <div class="btn-group">
                    <button class="btn btn-primary" type="button" id="deleteCategory" title="Delete this category and reassign to the new category.">Delete</button>          
                    <button class="btn btn-danger" type="button" title="Cancel this request, the category will not be deleted.">Cancel</button>
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
	jQuery('button#deleteCategory').on('click', function(e){
	e.preventDefault();
	var assignCat = jQuery('select#assignedId');
	var deleteCat  = jQuery('input#categoryToDelete');
	if (assignCat.val() !="default"){
	swal({
		title: "Are you sure?",
		text: "This will delete "+deleteCat.attr('name'),
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete!',
		closeOnConfirm: true
	},
	function(){		
			jQuery.ajax({
				type:'post',
				url: "category/deletecategory",
				dataType:'json',
				data:{deleteId:deleteCat.val(),assignId:assignCat.val()},				
				success:function(data){
					jQuery('#deleteCategoryModal').modal('hide');
					jQuery('#deleteCategoryModal').remove();
					jQuery('.modal-backdrop').remove();
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
		alertify.error("Please select a category before attempting to delete.",null);
	}
});	
</script>
