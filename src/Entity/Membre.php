<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ORM\Table(name: 'membres')]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $naissance = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $sang = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $assurance = 1;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $identite = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $type = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $source = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cn = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $dm = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $remarque = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    // Getters and setters...
}
