<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 30.10.18
 * Time: 23:29
 */

namespace App\controllers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExceptionPageController extends Controller
{
    public function showException(){
        return $this->render('errorPages/error_404.html.twig');
    }
}