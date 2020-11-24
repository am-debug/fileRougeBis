<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant extends User
{
   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilsDeSortie::class, inversedBy="apprenant")
     */
    private $profilsDeSortie;

   
    
    

   
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProfilsDeSortie(): ?ProfilsDeSortie
    {
        return $this->profilsDeSortie;
    }

    public function setProfilsDeSortie(?ProfilsDeSortie $profilsDeSortie): self
    {
        $this->profilsDeSortie = $profilsDeSortie;

        return $this;
    }

    

   
}
