<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    #[Route('/membres', name: 'membres_index')]
    public function index(): Response
    {
        return $this->render('membres/index.html.twig');
    }

    #[Route('/membres/data', name: 'membres_data')]
    public function getData(MembreRepository $repository, Request $request): JsonResponse
    {
        $membres = $repository->findAll();
        $data = [];

        foreach ($membres as $membre) {
            $data[] = [
                $membre->getId(),
                $membre->getNom(),
                $membre->getPrenom(),
                $membre->getTelephone(),
                $membre->getAdresse(),
                $membre->getSexe(),
            ];
        }

        return new JsonResponse(['data' => $data]);
    }
}
