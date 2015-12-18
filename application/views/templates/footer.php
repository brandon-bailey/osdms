
<div class="container" id="toTopContainer">
	
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/data-tables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/data-tables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>


<script>
$(document).ready(function() {
<?php if($this->session->flashdata('error')!==NULL):?>
alertify.error("<?php echo $this->session->flashdata('error') ?>",null, 0);
<?php endif; ?>
	
	$('body').tooltip({
	   selector: '[data-toggle="tooltip"]'
	})	
	
    // Check if body height is higher than window height :)
    if ($('body').height() > $(window).height()) {
        $('div#toTopContainer').html('<a href="#top" class="btn btn-primary pull-right navigate-top"> <i class="fa fa-chevron-up"></i>Top</a>');
    }

$(document).on('click','a.dropdown-toggle',function(){
	$('[data-toggle="tooltip"]').each(function() {
            $(this).tooltip('hide');
        });  
});	
});
</script>	
	
</body>
</html>