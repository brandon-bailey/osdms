<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <center>
                    <h4>File Details</h4></center>
                <form>
                    <?php if ($fileDetail->fileUnlocked) : ?>
                        <i class="fa fa-unlock fa-2x"></i>
                        <?php else : ?>
                            <i class="fa fa-lock fa-2x"></i>
                            <?php endif;?>
                                <div class="form-group">
                                <label>File name:</label>
                                    <input type="text" class="form-control" 
                                    value="<?php echo $fileDetail->realName ?>" disabled>
                                </div>
                                <div class="form-group">
                                 <label valign=top align=right>Category:</label>
                                 <select class="form-control">
                                    <?php foreach ($departmentList as $department) :?>
                                     <option value="<?php echo $department->id; ?>"><?php echo $department->name; ?>
                                     </option>
                                        <?php endforeach; ?>
                                        </select>
                                        <?php echo $fileDetail->category; ?>
                                </div>
                                    <div class="form-group">
                                        <label>Description:</label>
                                        <textarea class="form-control" ><?php echo $fileDetail->description; ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment:</label>
                                        <input type="text" class="form-control" 
                                        value="<?php echo $fileDetail->comment ?>">
                                    </div>
                                    <!--show if file is under review-->
                                    <?php if ($fileDetail->fileUnderReview) {?>
                                        <div class="form-group">
                                            <label>Reviewer:</label>
                                            <input type="text" value="<?php echo $fileDetail->reviewer ?>" disable>
                                        </div>
                                        <?php } ?>
                                            <!--show if file is already checked out-->
                                            <?php if ($fileDetail->status > 0) { ?>
                                                <div class="form-group">
                                                    <input type="text" value="<?php echo $checkoutPersonFullName[1] ?>, 
                                        <?php echo $checkoutPersonFullName[0] ?>" class="form-control" disabled>
                                                </div>
                                                <?php
}?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include(APPPATH . 'views/preview_pdf_view.php');?>
