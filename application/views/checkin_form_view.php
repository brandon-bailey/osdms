<div class="container">
<form class="form" id="checkInDocForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3);  ?>">
		<div class="form-group">
				<label><?php echo $this->lang->line('label_filename');?></label>
				<p><?php echo $fileInfo['realname']; ?></p>
		</div>
		
		<div class="form-group">
            <label><?php echo $this->lang->line('label_description');?></label>
            <p><?php echo $fileInfo['description']; ?></p>
			</div>
<div class="form-group">
           <label for="userfile"><?php echo $this->lang->line('label_file_location');?></label>
           <input class="form-control" id="userfile" name="userfile" type="file">
		   </div>
	<div class="form-group">
            <label for="note"><?php echo $this->lang->line('label_note_for_revision_log');?></label>
           <textarea class="form-control" id="note" name="note"></textarea>
	</div>
<center>
		<button class="btn btn-primary" type="submit" id="checkInFile" title="Check Document In"><?php echo $this->lang->line('button_check_in')?></button>
</center>
    </form>
	</div>
			<script src="<?php echo base_url()?>assets/js/ajaxfileupload.js"></script>
<script>
jQuery('#checkInDocForm').ajaxUpload({
			global : true,                     // Trigger global ajax events
			url : '<?php echo base_url() ?>index.php/checkin/doUploadAjax',                    // Replaces the form url
			iframeID : 'iframe-post-form',       // Iframe ID.
			json: true,                    // Parse server response as a json object.
			post : function () {             // Executed on submit
			console.log('Upload Posted');		
    },
			complete: function (r) {     // Executed after response from the server has been received	
				console.log(r);
					if(r.status== "success"){
								alertify.success("Successfully checked in: " + r.msg,null, 0);						
					}else if(r.status == "error")
					{						
						alertify.error("Failed to check in file", null, 0);						
					}
			}
});
</script>