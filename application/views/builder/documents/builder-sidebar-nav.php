<div class="col-sm-3 col-md-2 sidebar-nav">

<?php $this->load->view('builder/documents/header/accordion.php');?>
<?php $this->load->view('builder/documents/body/accordion.php');?>	
<?php $this->load->view('builder/documents/footer/accordion.php');?>
<?php $this->load->view('builder/documents/drafts/accordion.php');?>
<?php $this->load->view('builder/documents/unpublished/accordion.php');?>


<div class="text-center">
<div class="trash" id="trash">
	<i class="fa fa-trash fa-3x ui-sortable"></i>
</div>
</div>
</br>

<div id="searchElement">
<div class="text-center"> 
<div class="input-group">
<input class="form-control" type="text" id="search"  placeholder="Start typing to search modules..." value="">
<a tabindex="0" role="button" class="input-group-addon" id="expand" href="#" data-target="#searchModal" data-toggle="modal">
	<i class="fa fa-arrows"></i>
</a>

<a class="input-group-addon" id="searchSettings" href="#" 
data-toggle="popover" data-trigger="click" title="Narrow Your Results" 
 data-content='
 <div class="form-group">
 <label for="category">By Category</label>
 <select class="filter" name="category" id="category">
								<option value="">All</option>								
								<option value="header">Header</option>
								<option value="body">Body</option>
								<option value="footer">Footer</option>
							</select></div>
			
							'>
			<i class="fa fa-cogs"></i>
</a>
</div>
</div>
<ul id="results">


</ul>

</div>
    	</div> 	

        
        
  