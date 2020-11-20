<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




/**
 * 
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!",
 *              "pagination_items_per_page"=2
 *       },
 * normalizationContext ={"groups"={"profil:read"}},
 * collectionOperations = {
 *      "getProfils" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils"
 *              
 *       },
 *       
 *       "addProfil" = {
 *              "method"= "POST",
 *              "path" = "/admin/profils",
 *              "normalization_context"={"groups"={"profil:write"}}   
 *       },
 * },
 * 
 * itemOperations = {
 *      "getUsersOfProfil" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}/users/"
 *              
 *       },
 *      "getProfilById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}"
 *              
 *       },
 *      "editProfil"={
 *          "method"= "PUT",
 *          "path"= "/admin/profils/{id}"
 *      },
 *       "archiverProfil" = {
 *          "method"= "PUT",
 *          "path" = "/admin/profils/{id}"
 *          
 *       }
 * 
 * })
 * @ORM\Entity(repositoryClass=ProfilsRepository::class)
 * @UniqueEntity(
 *     fields={"libelle"},
 *     message="This libell is already in use on that host."
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archived"})
 */
class Profils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Le mot de passe ne doit pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Le username ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le username ne doit pas dépasser {{ limit }} charactères"
     * )
     * 
     * @Groups({"profil:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"profil:read"})
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived =0;

    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

   

    
}
