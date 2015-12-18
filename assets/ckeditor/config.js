

CKEDITOR.editorConfig = function( config ) {
	 config.filebrowserBrowseUrl = '../documents/finder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '../documents/finder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '../documents/finder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '../documents/finder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '../documents/finder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '../documents/finder/upload.php?opener=ckeditor&type=flash';
	config.extraPlugins = 'save';
};