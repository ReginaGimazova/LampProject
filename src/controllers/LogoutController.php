<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 07.11.18
 * Time: 15:36
 */

namespace App\controllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        $this->response = $this->redirectToRoute('auth_open');
        return $this->response;
    }

}
