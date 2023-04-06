<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Proveedor;
use App\Form\ProveedorFormType;
use App\Repository\ProveedorRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;


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
    #[Route('/proveedor/listar', name: 'app_proveedor_listar')]
    public function listarProveedor( ManagerRegistry $mar ): Response
    {
        $proveedores = $mar->getRepository(Proveedor::class)->findAll();
        return $this->render('proveedor/listarProveedor.html.twig', [
            'proveedores' => $proveedores,
        ]);
    }

    
    //METODO PARA EDITAR PRODUCTOS
    #[Route ('/proveedor/editar/{id}', name: 'app_proveedor_editar')]
    public function editProveedor(Proveedor $proveedor, Request $req, ManagerRegistry $mr): Response
    {
        $form = $this->createForm(ProveedorFormType::class, $proveedor);
        $form->handleRequest($req);
        if($form -> isSubmitted() && $form -> isValid()){   
            $em = $mr->getManager();
            $em->persist($proveedor);
            $em->flush();
            //return new Response('Producto editado correctamente.');
            return $this->redirectToRoute('app_proveedor_listar');

        }
        return $this->render('proveedor/editarProducto.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //METODO PARA ELIMINAR PRODUCTOS
    #[Route('/proveedor/eliminar/{id}', name: 'app_proveedor_eliminar')]
    public function eliminarProveedor(Proveedor $proveedor, ManagerRegistry $mry): RedirectResponse
    {
        $em = $mry->getManager();
        $em->remove($proveedor);
        $em->flush();
        //return new Response('Producto eliminado correctamente.');
        return $this->redirectToRoute('app_proveedor_listar');
    }
}
