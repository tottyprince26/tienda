<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistroUsuarioController extends AbstractController
{
    #[Route('/registro/usuario', name: 'app_registro_usuario')]
    public function index(Request $request, ManagerRegistry $mar,  ValidatorInterface $validator, UserPasswordHasherInterface $uphi): Response
    {
        $user = new User();
        $form = $this-> createForm(UserType ::class , $user);
        $form -> handleRequest($request);
        //dump($form->getErrors(true, true));
        if($form -> isSubmitted() && $form -> isValid() ){
            $user = $form -> getData();
            $user->setPassword($uphi->hashPassword($user, $form['password']->getData()));
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                $errorMessage = $errors->get(0)->getMessage();
                $this->addFlash('error', $errorMessage );
                //$this->addFlash('no success', 'Usuario ya existe');
                return $this->redirectToRoute('app_registro_usuario');
            }else{
                $em = $mar -> getManager();
                $em -> persist($user);
                $em -> flush();
                $this->addFlash('success', 'Usuario registrado correctamente');
                return $this->redirectToRoute('app_registro_usuario');
            }
        }
        return $this->render('registro_usuario/index.html.twig', [
            'formulario' => $form -> createView(),
        ]);
    }
}
