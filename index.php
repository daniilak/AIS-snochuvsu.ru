<?php

/**
 * Kidris Engine
 * Инициализация движка
 */
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
session_start();
require_once(__DIR__ . '/lib/Loader.php');
new Controller($_GET);