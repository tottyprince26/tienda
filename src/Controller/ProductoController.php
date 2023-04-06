<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Form\ProductoFormType;
use App\Repository\ProductoRepository;
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
/*
    #[Route('/producto/editar/{id}', name: 'app_producto_editar', methods: ['GET', 'POST'])]
    public function editarProducto(Request $req,Producto $producto,ProductoRepository $pr): Response
    {
        $mensaje ="";
        $estado="";
        $form = $this->createForm(ProductoFormType ::class ,   $producto, ['accion' => 'editar']);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $estado = $form->get('estado')->getData();
            $pr->cambiarEstado($producto->getId(),$estado);
            $mensaje = "El estado del producto se ha cambiado a ".$estado;
            return $this->redirectToRoute('app_producto_listar');
        }
    }
*/
    #[Route('/producto/listar', name: 'app_producto_listar')]
    public function listarProducto( ManagerRegistry $mar ): Response
    {
        $productos = $mar->getRepository(Producto::class)->findAll();
        return $this->render('producto/listarProducto.html.twig', [
            'productos' => $productos,
        ]);
    }

}
