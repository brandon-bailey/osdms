<div class="container">
	<div class="row-fluid">

		<a href="#" id="add" class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg"><i class="fa fa-plus fa-2x"></i><br />Add</a>
		<a href="#" id="delete"  class="col-xs-12 col-sm-6 col-md-4 btn btn-danger btn-lg"><i class="fa fa-trash fa-2x"></i><br />Delete</a>

</div>
</div>
<script>
jQuery('a#add').on('click', function(){
				jQuery.ajax({
				type:'post',
				url: "userdefinedfields/add",								
				success:function(data){
					jQuery('body').append(data);
					jQuery('#addUdfModal').modal('show');
				}
			})	
});
jQuery('a#delete').on('click', function(){
				jQuery.ajax({
				type:'post',
				url: "userdefinedfields/displayUdfsToDelete",								
				success:function(data){
					jQuery('body').append(data);
					jQuery('#deleteUdfModal').modal('show');
				}
			})	
});
</script>