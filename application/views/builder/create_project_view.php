<div class="container">	  
	  <div class="row-fluid">	  
<?php echo form_open('','id="createProject" '); ?>

<div class="form-group">
<label for="projectName">Project Name</label>
<input type="text" class="form-control" name="projectName" id="projectName" placeholder="Project Name">
</div>

<div class="form-group">
<button type="button" id="submitNewProject" class="btn btn-primary">Create</button>
<button type="button" class="btn btn-danger">Cancel</button>
</div>

<?php echo form_close(); ?>

		</div>
</div>
<script>
jQuery('#submitNewProject').on('click',function(){
			jQuery.ajax({
				url: '<?php echo site_url() ?>builder/insertnewproject',
				type: "POST",
				data: jQuery('form#createProject').serialize(),
				dataType: 'json',
				success: function(data){
					if(data.status=="error")
					{
						alertify.error(data.msg,null,0);
					}
					else if(data.status =="success")
					{
						alertify.success(data.msg,null,0);
					}		
						jQuery('form#projectName').val('');
				}
			});	
	
});
</script>