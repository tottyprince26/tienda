<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClienteController extends AbstractController
{

     //METODO PARA LISTAR clientes
     #[Route('/cliente', name: 'app_cliente')]
     public function listarclientes( ManagerRegistry $mar): Response
     {
         $cliente = $mar->getRepository(User::class)->findAll();
         return $this->render('cliente/index.html.twig', [
             'clientes' => $cliente,
         ]);
     }

      //METODO PARA EDITAR CLIENTES
    #[Route ('/cliente/editar/{id}', name: 'app_cliente_editar')]
    public function edit(User $user, Request $req, ManagerRegistry $mr, UserPasswordHasherInterface $uphi): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if($form -> isSubmitted() && $form -> isValid()){   
            $user = $form -> getData();
            $user->setPassword($uphi->hashPassword($user, $form['password']->getData()));
            $em = $mr->getManager();
            $em->persist($user);
            $em->flush();
            //return new Response('Producto editado correctamente.');
            return $this->redirectToRoute('app_cliente');
        }
        return $this->render('cliente/editarCliente.html.twig', [
            'form' => $form->createView(),
        ]);
    }

      //METODO PARA ELIMINAR CLIENTES
    #[Route('/cliente/eliminar/{id}', name: 'app_cliente_eliminar')]
    public function eliminarCliente(User $user, ManagerRegistry $mry): RedirectResponse
    {
        $em = $mry->getManager();
        $em->remove($user);
        $em->flush();
        //return new Response('cliente eliminado correctamente.');
        return $this->redirectToRoute('app_cliente');
    }

}
