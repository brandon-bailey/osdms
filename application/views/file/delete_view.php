<script>
$( document ).ready(function() {
$('.trashable').draggable({ revert: "invalid" ,opacity: 0.7});
    $( "#trashCan" ).droppable({
		 hoverClass: "fa-5x",
      drop: function( event, ui ) {
			ui.draggable.effect('puff');
			var elem = ui.draggable.children().find('span.name').html();
			var id = ui.draggable.children().find('input[name="fileId"]').val();
		$.ajax({
            url: '<?php echo site_url() ?>file/deleteFiles/'+id ,
            type: "POST",
			dataType: 'json',
			data:{
				<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>'
			},
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
            url: '<?php echo site_url() ?>delete/undeletefile/'+id,
            type: "POST",
			dataType: 'json',
			data:{
				<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>'
			},
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