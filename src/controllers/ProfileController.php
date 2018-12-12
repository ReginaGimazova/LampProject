<?php
/**
 * Created by PhpStorm.
 * User: rega
 * Date: 23.10.18
 * Time: 22:51
 */

namespace App\controllers;

use App\entities\User;
use App\services\UserService;
use App\services\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\resources\ExtraResources;

class ProfileController extends Controller
{

    private $response;
    private $userService;
    private $validationService;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->response = new Response();
        $this->userService = new UserService($entityManager);
        $this->validationService = new ValidationService();
    }

    public function openProfilePage($id, Request $request)
    {
        session_start();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {

            $this->response = $this->render('profile.html.twig', array(
                'email' => $user->getEmail(),
                'country' => $user->getCountry(),
                'gender' => $user->getGender(),
                'birthday' => $user->getDateOfBirth(),
                'id' => $id
            ));

            $data = $request->request->all();
            if (isset($data['delete'])) {
                $this->deleteProfile($id);
            }

            if (isset($data['edit'])) {
                $this->response = $this->redirectToRoute('edit_open', array('id' => $id));
            }

            if (isset($data['logout'])) {
                $this->response = $this->redirectToRoute('logout');
            }
        }
        else {
            $this->response = $this->redirectToRoute('auth_open');
        }
        return $this->response;
    }


    public function openEditPage($id){
       $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $this->response = $this->render('edit.html.twig', array(
            'email' => $user -> getEmail(),
            'country' => $user -> getCountry(),
            'gender' => $user -> getGender(),
            'countries' => ExtraResources::getListOfCountries(),
            'birthday' => $user -> getDateOfBirth()
        ));
        return $this->response;
    }

    public function edit(int $id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        if (isset($_POST["edit"])) {
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);

            if (!isset($user)) {
                echo("don't find user with this id");
            }
            else {
                $data = $request->request->all();
                $oldPassword = $data['old_password'];
                $newPassword = $data['new_password'];
                $repeatPassword = $data['repeat_password'];

                $checkData = false;
                if ($newPassword !== "" && $oldPassword !== "" && $repeatPassword !== "") {
                    $this->validationService->checkUpdatedPassword($oldPassword, $user->getPassword());
                    $this->validationService->checkConfirmPassword($repeatPassword, $newPassword);
                }

               $notices = $this->validationService->getNotices();

                foreach ($notices as $key => $notice) {
                    if ($notice == ""){
                        $checkData = true;
                    }
                    else{
                        $checkData = false;
                    }
                }

                if ($checkData) {
                    foreach ($data as $dataKey => $dataValue) {
                        $user->$dataKey = $dataValue;
                    }
                    if (isset($newPassword)){
                        $user->setPassword($newPassword);
                    }
                    $manager->flush();
                    $this->response = $this->redirectToRoute('profile_open', array('id' => $id));
                }
                else{
                    $this->response = $this->render('edit.html.twig', array(
                        'id' => $id,
                        'notices' => $notices,
                        'email' => $user->getEmail(),
                        'country' => $user->getCountry(),
                        'gender' => $user->getGender(),
                        'countries' => ExtraResources::getListOfCountries(),
                        'birthday' => $user->getDateOfBirth()));
                }


                if (!isset($newPassword, $repeatPassword, $oldPassword)) {
                    foreach ($data as $key => $notice) {
                        $user->$key = $notice;
                    }
                    $manager->flush();
                }
            }
        }

        return $this->response;
    }

    public function deleteProfile(int $id){
        $this->userService->deleteUser($id);
        $this->response = $this->redirectToRoute('auth_open');
        return $this->response;
    }
}