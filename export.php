<?php
/**
 * Refactor this code to be the tidiest, 'best practice' design you can come up with
 * The point of this exercise is not to find minor bugs in the code, but to focus on the architecture of 
 * this piece of software and ensure it is very well designed - easy to maintain, extend, refactor over 
 * time as required.
 * 
 * This code uses a standalone implementation of Laravel Collections which provides the global 'collect'
 * method and various methods which operate on the resulting Collection object. 
 * https://laravel.com/docs/5.8/collections
 */
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Classes\Controller;

// prepare the request & process the arguments

// process the args
$args = collect($_REQUEST);
$format = $args->pull('format') ?: 'html';
$type = $args->pull('type');
if (!$type) {
    exit('Please specify a type');
}

$controller = new Controller($args);
echo $controller->export($type, $format);
