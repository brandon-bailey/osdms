</form>
<div class="modal fade" role="dialog" id="commentForm" >
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal"><i class="fa fa-times"></i></a>
    <div class="text-center">
	<h3 style="text-transform: capitalize;"></h3>
	</div>
  </div>
  <div class="modal-body">
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal" >Close</a>
  </div>
  </div>
  </div>
</div>
<script>
$( document ).ready(function() {
$('.trashable').draggable({
		revert: "invalid",
		opacity: 0.7,
		start: function() {
			 $('.popover').popover('hide');
		}
	});
    $( "#trashCan" ).droppable({
		 accept: ".trashable",
		 hoverClass: function() {
			 var trashCan = $('#trashCan');
			 if(trashCan.hasClass("fa-trash-o"))
			{
				trashCan.removeClass("fa-trash-o");
				trashCan.addClass("fa-trash");
			}
			else{
				trashCan.removeClass("fa-trash");
				trashCan.addClass("fa-trash-o");
			}
		},
      drop: function( event, ui ) {
			ui.draggable.effect('puff');
			var elem = ui.draggable.children().find('span.name').html();
			var id = ui.draggable.children().find('input[name="fileId"]').val();
		$.ajax({
             url: '<?php echo site_url(); ?>tobepublished/processfile',
            type: "POST",
			data:{<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>',selections:id,type:'reject'},
            success: function(data){
						$('#commentForm .modal-header h3').html('Reject Files');
						$('#commentForm .modal-body').html(data);
						$('#commentForm').modal('show');
			}
        });
      }
    });
	    $( "#authorize" ).droppable({
		 accept: ".trashable",
		 hoverClass: function() {
			  var authorize = $('#authorize');
			 if(authorize.hasClass("fa-thumbs-o-up"))
			{
				authorize.removeClass("fa-thumbs-o-up");
				authorize.addClass("fa-thumbs-up");
			}
			else{
				authorize.removeClass("fa-thumbs-up");
				authorize.addClass("fa-thumbs-o-up");
			}
		},
      drop: function( event, ui ) {
			ui.draggable.effect('clip');
			var elem = ui.draggable.children().find('span.name').html();
			var id = ui.draggable.children().find('input[name="fileId"]').val();
				console.log(id);
				console.log(elem);
		$.ajax({
            url: '<?php echo site_url(); ?>tobepublished/processfile',
            type: "POST",
			data:{<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>',selections:id,type:'authorize'},
            success: function(data){
						$('#commentForm .modal-header h3').html("Authorize Files");
						$('#commentForm .modal-body').html(data);
						$('#commentForm').modal('show');
			}
        });
      }
    });

	$('div#commentForm a[name="closeModal"]').on('click', function(){
		$('form#mainForm')[0].reset();
		$('#commentForm').modal('hide');
		$('#commentForm .modal-body').html('');
		alertify.log('Your request has been canceled, no changes were made.',null);
});
	$('button[name="submit"]').on('click', function(e){
		e.preventDefault();
		var submitType = $(this).val();
		var checks = [];
		$('input:checkbox:checked').each(function(){
				checks.push($(this).val());
		});
		if(!checks.length ==0)
		{
			$.ajax({
				type:'post',
				url: "<?php echo site_url(); ?>tobepublished/processFile",
				data:{<?php echo $this->security->get_csrf_token_name() ?>:'<?php echo $this->security->get_csrf_hash() ?>',selections:checks,type:submitType},
				success:function(data){
						$('#commentForm .modal-header h3').html(submitType + " Files");
						$('#commentForm .modal-body').html(data);
						$('#commentForm').modal('show');
				}
			})
		}
				else{
					alertify.error('You have to select a file before you can proceed',null);
				}
});
				});
</script>