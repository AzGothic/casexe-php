<?php

/**
 * Main web file
 * sets APP_TYPE
 * loads bootstrap.php
 */
define('APP_TYPE', 'web');

error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';