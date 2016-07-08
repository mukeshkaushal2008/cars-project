<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
//require('UploadHandler.php');
//$upload_handler = new UploadHandler();


class CustomUploadHandler extends UploadHandler
{
    protected function trim_file_name($name, $type) {
        $name = parent::trim_file_name($name, $type);
        // Your file name changes: $name = 'something';
        return $name;
    }
	
}
$upload_handler = new CustomUploadHandler();

