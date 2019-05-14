<?php

namespace App\Entity;

use App\Model\People;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student extends People
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Training", mappedBy="students")
     */
    private $trainings;

    private $trainingChoice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValidated;

    public function __construct()
    {
        $this->isValidated = false;
        $this->trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function getTrainingsStr(): string
    {
        $collection = $this->getTrainings()->toArray();
        return implode(', ', $collection);
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->addStudent($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            $training->removeStudent($this);
        }

        return $this;
    }

    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrainingChoice()
    {
        return $this->trainingChoice;
    }

    /**
     * @param mixed $trainingChoice
     */
    public function setTrainingChoice($trainingChoice): void
    {
        $this->trainingChoice = $trainingChoice;
    }
}
