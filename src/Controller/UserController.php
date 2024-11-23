<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    // Liste des utilisateurs
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // Afficher le formulaire de création (GET)
    #[Route('/new', name: 'user_create_get', methods: ['GET'])]
    public function createGet(): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Traiter les données de création (POST)
    #[Route('/new', name: 'user_store', methods: ['POST'])]
    public function store(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès.');

            return $this->redirectToRoute('user_index');
        }

        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Afficher les détails d'un utilisateur
    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    // Afficher le formulaire de modification (GET)
    #[Route('/{id}/edit', name: 'user_edit_get', methods: ['GET'])]
    public function editGet(User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // Traiter les données de modification (POST)
    #[Route('/{id}/edit', name: 'user_update', methods: ['POST'])]
    public function update(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur mis à jour avec succès.');

            return $this->redirectToRoute('user_index');
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // Supprimer un utilisateur
    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        }

        return $this->redirectToRoute('user_index');
    }
}
