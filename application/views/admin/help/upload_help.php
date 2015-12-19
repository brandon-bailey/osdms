<div class="modal fade" role="dialog" id="helpModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-body">
            <div class="table-responsive">
                <table  class="table table-striped">
                    <thead >
                        <tr >
                            <th >Preference</th>
                            <th >Default Value</th>
                            <th >Options</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr >
                            <td><strong>upload_path</strong></td>
                            <td>None</td>
                            <td>None</td>
                            <td>The path to the directory where the upload should be placed. The directory must be writable and the path can be absolute or relative.</td>
                        </tr>
                        <tr >
                            <td><strong>allowed_types</strong></td>
                            <td>None</td>
                            <td>None</td>
                            <td>The mime types corresponding to the types of files you allow to be uploaded. Usually the file extension can be used as the mime type. Can be either an array or a pipe-separated string.</td>
                        </tr>
                        <tr >
                            <td><strong>file_name</strong></td>
                            <td>None</td>
                            <td>Desired file name</td>
                            <td>If set CodeIgniter will rename the uploaded file to this name. The extension provided in the file name must also be an allowed file type. If no extension is provided in the original file_name will be used.</td>
                        </tr>
                        <tr >
                            <td><strong>file_ext_tolower</strong></td>
                            <td>FALSE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to TRUE, the file extension will be forced to lower case</td>
                        </tr>
                        <tr >
                            <td><strong>overwrite</strong></td>
                            <td>FALSE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to true, if a file with the same name as the one you are uploading exists, it will be overwritten. If set to false, a number will be appended to the filename if another with the same name exists.</td>
                        </tr>
                        <tr >
                            <td><strong>max_size</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The maximum size (in kilobytes) that the file can be. Set to zero for no limit. Note: Most PHP installations have their own limit, as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.</td>
                        </tr>
                        <tr >
                            <td><strong>max_width</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The maximum width (in pixels) that the image can be. Set to zero for no limit.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>max_height</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The maximum height (in pixels) that the image can be. Set to zero for no limit.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>min_width</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The minimum width (in pixels) that the image can be. Set to zero for no limit.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>min_height</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The minimum height (in pixels) that the image can be. Set to zero for no limit.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>max_filename</strong></td>
                            <td>0</td>
                            <td>None</td>
                            <td>The maximum length that a file name can be. Set to zero for no limit.</td>
                        </tr>
                        <tr >
                            <td><strong>max_filename_increment</strong></td>
                            <td>100</td>
                            <td>None</td>
                            <td>When overwrite is set to FALSE, use this to set the maximum filename increment for CodeIgniter to append to the filename.</td>
                        </tr>
                        <tr>
                            <td><strong>encrypt_name</strong></td>
                            <td>FALSE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to TRUE the file name will be converted to a random encrypted string. This can be useful if you would like the file saved with a name that can not be discerned by the person uploading it.</td>
                        </tr>
                        <tr>
                            <td><strong>remove_spaces</strong></td>
                            <td>TRUE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to TRUE, any spaces in the file name will be converted to underscores. This is recommended.</td>
                        </tr>
                        <tr>
                            <td><strong>detect_mime</strong></td>
                            <td>TRUE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to TRUE, a server side detection of the file type will be performed to avoid code injection attacks. DO NOT disable this option unless you have no other option as that would cause a security risk.</td>
                        </tr>
                        <tr>
                            <td><strong>mod_mime_fix</strong></td>
                            <td>TRUE</td>
                            <td>TRUE/FALSE (boolean)</td>
                            <td>If set to TRUE, multiple filename extensions will be suffixed with an underscore in order to avoid triggering <a class="reference external" href="http://httpd.apache.org/docs/2.0/mod/mod_mime.html#multipleext">Apache mod_mime</a>. DO NOT turn off this option if your upload directory is public, as this is a security risk.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
