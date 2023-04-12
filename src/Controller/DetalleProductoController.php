<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use Doctrine\Persistence\ManagerRegistry;

class DetalleProductoController extends AbstractController{
    #[Route('/detalle/producto/{id}', name: 'app_detalle_producto')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        // Obtiene los datos de los productos desde la base de datos
        $productos = $em->getRepository(Producto::class);        
        return $this->render('detalle_producto/index.html.twig', [
            'productos' => $productos,
            'controller_name' => 'DetalleProductoController',
        ]);
    }
   
    //METODO PARA MOSTRAR IMAGENES DE PRODUCTOS
    #[Route('/producto/imagen/{id}', name: 'app_producto_imagen')]
    public function mostrarImagen(ManagerRegistry $mar, $id)
    {
        $producto = $mar->getRepository(Producto::class)->find($id);
        $imagen = $producto->getImagen();
        $response = new Response($imagen);
        $response->headers->set('Content-Type', 'image/jpeg');
        return $response;
    }
}
