<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsDeSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ApiResource(
 *  attributes = {
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!",
 *              "pagination_items_per_page"=2
 *       },
 * normalizationContext ={"groups"={"profilsdesortie:read"}},
 * collectionOperations = {
 *      "getProfilsDeSortie" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie"
 *              
 *       },
 *       
 *       "addProfilsDeSortie" = {
 *              "method"= "POST",
 *              "path" = "/admin/profilsdesortie",
 *              "normalization_context"={"groups"={"profilsdesortie:write"}}   
 *       },
 * },
 * itemOperations = {
 *      "getProfilDeSortie" = {
 *              "method"="GET",
 *              "path" ="/admin/profilsdesortie/{id}"
 *              
 *       },
 *       "editProfilDeSortie"={
 *          "method"= "PUT",
 *          "path"= "/admin/profilsdesortie/{id}"
 *      },
 * 
 * }
 * 
 * 
 * )
 * @ORM\Entity(repositoryClass=ProfilsDeSortieRepository::class)
 */
class ProfilsDeSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"profilsdesortie:read","profilsdesortie:write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilsDeSortie")
     * @Groups({"profilsdesortie:write"})
     */
    private $apprenant;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setProfilsDeSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilsDeSortie() === $this) {
                $apprenant->setProfilsDeSortie(null);
            }
        }

        return $this;
    }
}
