<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 07.11.18
 * Time: 12:48
 */

namespace App\controllers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    private $userService;
    private $response;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->userService = new UserService($entityManager);
        $this->response = new Response();
    }

    public function openAuthenticationPage(){
        $this->response = $this->render('auth.html.twig');
        return $this->response;
    }

    public function authentication(Request $request){
        session_start();

        $data = $request->request->all();

        if (isset($data['submit'])) {

            $email = $data['email'];
            $password = $data['password'];

            $user = $this->userService->findUserByEmailAndPswd($email, $password);

            if ($user != null) {

                $_SESSION['user_id'] = $user["u_id"];
                $_SESSION['timeout'] = time();

             /*   if (!empty($_POST['remember-me'])){
                    setcookie('member_login', $_POST['auth_email'], time() + 20000);
                    setcookie('member_password', $_POST['auth_password'], time() + 20000);
                }
                else {

                    if (isset($_COOKIE['member_login'])) {
                        setcookie("member_login", "");
                    }
                    if (isset($_COOKIE['member_password'])) {
                        setcookie("member_password", "");
                    }
                }*/
            }
        }

        if (isset($_SESSION['user_id'])){
            $this->response = $this->redirectToRoute('profile_open', array('id' => $user['u_id']));
            return $this->response;
        }
        else{
            $this->response = $this->redirectToRoute('auth_open');
            return $this->response;
        }
    }
}