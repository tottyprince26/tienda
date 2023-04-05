<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Form\ProductoFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class ProductoController extends AbstractController
{
    #[Route('/producto', name: 'app_producto')]
    public function insertarProducto(Request $req, ManagerRegistry $mry): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoFormType ::class ,   $producto);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mry->getManager();
            $em->persist($producto);
            $em->flush();
            //$this->addFlash('success', 'Proveedor agregado correctamente.');
            return $this->redirectToRoute('app_producto');
        }
        return $this->render('producto/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
