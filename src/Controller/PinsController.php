<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PinRepository $pinRepository): Response
    {
        //$pins = $pinRepository->findAll();

        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pins/index.html.twig', compact('pins'));
    }


    #[Route('/pins/create', name: 'app_pins_create')]
    public function create(Request $request, PinRepository $pinRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $pin = new Pin;

        $form = $this->createFormBuilder($pin)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //$pin = $form->getData();

            /*$pin = new Pin;

            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);*/

            $entityManagerInterface->persist($pin);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('pins/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/pins/{id<\d+>}', name: 'app_pins_show')]
    public function show(Pin $pin): Response
    {

        return $this->render('pins/show.html.twig', compact('pin'));
    }

    #[Route('/pins/{id<\d+>}/edit', name: 'app_pins_edit')]
    public function edit(Pin $pin, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $form = $this->createFormBuilder($pin)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //$pin = $form->getData();

            /*$pin = new Pin;

            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);*/

            //$entityManagerInterface->persist($pin);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('pins/edit.html.twig', [
            'pin' => $pin,
            'form' => $form->createView()
        ]);
    }
}
