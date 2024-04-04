<?php
require_once "../vendor/autoload.php";

use Check\{Site, HTTP};
try {
    Site::resolve($_POST ?? []);
}
catch (Exception|Error $e) {
    HTTP::response_error($e->getMessage());
}