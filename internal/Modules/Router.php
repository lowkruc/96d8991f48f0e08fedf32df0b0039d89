<?php
/**
 * EmailBlast\Modules Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Class
 * @package  EmailBlast\Modules
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */

namespace EmailBlast\Modules;

use EmailBlast\Modules\HttpResponse;
use EmailBlast\App\Middleware;
/**
 * Router Class
 *
 * This Class for handling routing HTTP requests.
 *
 * @category Class
 * @package  EmailBlast\Modules\Router
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class Router
{
    protected string $urlPath;
    protected array $routes = [];
    protected array $middlewares = [];

    /**
     * AddMiddleware Function.
     *
     * AddMiddleware is function register middleware
     *
     * @param Middleware $middleware is class handler request
     *
     * @return void
     */
    public function addMiddleware(Middleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * AddHandler Function.
     *
     * AddHandler function is function for define path and controller handler
     *
     * @param string   $method  is method request.
     * @param string   $path    is path url from request.
     * @param callable $handler is function handler request.
     *
     * @return void
     */
    public function addHandler(string $method, string $path, callable $handler): void
    {
        $this->routes[] = array(
            "path" => $path,
            "method" => $method,
            "handler" => $handler
        );
    }

    /**
     * Run Function.
     *
     * This function to run middleware and route handler
     *
     * @param string $path is path url from request.
     *
     * @return void
     */
    public function run(string $path, string $method): void
    {
        // Execute middlewares
        foreach ($this->middlewares as $middleware) {
            $midd = $middleware->handle();
            if ($midd !== null) {
                echo $midd; // nosec
                return;
            }
        }

        // Find and execute the route handler
        foreach ($this->routes as $route) {
            if ($route["path"] == $path && $route["method"] == $method) {
                $handler = $route["handler"];
                echo $handler(); // nosec
                return;
            }
        }

        // If no route matches, send 404 response
        HttpResponse::sendUrlNotFound();
    }
}
