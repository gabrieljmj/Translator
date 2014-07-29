<?php
$autoloadFile = 'vendor/autoload.php';

if (!file_exists($autoloadFile)) {
    throw new Exception('Install the composer http://getcomposer.org');
}

require_once $autoloadFile;
