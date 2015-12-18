<div class="modal fade" role="dialog" id="downloadModal">
			<div class="modal-dialog">
			<div class="modal-content">
  <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
    <h3>Save Document</h3>
  </div>
  <div class="modal-body">
 
<form role="form" >

<div class="form-group">
	<label for="filename">Enter a Descriptive Name</label>
	<input class="form-control" type="text" name="filename" id="filename" size="50">
</div>
<textarea style="display:none;"></textarea> 
<?php if($this->userObj->isAdmin()): ?>
<div class="form-group">
<label for="department">Department: </label>
 <select class="form-control" id="department" name="department">
<?php foreach($allDepartments as $department): ?>
	<option value="<?php echo $department->id ?>" ><?php echo $department->name?></option>	
<?php  endforeach;?>
</select>
</div>

<div class="form-group">
<label for="category">Category: </label>
 <select class="form-control" id="category" name="category">
<?php foreach($allCategories as $category): ?>
	<option value="<?php echo $category->id ?>" ><?php echo $category->name?></option>	
<?php  endforeach;?>
</select>
</div>
<?php endif; ?>            
     <div class="form-group">
   <label for="description">Description of the file</label>
        <input class="form-control" type="text" name="description" id="description" size="50" placeholder="Used for searching">
          </div>
        <button class="btn btn-primary" id="saveDocument" type="button" title="Add Document">Submit</button>
</form>

 
    </div>
  <div class="modal-footer"><a class="btn btn-primary" data-dismiss="modal">Close</a> </div> 
</div>
</div>
</div>