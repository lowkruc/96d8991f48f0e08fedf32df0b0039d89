<?php
/**
 * EmailBlast Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Bootstrap
 * @package  Index
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
require_once __DIR__ . '/vendor/autoload.php';

use EmailBlast\Controllers\AuthController;
use EmailBlast\Controllers\EmailController;
use EmailBlast\Middlewares\AuthMiddleware;
use EmailBlast\Modules\Router;
use EmailBlast\Controllers\PingController;

// Intialize URI without Auth
$bypassURI = ["/ping", "/login"];

// Initialize the router
$router = new Router();

// Register Middleware
$router->addMiddleware(new AuthMiddleware($bypassURI));

// Register Route
$router->addHandler("GET", "/ping", [new PingController(), 'ping']);
$router->addHandler("POST", "/login", [new AuthController(), 'login']);
$router->addHandler("POST", "/email", [new EmailController(), 'sendEmail']);

// Run Router
$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
