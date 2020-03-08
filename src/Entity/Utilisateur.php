<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity("email",
 *               message="Cette adresse email est deja utilisé")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="utilisateur")
     */
    private $tache;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTache(): Collection
    {
        return $this->tache;
    }

    public function addTach(Tache $tache): self
    {
        if (!$this->tache->contains($tache)) {
            $this->tache[] = $tache;
            $tache->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTach(Tache $tache): self
    {
        if ($this->tache->contains($tache)) {
            $this->tache->removeElement($tache);
            // set the owning side to null (unless already changed)
            if ($tache->getUtilisateur() === $this) {
                $tache->setUtilisateur(null);
            }
        }

       
        return $this;
    }

    public function __toString(){
        return $this->getEmail();
    }
}
