<?php
/**
 * EmailBlast\Middlewares Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\Middlewares
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */

namespace EmailBlast\Middlewares;
use EmailBlast\App\Middleware;
use EmailBlast\Models\UserModel;
use EmailBlast\Modules\HttpResponse;
use EmailBlast\Modules\JwtHelper;
/**
 * AuthMiddleware Class
 * This class for middleware auth request.
 *
 * @category Class
 * @package  EmailBlast\Middlewares\AuthMiddleware
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class AuthMiddleware extends Middleware
{
    protected $bypassAuth = [];
    protected $userModel = null;

    /**
     * Construct AuthMiddleware
     *
     * This function for construct AuthMiddleware
     *
     * @param array $bypassAuth is path uri to allowed public access
     *
     * @return void
     */
    public function __construct(array $bypassAuth)
    {
        $this->bypassAuth = $bypassAuth;
        $this->userModel = new UserModel();
    }
    
    /**
     * Handle Middleware
     *
     * This function for handle middleware logic
     *
     * @return mixed
     */
    public function handle()
    {
        $urlPath = $_SERVER['REQUEST_URI'];
        if (in_array($urlPath, $this->bypassAuth)) {
            return null;
        }

        $token = $this->_getBearerToken();
        if ($token == null) {
            return HttpResponse::sendUnauthorized();
        }

        try {
            $payload = JwtHelper::decodeToken($token);
        } catch (\Throwable $th) {
            return HttpResponse::sendErr($th);
        }

        if (empty($payload)) {
            return HttpResponse::sendUnauthorized();
        }

        $user = $this->userModel->getUserByUsername($payload->username);
        if (empty($user)) {
            return HttpResponse::sendUnauthorized();
        }
    }

    /**
     * Handle Middleware
     *
     * This function for handle middleware logic
     *
     * @return string|null return barear token if not found null
     */
    private function _getBearerToken(): string|null
    {
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);
        if (!isset($headers['authorization'])) {
            return null;
        }

        return trim(str_replace('Bearer', '', $headers['authorization']));
    }
}
