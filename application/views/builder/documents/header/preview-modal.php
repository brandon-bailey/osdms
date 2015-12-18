<div class="modal hide fade" role="dialog" id="previewHeaderModal">
  <div class="modal-header">
   <a class="close" data-dismiss="modal">×</a>
    <h3>Preview of <?php echo $description; ?></h3>
  </div>
  <div class="modal-body">
      <script type="text/javascript">
	  
	  html2canvas(document.body, {
  onrendered: function(canvas) {
    document.body.appendChild(canvas);
  }
});
	  </script>
<?php 
echo '<iframe id="header-preview" src='."'".$sitelink."'".' height=\"auto\" width=\"100%\"></iframe>'
?>

  </div>
  <div class="modal-footer">
  <a class="btn" data-dismiss="modal" >Cancel</a>
  </div>
</div>