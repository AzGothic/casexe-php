<?php

/**
 * Main CONSTANS definition
 */
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH . 'config'. DIRECTORY_SEPARATOR);
define('VIEW_PATH', BASE_PATH . 'view'. DIRECTORY_SEPARATOR);
define('MODULE_PATH', BASE_PATH . 'module'. DIRECTORY_SEPARATOR);
define('MIGRATE_PATH', BASE_PATH . 'migrate'. DIRECTORY_SEPARATOR);

/**
 * Environment definition
 */
$env = file_exists(CONFIG_PATH . 'env.php')
        ? require CONFIG_PATH . 'env.php'
        : 'prod';
if (!$env or !is_string($env)) {
    $env = 'prod';
}
define('APP_ENV', $env);

if (APP_ENV === 'prod') {
    error_reporting(0);
    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 0);
}

/**
 * Application Type definition
 * for 'web' will be set in web/index.php
 */
defined('APP_TYPE')
    || define('APP_TYPE', 'cli');

/**
 * Autoloader definition
 */
$autoload = require BASE_PATH . 'vendor/autoload.php';
if (APP_TYPE == 'cli')
    $autoload->addClassMap(['App' => BASE_PATH . 'base/AppCli.php']);
else
    $autoload->addClassMap(['App' => BASE_PATH . 'base/AppWeb.php']);
$autoload->addPsr4('app\\', BASE_PATH);

/**
 * Load config
 */
$configs = [
    'main'     => CONFIG_PATH . 'main.php',
    'main.env' => CONFIG_PATH . 'main.env.php',
    'type'     => CONFIG_PATH . APP_TYPE . '.php',
    'type.env' => CONFIG_PATH . APP_TYPE . '.env.php',
];

$configMain    = require $configs['main'];
$configMainEnv = file_exists($configs['main.env']) ? require $configs['main.env'] : [];
$configType    = require $configs['type'];
$configTypeEnv = file_exists($configs['type.env']) ? require $configs['type.env'] : [];

$config = app\base\helper\HelperArray::merge(
            $configMain,
            $configMainEnv,
            $configType,
            $configTypeEnv
        );

App::init($config);
