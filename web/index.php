<?php

/**
 * Main web file
 * sets APP_TYPE
 * loads bootstrap.php
 */
define('APP_TYPE', 'web');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';