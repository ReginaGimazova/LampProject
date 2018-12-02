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
    private $notices;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->response = new Response();
        $this->userService = new UserService($entityManager);
        $this->validationService = new ValidationService();
    }

    public function openProfilePage($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $this->response = $this->render('profile.html.twig', array(
            'email' => $user -> getEmail(),
            'country' => $user -> getCountry(),
            'gender' => $user -> getGender(),
            'birthday' => $user -> getDateOfBirth(),
            'id' => $id
            ));

        $data = $request -> request -> all();
        if(isset($data['delete'])){
            $this->deleteProfile($id);
        }

        if (isset($data['edit'])){
            $this->response = $this->redirectToRoute('edit_open', array('id'=> $id));
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
                $newPassword = $data['new_password'];
                $repeatPassword = $data['repeat_password'];
                $this->validationService->checkUpdatedPassword($data['old_password'], $user->getPassword());
                $this->validationService->checkConfirmPassword($repeatPassword, $newPassword);
                $this->notices = $this->validationService->getNotice();
                $notice_array = [];
                if ($this->notices->__toString() == "") {
                    foreach ($data as $key => $value) {
                        $user->$key = $value;
                    }
                    $user->setPassword($newPassword);
                    $manager->flush();
                } elseif (!isset($newPassword, $repeatPassword, $data['old_password'])) {
                    foreach ($data as $key => $value) {
                        $user->$key = $value;
                    }
                    $manager->flush();
                }

                foreach ($this->notices as $key => $value){
                    $notice_array[$key] = $value;
                }
                if ($this->notices->__toString() !== "") {
                    $this->response = $this->render('edit.html.twig', array(
                        'id' => $id,
                        'notices' => $notice_array,
                        'email' => $user->getEmail(),
                        'country' => $user->getCountry(),
                        'gender' => $user->getGender(),
                        'countries' => ExtraResources::getListOfCountries(),
                        'birthday' => $user->getDateOfBirth()));
                } else {
                    $this->response = $this->redirectToRoute('profile_open', array('id' => $id));

                }
            }
        }

        return $this->response;
    }

    public function deleteProfile(int $id){
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);
        $manager->remove($user);
        $manager->flush();
    }

}