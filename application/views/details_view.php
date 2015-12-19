<div class="container">
    <div class="row">
        <div class="btn-group pull-right">
            <a href="#" role="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></a>
            <ul class="dropdown-menu" role="menu">
                <?php if ($fileDetail->viewInBrowser !== NULL): ?>
                    <li><a href="#" id="pdfPreview" data-toggle="modal" data-target="#previewPDF"> View</a></li>
                    <?php endif;?>
                        <?php if ($fileDetail->checkOutLink !== ''): ?>
                            <input type="hidden" name="access_right" value="<?php echo $fileDetail->accessRight ?>">
                            <li><a href="<?php echo $fileDetail->checkOutLink; ?>" id="checkOut">Check Out</a></li>
                            <?php endif;?>
                                <?php if ($fileDetail->editFileLink !== NULL): ?>
                                    <li><a id="fileEditor" href="#" rel="<?php echo $fileDetail->editFileLink ?>"> Edit File <?php echo $fileDetail->fileInfo; ?></a></li>
                                    <?php endif;?>
                                        <?php if ($fileDetail->editLink !== ''): ?>
                                            <li><a href="<?php echo $fileDetail->editLink; ?>">Edit File Details</a></li>
                                            <?php if ($fileDetail->deleteLink !== 0): ?>
                                                <li><a href="#" id="delete">Delete</a></li>
                                                <?php endif;?>
                                                    <li><a href="#" id="thumbnail">Create Thumbnail</a></li>
                                                    <li><a href="#" id="createPdf">Create or Refresh PDF</a></li>
                                                    <?php endif;?>
            </ul>
        </div>
        <!--Settings Button Group-->
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <center>
                    <h4>File Details</h4></center>
                <table class="table table-striped">
                    <tr>
                        <td align="right">
                            <?php if ($fileDetail->fileUnlocked): ?>
                                <i class="fa fa-unlock fa-2x"></i>
                                <?php else: ?>
                                    <i class="fa fa-lock fa-2x"></i>
                                    <?php endif;?>
                        </td>
                        <td align="left">
                            <font size="+1">
                                <?php echo $fileDetail->realName ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Category:</th>
                        <td>
                            <?php echo $fileDetail->category ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Size:</th>
                        <td>
                            <?php echo $fileDetail->fileSize ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Created Date:</th>
                        <td>
                            <?php echo $fileDetail->created ?>
                        </td>
                    </tr>
                    <!-- display for all files that mimes are html or php -->
                    <tr>
                        <th valign=top align=right>Original:</th>
                        <td>
                            <?php if ($fileDetail->viewInBrowser !== NULL): ?>
                                <a href="#" id="pdfPreview" data-toggle="modal" data-target="#previewPDF">
                                    <i class="fa fa-file-code-o fa-lg"></i>
                                    <small> View in Browser</small>
                                </a>
                                <?php endif;?>
                                    <?php if ($fileDetail->ext == "png" || $fileDetail->ext == "jpg"): ?>
                                        <a href="#" id="imagePreview" data-toggle="modal" data-target="#previewImage">
                                            <i class="fa fa-image fa-lg"></i>
                                            <small> View in Browser</small>
                                        </a>
                                        <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Email Owner:</th>
                        <td>
                            <a href="mailto:<?php echo $fileDetail->ownerEmail ?>">
                                <?php echo $fileDetail->owner ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Description:</th>
                        <td>
                            <?php echo $fileDetail->description; ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Comment:</th>
                        <td>
                            <?php echo $fileDetail->comment ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign=top align=right>Revision: </th>
                        <td>
                            <div id="details_revision">
                                <?php echo $fileDetail->revision ?>
                            </div>
                        </td>
                    </tr>
                    <?php if ($fileDetail->fileUnderReview): ?>
                        <tr>
                            <th valign=top align=right>Reviewer:</th>
                            <td>
                                <?php echo $fileDetail->reviewer ?> (<a href="#">Comments</a>)</td>
                        </tr>
                        <?php endif;?>
                            <?php if ($fileDetail->status > 0): ?>
                                <tr>
                                    <th valign=top align=right>Checked out to:</th>
                                    <td>
                                        <a href="mailto:<?php echo $checkoutPersonEmail ?>">
                                            <?php echo $checkoutPersonFullName[1] ?>,
                                                <?php echo $checkoutPersonFullName[0] ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php endif;?>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <center>
                    <h4>History</h4></center>
                <div class="table-responsive">
                    <table id="fileTable" class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>
                                    <font size="-1">Version</font>
                                </th>
                                <th>
                                    <font size="-1">Modification Date</font>
                                </th>
                                <th>
                                    <font size="-1">By</font>
                                </th>
                                <th>
                                    <font size="-1">Note</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
if (isset($fileDetail->fileHistory)):
	foreach ($fileDetail->fileHistory as $item): ?>
								                                <tr>
								                                    <td>
								                                        <font size="-1">
								                                            <?php echo $item->revision ?>
								                                        </font>
								                                    </td>
								                                    <td>
								                                        <font size="-1">
								                                            <?php echo $item->modifiedOn ?>
								                                        </font>
								                                    </td>
								                                    <td>
								                                        <font size="-1">
								                                            <?php echo $item->firstName ?>
								                                                <?php echo $item->lastName ?>
								                                        </font>
								                                    </td>
								                                    <td>
								                                        <font size="-1">
								                                            <?php echo $item->note ?>
								                                        </font>
								                                    </td>
								                                </tr>
								                                <?php
endforeach;
endif;
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include APPPATH . 'views/preview_pdf_view.php'?>
    <script>
    $(document).ready(function() {
        $('#fileTable').DataTable();
        //delete file function
        $(document).on("click", 'a#delete', function(e) {
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "This will delete <?php echo $fileDetail->realName ?> and move it to the archive directory!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, delete it!',
                    closeOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '<?php echo site_url() ?>delete/deletefile/<?php echo $this->requestId ?>',
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == "error") {
                                alertify.error(data.msg, null, 0);
                            } else if (data.status == "success") {
                                alertify.success(data.msg, null, 0);
                            }
                        }
                    });
                });
        });

        //createThumbnail function

        $(document).on("click", 'a#thumbnail', function() {
            swal({
                    title: "Are you sure?",
                    text: "If there is already a thumbnail it will be overwritten!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, create thumbnail!',
                    closeOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '<?php echo site_url(); ?>file/createThumbnail',
                        type: "POST",
                        dataType: 'json',
                        cache: false,
                        data: ({
                            id: '<?php echo $this->requestId ?>',
                            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>'
                        }),
                        success: function(data) {
                            if (data.status == "error") {
                                alertify.error(data.msg, null, 0);
                            } else if (data.status == "success") {
                                alertify.success(data.msg, null, 0);
                            }
                        }
                    });
                });
        });

        $(document).on("click", 'a#createPdf', function() {
            swal({
                    title: "Are you sure?",
                    text: "If there is already a PDF it will be overwritten!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, create new PDF!',
                    closeOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '<?php echo site_url(); ?>file/createPdf',
                        type: "POST",
                        dataType: "json",
                        cache: false,
                        data: ({
                            id: '<?php echo $this->requestId ?>',
                            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>'
                        }),
                        success: function(data) {
                            if (data.status == "error") {
                                alertify.error(data.msg, null, 0);
                            } else if (data.status == "success") {
                                alertify.success(data.msg, null, 0);
                            }
                        }
                    });

                });
        });

        $(document).on("click", '#fileEditor', function() {
            var url = $(this).prop('rel');
            if (url != null) {
                swal({
                        title: "Edit File",
                        text: "The changes made to this file will affect any document that contains the same modules.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Yes, edit!',
                        closeOnConfirm: true
                    },
                    function() {
                        window.open(url, '_blank')
                    });
            } else {
                swal({
                    title: "Uh-oh",
                    text: "You currently cannot edit this type of file.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'I understand!',
                    closeOnConfirm: true
                });
            }
        });

        $(document).on("click", '#pdfPreview', function() {
            var previewModal = $('.modal-body').has('iframe').length;
            if (previewModal == 0) {
                var viewIframe = '<iframe src = "<?php echo base_url() ?>assets/js/viewer/?zoom=page-width#<?php echo $fileDetail->viewInBrowser ?>"width="100%"' +
                    'height="600" allowfullscreen webkitallowfullscreen></iframe>';

                $('.modal-body').append(viewIframe);
            }
            $('#previewPDF').modal('show');
        });

        $(document).on("click", '#imagePreview', function() {
            var previewModal = $('.modal-body').has('iframe').length;
            if (previewModal == 0) {
                var viewIframe = '<img src="<?php echo base_url() . $this->config->item("dataDir") . $fileDetail->location ?>">';

                $('.modal-body').append(viewIframe);
            }
            $('#previewImage').modal('show');
        });

        $(document).on("click", '#closeModal', function() {
            $('.modal-body iframe').remove();
            $('.modal-body img').remove();
        });
    });
    </script>
