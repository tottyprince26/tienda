<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Proveedor;
use App\Form\ProveedorFormType;

class ProveedorController extends AbstractController
{
    #[Route('/proveedor', name: 'app_proveedor')]
    public function insertarProveedor(Request $req, ManagerRegistry $mry): Response
    {
        $proveedor = new Proveedor();
        $form = $this->createForm(ProveedorFormType ::class ,   $proveedor);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mry->getManager();
            $em->persist($proveedor);
            $em->flush();
            //$this->addFlash('success', 'Proveedor agregado correctamente.');
            return $this->redirectToRoute('app_proveedor');
        }
        return $this->render('proveedor/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
