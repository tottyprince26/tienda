<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Form\ProductoFormType;
use App\Repository\ProductoRepository;
use Doctrine\Persistence\ManagerRegistry;

class DashboardController extends AbstractController
{

    //METODO para mostrar productos en el dashboard
    #[Route('/dashboard', name: 'app_principal')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $this -> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // <--- Add this line
        $entityManager = $doctrine->getManager();
        // Obtiene los datos de los productos desde la base de datos
        $productos = $entityManager->getRepository(Producto::class)->findAll();
        // Pasa los datos de los productos a la plantilla de Twig
        return $this->render('dashboard/index.html.twig', [
            'productos' => $productos,
            'controller_name' => 'DashboardController',
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
