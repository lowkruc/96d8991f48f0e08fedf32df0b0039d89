<?php
/**
 * EmailBlast\Controller Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\Controller
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
namespace EmailBlast\Controllers;
use EmailBlast\App\Controller;
use EmailBlast\Models\UserModel;
use EmailBlast\Modules\JwtHelper;
use EmailBlast\Modules\RequestParser;
use stdClass;

/**
 * AuthController Class
 * This Class for handling request auth controller.
 *
 * @category Class
 * @package  EmailBlast\Controller\PingController
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class AuthController extends Controller
{
    protected $userModel;

    /**
     * Constructor AuthController
     *
     * This function constructor for AuthController
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Handle POST login
     *
     * This function for user login to get access token
     *
     * @return void
     */
    public function login()
    {
        try {
            $request = RequestParser::parseJsonRequestBody(false);
       
            $username = $request->username;
            $password = $request->password;

            if ($username == "" || $password == "") {
                return $this->sendBadRequest("username or password must be filled");
            }

            $user = $this->userModel->getUserByUsernameAndPassword(
                $username,
                $password
            );
            if (empty($user)) {
                return $this->sendNotFound();
            }

            $accessToken = JwtHelper::generateToken(
                array("username" => $user["username"])
            );
        
        } catch (\Throwable $th) {
            return $this->sendError($th);
        }


        $this->sendOkWithData(
            array(
                "success" => true,
                "access_token"=> $accessToken,
            )
        );
    }
}
