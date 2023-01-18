<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    private ?Sport $sport = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $begin_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: LessonUser::class)]
    private Collection $lessonUsers;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    private ?User $instructor = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->lessonUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getBeginTime(): ?\DateTimeInterface
    {
        return $this->begin_time;
    }

    public function setBeginTime(\DateTimeInterface $begin_time): self
    {
        $this->begin_time = $begin_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    /**
     * @return Collection<int, LessonUser>
     */
    public function getLessonUsers(): Collection
    {
        return $this->lessonUsers;
    }

    public function addLessonUser(LessonUser $lessonUser): self
    {
        if (!$this->lessonUsers->contains($lessonUser)) {
            $this->lessonUsers->add($lessonUser);
            $lessonUser->setLesson($this);
        }

        return $this;
    }

    public function removeLessonUser(LessonUser $lessonUser): self
    {
        if ($this->lessonUsers->removeElement($lessonUser)) {
            // set the owning side to null (unless already changed)
            if ($lessonUser->getLesson() === $this) {
                $lessonUser->setLesson(null);
            }
        }

        return $this;
    }

    public function getInstructor(): ?User
    {
        return $this->instructor;
    }

    public function setInstructor(?User $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }


}
