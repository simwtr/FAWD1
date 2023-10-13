<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity()
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Название задачи должно содержать минимум {{ limit }} символа",
     *      maxMessage = "Название задачи не должно превышать {{ limit }} символов"
     * )
     */
    private $title;

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
     * @ORM\Column(type="text")
     */
    private $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $dueDate;

    public function getDueDate(): ?DateTime
{
    return $this->dueDate;
}

public function setDueDate(?DateTime $dueDate): self
{
    $this->dueDate = $dueDate;
    return $this;
}

   /**
 * @ORM\Column(type="datetime")
 */
private $createdAt;

public function getCreatedAt(): ?\DateTimeInterface
{
    return $this->createdAt;
}


/**
 * @ORM\ManyToOne(targetEntity=Category::class)
 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
 */
    private $category;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

}