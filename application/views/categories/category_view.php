<div class="container">
	<div class="row-fluid">
		<a href="#" id="add" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-plus fa-2x"></i><br />Add</a>
		<a href="#" id="delete"  class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-minus fa-2x"></i><br />Delete</a>
        <a href="#" id="modify" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-refresh fa-2x"></i><br />Modify</a>
       <a href="#" id="display" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg triggerModal"><i class="fa fa-eye fa-2x"></i><br />Display</a>
</div>
</div>

<div class="modal fade" role="dialog" id="categoryPageModal" >
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" ><i class="fa fa-times"></i></a>
    <div style="text-align:center"><h3 style="text-transform: capitalize;"></h3></div>
  </div> 
  <div class="modal-body">
    <form class="form-vertical" enctype="multipart/form-data"> 
	<div style="text-align:center">
		<div class="row">
            <div class=" col-md-offset-3  col-md-6">
				<div class="form-group">
                        <select  class="form-control " id="categoryToDelete" name="item">
						<option value="default">Select a Category</option>
                        <?php	foreach($allCategories as $row): ?>
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
			<div style="text-align:center">        
				<div class="row">	
                    <div class="btn-group">
							<button id="categoryFormAction" class="btn btn-primary" style="text-transform: capitalize;" type="button" name="submit" value="">
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
    $(document).ready(function() {
jQuery(document).on('click', 'a.triggerModal' ,function(){	
	var action = jQuery(this).attr('id')
		console.log(action);
	if(action=="add"){
			jQuery.ajax({
				type:'post',
				url: "category/"+action+"category",			
				success:function(data){					
					jQuery('body').append(data);
					jQuery('#addCategoryModal').modal('show');
				}
			})
			return;
	}	
		if(action.length !='')	
		{
				jQuery('#categoryPageModal .modal-header h3').html(action+" Category");				
				jQuery('#categoryPageModal button#categoryFormAction').html(action);			
				jQuery('#categoryPageModal button#categoryFormAction').val(action);		
				jQuery('#categoryPageModal').modal('show');			
		}
				else{					
					alertify.error('There was a problem with your selection',null);
				}
});
jQuery(document).on('click','[name="closeModal"]',function(){
	var modalid = jQuery(this).closest('div.modal').attr('id');	
	jQuery('#'+modalid).remove();	
	jQuery('.modal-backdrop').remove();
});

jQuery('button#categoryFormAction').on('click', function(e){
	var action = jQuery(this).val();
	var deptId = jQuery('form #categoryToDelete').find('option:selected').val();
	console.log(action);
	if(action =="delete")
	{
			jQuery.ajax({
				type:'post',
				url: "category/displayCategoryToDelete",				
				data:{id:deptId},				
				success:function(data){
					jQuery('#categoryPageModal').modal('hide');
					jQuery('body').append(data);
					jQuery('#deleteCategoryModal').modal('show');
				}
			})	
	}
	if(action =="display")
	{
			jQuery.ajax({
				type:'post',
				url: "category/displaycategory",				
				data:{id:deptId},				
				success:function(data){
					jQuery('#categoryPageModal').modal('hide');
					jQuery('body').append(data);
					jQuery('#displayCategoryModal').modal('show');
				}
			})	
	}
	if(action =="modify")
	{
			jQuery.ajax({
				type:'post',
				url: "category/modifycategory",				
				data:{id:deptId},				
				success:function(data){
					jQuery('#categoryPageModal').modal('hide');
					jQuery('body').append(data);
					jQuery('#modifyCategoryModal').modal('show');
				}
			})	
	}
	
});
				});

</script>