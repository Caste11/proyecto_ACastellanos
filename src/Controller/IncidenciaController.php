<?php

namespace App\Controller;

use App\Entity\Indicencia;
use App\Entity\Cliente;
use App\Form\FormularioIncidenciasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\FormularioIncidenciasClienteType;

class IncidenciaController extends AbstractController
{
    #[Route('/inciencia', name: 'app_inciencia')]
    public function index(): Response
    {
        return $this->render('inciencia/index.html.twig', [
            'controller_name' => 'IncienciaController',
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route('/nuevaIncidencia', name: 'nuevaIncidencia')]
    public function nueva(Request $request, EntityManagerInterface $entityManager): Response
    {
        $incidencia = new Indicencia();
        $form = $this->createForm(FormularioIncidenciasType::class, $incidencia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incidencia->setUser($this->getUser());
            $entityManager->persist($incidencia);
            $entityManager->flush();

            $this->addFlash('success', 'Incidencia creada con éxito.');

            return $this->redirectToRoute('todaslasincidencias');
        }

        return $this->render('incidencia/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route(path: '/incidencia/todaslasincidencias', name: 'todaslasincidencias')]
    public function verIncidencias(EntityManagerInterface $entityManager): Response
    {
        $incidencias = $entityManager->getRepository(Indicencia::class)->findBy([], ['fecha_creacion' => 'DESC']);

        return $this->render('incidencia/todaslasincidencias.html.twig', [
            'incidencias' => $incidencias,
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route(path: '/incidencia/eliminar/{id}', name: 'eliminarIncidencia')]
    public function eliminar(Request $request, $id, EntityManagerInterface $entityManager): Response
{
    $incidencia = $entityManager->getRepository(Indicencia::class)->find($id);

    if (!$incidencia) {
        throw $this->createNotFoundException('No se encontró la Incidencia con ID '.$id);
    }

    $entityManager->remove($incidencia);
    $entityManager->flush();

    // Mensaje de confirmación
    $this->addFlash('success', 'Incidencia eliminada con éxito.');

    return $this->redirectToRoute('todaslasincidencias');
}
#[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
#[Route(path: '/incidencia/editar/{id}', name: 'editarIncidencia')]
public function editar(Request $request, Indicencia $incidencia, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(FormularioIncidenciasType::class, $incidencia);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $incidencia->setUser($this->getUser());
        $entityManager->persist($incidencia);
        $entityManager->flush();

        $this->addFlash('success', 'Incidencia actualizado con éxito.');

        return $this->redirectToRoute('todaslasincidencias');
    }

    return $this->render('incidencia/editarIncidencia.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
#[Route(path: '/incidencia/eliminarIncidenciaCliente/{id}', name: 'eliminarIncidenciaCliente')]
public function eliminarIncidenciaCliente(Request $request, $id, EntityManagerInterface $entityManager): Response
{
$incidencia = $entityManager->getRepository(Indicencia::class)->find($id);

if (!$incidencia) {
    throw $this->createNotFoundException('No se encontró la Incidencia con ID '.$id);
}

$entityManager->remove($incidencia);
$entityManager->flush();

// Mensaje de confirmación
$this->addFlash('success', 'Incidencia eliminada con éxito.');

return $this->redirectToRoute('verIncidenciasCliente',['id' => $incidencia->getCliente()->getId() ]);
}
#[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
#[Route(path: '/incidencia/editarIncidenciaCliente/{id}', name: 'editarIncidenciaCliente')]
public function editarIncidenciaCliente(Request $request, Indicencia $incidencia, EntityManagerInterface $entityManager): Response
{
$form = $this->createForm(FormularioIncidenciasClienteType::class, $incidencia);

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $incidencia->setUser($this->getUser());
    $entityManager->persist($incidencia);
    $entityManager->flush();

    $this->addFlash('success', 'Incidencia actualizado con éxito.');

    return $this->redirectToRoute('verIncidenciasCliente',['id' => $incidencia->getCliente()->getId() ]);
}

return $this->render('incidencia/editarIncidencia.html.twig', [
    'form' => $form->createView(),
]);
}

#[IsGranted('ROLE_USER', message: 'Tienes que estas autentificado')]
    #[Route('/nuevaIncidencia/{id}', name: 'nuevaIncidenciaCliente')]
    public function nuevaIncidenciaCliente(Request $request, $id ,EntityManagerInterface $entityManager): Response
    {
        $incidencia = new Indicencia();
        $form = $this->createForm(FormularioIncidenciasClienteType::class, $incidencia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cliente = $entityManager->getRepository(Cliente::class)->find($id);
            $incidencia->setCliente($cliente);
            $incidencia->setUser($this->getUser());
            $entityManager->persist($incidencia);
            $entityManager->flush();

            $this->addFlash('success', 'Incidencia creada con éxito.');

            return $this->redirectToRoute('verIncidenciasCliente',['id' => $incidencia->getCliente()->getId() ]);
        }

        return $this->render('incidencia/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}