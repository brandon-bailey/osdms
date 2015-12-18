<div class="container-fluid">
  <div class="row-fluid">
    <div class="">
      <?php $this->load->view('builder/documents/builder-sidebar-nav.php'); ?>
    </div>
    <!--/span-->
<?php $this->load->view('builder/sections/demo/demo.php');?>
    <!--/span-->	
    <div id="download-layout">
      <div class="container-fluid"></div>
    </div> 
  </div>
  <!--/row--> 
</div>
<?php $this->load->view('builder/modules/editor-modal.php') ?>

<?php $this->load->view('builder/documents/addFileModal.php') ?>