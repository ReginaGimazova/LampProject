<?php
/**
 * Created by PhpStorm.
 * User: rega
 * Date: 07.10.18
 * Time: 21:46
 */

namespace App\controllers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\entities\User;
use App\services\UserService;
use App\resources\ExtraResources;
use App\services\ValidationService;

class RegistrationController extends Controller
{

    private $list = [];
    private $res;
    private $response;
    private $userService;
    private $validationService;
    private $notices = [];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->res = new ExtraResources();
        $this->list = $this->res->getListOfCountries();
        $this->validationService = new ValidationService();
        $this->response = new Response();
        $this->userService = new UserService($entityManager);
    }

    function openRegistrationPage()
    {
        return $this->render('reg.html.twig', [
            'list' => $this->list
        ]);
    }


    function registration(Request $request)
    {

        $user = new User();
        $manager = $this->getDoctrine()->getManager();

        if (isset($_POST['submit'])) {

            $data = $request->request->all();

            $this->validationService->checkUser($data);
            $this->notices = $this->validationService->getNotices();
            var_dump($this->notices);

            foreach ($this->notices as $key => $value ){
                if ($value !== ""){
                    var_dump("not empty");
                    $this->response = $this->render('reg.html.twig', [
                        'notices' => $this->notices, 'list' => $this->list
                    ]);
                }

                else {

                    var_dump("empty");
                    foreach ($data as $dataKey => $dataValue) {

                        $user->$dataKey = $dataValue;
                    }

                    $manager->persist($user);
                    $manager->flush();

                    $this->response = $this->redirectToRoute('auth_open');
                }
            }



        }
        return $this->response;
    }
}

