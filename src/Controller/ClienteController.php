<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\FormularioClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IndicenciaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route('/nuevoCliente', name: 'nuevoCliente')]
    public function nuevo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cliente = new Cliente();
        $form = $this->createForm(FormularioClienteType::class, $cliente);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cliente);
            $entityManager->flush();

            return $this->redirectToRoute('todoslosclientes');
        }

        return $this->render('cliente/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route(path: '/cliente/todoslosclientes', name: 'todoslosclientes')]
    public function verClientes(EntityManagerInterface $entityManager): Response
    {
        $clientes = $entityManager->getRepository(Cliente::class)->findAll();

        return $this->render('cliente/todoslosclientes.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route(path: '/cliente/eliminar/{id}', name: 'eliminarCliente')]
    public function eliminar(Request $request, $id, EntityManagerInterface $entityManager): Response
{
    $cliente = $entityManager->getRepository(Cliente::class)->find($id);

    if (!$cliente) {
        throw $this->createNotFoundException('No se encontró el cliente con ID '.$id);
    }

    $entityManager->remove($cliente);
    $entityManager->flush();

    // Mensaje de confirmación
    $this->addFlash('success', 'Cliente eliminado con éxito.');

    return $this->redirectToRoute('todoslosclientes');
}

#[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
#[Route(path: '/cliente/verIncidencias/{id}', name: 'verIncidenciasCliente')]
public function incidenciasPorCliente(int $id, IndicenciaRepository $incidenciaRepository): Response
    {
        $incidencias = $incidenciaRepository->findBy(['cliente' => $id]);

        return $this->render('incidencia/incidenciasDelCliente.html.twig', [
            'incidencias' => $incidencias,
            'clienteId' => $id,
        ]);
    }

}
