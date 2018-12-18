<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 17.12.18
 * Time: 23:29
 */

namespace App\controllers;

use App\types\FormType;
use App\services\ParsingFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    public function formBuilder(){

        $form = $this->createForm(FormType::class);

        $resp = $this->render("emptyForm.html.twig", array('form' => $form->createView()));
        return $resp;
    }

    public function writeXpathResult(){
        $result = ParsingFile::parseXmlFile();
        return $this->render("books.html.twig", array('books' => $result));

    }
}