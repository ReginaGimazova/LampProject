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
    public function logout(){
        if (!isset($_POST['logout'])) {

            session_unset();

            $this->response = $this->redirectToRoute('auth_open');
        }
        return $this->response;
    }}


