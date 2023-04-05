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

class RegistroUsuarioController extends AbstractController
{
    #[Route('/registro/usuario', name: 'app_registro_usuario')]
    public function index(Request $request, ManagerRegistry $mar): Response
    {
        $user = new User();
        $form = $this-> createForm(UserType ::class , $user);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid() ){
            $user = $form -> getData();
            $em = $mar -> getManager();
            $em -> persist($user);
            $em -> flush();
            $this->addFlash('success', 'Usuario registrado correctamente');
            return $this->redirectToRoute('app_registro_usuario');
        }
        return $this->render('registro_usuario/index.html.twig', [
            'formulario' => $form -> createView(),
        ]);
    }
}
