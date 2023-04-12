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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductoController extends AbstractController{

    //METODO PARA INSERTAR PRODUCTOS
    #[Route('/producto', name: 'app_producto')]
    public function insertarProducto(Request $req, ManagerRegistry $mry): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoFormType ::class ,   $producto);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mry->getManager();
            $imagen = $form->get('imagen')->getdata();
            if ($imagen instanceof UploadedFile) {
                $contenido = file_get_contents($imagen->getRealPath());
                $producto->setImagen($contenido);
            }
            $em->persist($producto);
            $em->flush();
            //return new Response('Producto agregado correctamente.');
            return $this->redirectToRoute('app_producto');
        }
        return $this->render('producto/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }

    //METODO PARA LISTAR PRODUCTOS
    #[Route('/producto/listar', name: 'app_producto_listar')]
    public function listarProducto( ManagerRegistry $mar): Response
    {
        $productos = $mar->getRepository(Producto::class)->findAll();
        return $this->render('producto/listarProducto.html.twig', [
            'productos' => $productos,
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
    
    //METODO PARA EDITAR PRODUCTOS
    #[Route ('/producto/editar/{id}', name: 'app_producto_editar')]
    public function edit(Producto $producto, Request $req, ManagerRegistry $mr): Response
    {
        $form = $this->createForm(ProductoFormType::class, $producto);
        $form->handleRequest($req);
        if($form -> isSubmitted() && $form -> isValid()){   
            $em = $mr->getManager();
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('app_producto_listar');
        }
        return $this->render('producto/editarProducto.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //METODO PARA ELIMINAR PRODUCTOS
    #[Route('/producto/eliminar/{id}', name: 'app_producto_eliminar')]
    public function eliminarProducto(Producto $producto, ManagerRegistry $mry): RedirectResponse
    {
        $em = $mry->getManager();
        $em->remove($producto);
        $em->flush();
        //return new Response('Producto eliminado correctamente.');
        return $this->redirectToRoute('app_producto_listar');
    }

}
