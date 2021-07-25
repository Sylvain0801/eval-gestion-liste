<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 */
class Liste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Todo::class, mappedBy="liste")
     */
    private $todos;

    /**
     * @var \DateTimeImmutable $ updated_at
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @var \DateTimeImmutable $ created_at
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function __construct()
    {
        $this->todos = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Todo[]
     */
    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function addTodo(Todo $todo): self
    {
        if (!$this->todos->contains($todo)) {
            $this->todos[] = $todo;
            $todo->setListe($this);
        }

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->removeElement($todo)) {
            // set the owning side to null (unless already changed)
            if ($todo->getListe() === $this) {
                $todo->setListe(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * Set $ created_at
     *
     * @param  \DateTimeImmutable  $updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at(\DateTimeImmutable $updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get $ updated_at
     *
     * @return  \DateTimeImmutable
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

}
