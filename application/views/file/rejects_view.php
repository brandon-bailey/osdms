<script>
$(document).ready(function(){
$('.trashable').draggable({ revert: "invalid" ,opacity: 0.7});
    $( "#trashCan" ).droppable({	
		 hoverClass: "fa-5x",
      drop: function( event, ui ) {	
			ui.draggable.effect('puff');
			var elem = ui.draggable.children().find('span.name').html();
			var id = ui.draggable.children().find('input[name="fileId"]').val(); 		
		$.ajax({
            url: '<?php echo base_url() ?>index.php/delete/deleteFile/'+id ,
            type: "POST",
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
			}
        });				
      }
    });
		    $( "#authorize" ).droppable({	
		 hoverClass: "fa-5x",
      drop: function( event, ui ) {	
			ui.draggable.effect('clip');
			var elem = ui.draggable.children().find('span.name').html();
			var id = ui.draggable.children().find('input[name="fileId"]').val(); 		
				console.log(id);
				console.log(elem);				
		$.ajax({
            url: '<?php echo base_url() ?>index.php/file/resubmit/'+id,
            type: "POST",
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
			}
        });							
      }
    });
});	
</script>