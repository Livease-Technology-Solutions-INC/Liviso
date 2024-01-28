<?php

namespace App\Entity;

use App\Entity\Zoom;
use App\Entity\SupportSystem;
use App\Entity\HRMSystem\Trip;
use App\Entity\HRMSystem\Award;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Account\UserImage;
use App\Entity\HRMSystem\Trainer;
use App\Entity\HRMSystem\Warning;
use App\Entity\HRMSystem\Holidays;
use App\Entity\HRMSystem\Transfer;
use App\Repository\UserRepository;
use App\Entity\Account\UserProfile;
use App\Entity\HRMSystem\Complaints;
use App\Entity\HRMSystem\ManageLeave;
use App\Entity\HRMSystem\Resignation;
use App\Entity\HRMSystem\GoalTracking;
use App\Entity\HRMSystem\CustomQuestions;
use Doctrine\Common\Collections\Collection;
use App\Entity\HRMSystem\EmployeesAssetSetup;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: UserProfile::class, mappedBy: "user", cascade: ["persist", "remove"])]
    private ?UserProfile $profile = null;
    
    #[ORM\OneToMany(targetEntity: UserImage::class, mappedBy: "user", cascade: ["persist", "remove"])]
    private $userImages;
    
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;
    
    #[ORM\Column]
    private array $roles = [];
    
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;
    // ...
    
    /**
     */
    #[ORM\Column]
    private ?string $fullName = null;

    #[ORM\Column]
    private ?string $companyName = null;

    #[ORM\Column(nullable: true)]
    private ?string $location = null;
    
    // ...
    
    /**
     * @var Collection|User[]
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: "parentUser")]
    private $linkedUsers;
    
    /**
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "linkedUsers")]
    private ?User $parentUser = null;
    
    #[ORM\OneToMany(targetEntity: Zoom::class, mappedBy: "user")]
    private Collection $zoomMeetings;

    #[ORM\OneToMany(targetEntity: Webhook::class, mappedBy: "user")]
    private Collection $webhook;

    #[ORM\OneToMany(targetEntity: SupportSystem::class, mappedBy: "user")]
    private Collection $supportSystem;

    #[ORM\OneToMany(targetEntity: Complaints::class, mappedBy: "user")]
    private Collection $complaints;

    #[ORM\OneToMany(targetEntity: CustomQuestions::class, mappedBy: "user")]
    private Collection $customQuestions;

    #[ORM\OneToMany(targetEntity: EmployeesAssetSetup::class, mappedBy: "user")]
    private Collection $employeesAssetSetup;

    #[ORM\OneToMany(targetEntity: Holidays::class, mappedBy: "user")]
    private Collection $holidays;

    #[ORM\OneToMany(targetEntity: Trip::class, mappedBy: "user")]
    private Collection $trip;
    
    #[ORM\OneToMany(targetEntity: Warning::class, mappedBy: "user")]
    private Collection $warning;

    #[ORM\OneToMany(targetEntity: ManageLeave::class, mappedBy: "user")]
    private Collection $manageLeave;

    #[ORM\OneToMany(targetEntity: Resignation::class, mappedBy: "user")]
    private Collection $resignation;

    #[ORM\OneToMany(targetEntity: GoalTracking::class, mappedBy: "user")]
    private Collection $goalTracking;
    
    
    // #[ORM\OneToMany(targetEntity: TrainingList::class, mappedBy: "user")]
    // private Collection $trainingList;

    #[ORM\OneToMany(targetEntity: Trainer::class, mappedBy: "user")]
    private Collection $trainer;
    
    #[ORM\OneToMany(targetEntity: Award::class, mappedBy: "user")]
    private Collection $award;
    
    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: "user")]
    private Collection $transfer;
    
    public function __construct()
    {
        $this->profile = new UserProfile();
        $this->profile->setUser($this);
        $this->userImages = new ArrayCollection();
        $this->linkedUsers = new ArrayCollection();
        $this->zoomMeetings = new ArrayCollection();
        $this->webhook = new ArrayCollection();
        $this->supportSystem = new ArrayCollection();
        $this->complaints = new ArrayCollection();
        $this->customQuestions = new ArrayCollection();
        $this->employeesAssetSetup = new ArrayCollection();
        $this->holidays = new ArrayCollection();
        $this->trip = new ArrayCollection();
        $this->warning = new ArrayCollection();
        $this->manageLeave = new ArrayCollection();
        $this->resignation = new ArrayCollection();
        $this->goalTracking = new ArrayCollection();
        // $this->trainingList = new ArrayCollection();
        $this->trainer = new ArrayCollection();
        $this->award = new ArrayCollection();
        $this->transfer = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFullName(); 
    }
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    // User.php

    // ...

    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

    public function setProfile(?UserProfile $profile): self
    {
        $this->profile = $profile;

        // Be sure to set the user on the profile side as well
        if ($profile !== null) {
            $profile->setUser($this);
        }

        return $this;
    }

    public function addProfile(UserProfile $profile): self
    {
        if ($this->profile !== null) {
            throw new \LogicException('User already has a profile.');
        }

        // Set the profile on the user
        $this->profile = $profile;

        // Set the user on the profile
        $profile->setUser($this);

        return $this;
    }



    // ...


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function removeProfile(UserProfile $profile): static
    {
        if ($profile->getUser() === $this) {
            // Set the profile on the user to null
            $this->profile = null;

            // Set the user on the profile to null
            $profile->setUser(null);
        }

        return $this;
    }
    public function getUserImages(): Collection
    {
        return $this->userImages;
    }

    public function addUserImage(UserImage $userImage): self
    {
        if (!$this->userImages->contains($userImage)) {
            $this->userImages[] = $userImage;
            $userImage->setUser($this);
        }

        return $this;
    }

    public function removeUserImage(UserImage $userImage): self
    {
        if ($this->userImages->removeElement($userImage)) {
            if ($userImage->getUser() === $this) {
                $userImage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLinkedUsers(): Collection
    {
        return $this->linkedUsers;
    }

    public function addLinkedUser(User $user): self
    {
        if (!$this->linkedUsers->contains($user)) {
            $this->linkedUsers[] = $user;
            $user->setParentUser($this);
        }

        return $this;
    }

    public function removeLinkedUser(User $user): self
    {
        if ($this->linkedUsers->removeElement($user)) {
            if ($user->getParentUser() === $this) {
                $user->setParentUser(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getParentUser(): ?User
    {
        return $this->parentUser;
    }

    public function setParentUser(?User $parentUser): self
    {
        $this->parentUser = $parentUser;

        return $this;
    }

    public function getZoomMeetings(): Collection
    {
        return $this->zoomMeetings;
    }

    public function addZoomMeeting(Zoom $zoom): void
    {
        if (!$this->zoomMeetings->contains($zoom)) {
            $this->zoomMeetings[] = $zoom;
            $zoom->setUser($this);
        }
    }

    public function removeZoomMeeting(Zoom $zoom): void
    {
        $this->zoomMeetings->removeElement($zoom);
    }

    /**
     * @return Collection<int, Webhook>
     */
    public function getWebhook(): Collection
    {
        return $this->webhook;
    }

    public function addWebhook(Webhook $webhook): static
    {
        if (!$this->webhook->contains($webhook)) {
            $this->webhook->add($webhook);
            $webhook->setUser($this);
        }

        return $this;
    }

    public function removeWebhook(Webhook $webhook): static
    {
        if ($this->webhook->removeElement($webhook)) {
            // set the owning side to null (unless already changed)
            if ($webhook->getUser() === $this) {
                $webhook->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SupportSystem>
     */
    public function getSupportSystem(): Collection
    {
        return $this->supportSystem;
    }

    public function addSupportSystem(SupportSystem $supportSystem): static
    {
        if (!$this->supportSystem->contains($supportSystem)) {
            $this->supportSystem->add($supportSystem);
            $supportSystem->setUser($this);
        }

        return $this;
    }

    public function removeSupportSystem(SupportSystem $supportSystem): static
    {
        if ($this->supportSystem->removeElement($supportSystem)) {
            // set the owning side to null (unless already changed)
            if ($supportSystem->getUser() === $this) {
                $supportSystem->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Complaints>
     */
    public function getComplaints(): Collection
    {
        return $this->complaints;
    }

    public function addComplaint(Complaints $complaint): static
    {
        if (!$this->complaints->contains($complaint)) {
            $this->complaints->add($complaint);
            $complaint->setUser($this);
        }

        return $this;
    }

    public function removeComplaint(Complaints $complaint): static
    {
        if ($this->complaints->removeElement($complaint)) {
            // set the owning side to null (unless already changed)
            if ($complaint->getUser() === $this) {
                $complaint->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomQuestions>
     */
    public function getCustomQuestions(): Collection
    {
        return $this->customQuestions;
    }

    public function addCustomQuestion(CustomQuestions $customQuestion): static
    {
        if (!$this->customQuestions->contains($customQuestion)) {
            $this->customQuestions->add($customQuestion);
            $customQuestion->setUser($this);
        }

        return $this;
    }

    public function removeCustomQuestion(CustomQuestions $customQuestion): static
    {
        if ($this->customQuestions->removeElement($customQuestion)) {
            // set the owning side to null (unless already changed)
            if ($customQuestion->getUser() === $this) {
                $customQuestion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeesAssetSetup>
     */
    public function getEmployeesAssetSetup(): Collection
    {
        return $this->employeesAssetSetup;
    }

    public function addEmployeesAssetSetup(EmployeesAssetSetup $employeesAssetSetup): static
    {
        if (!$this->employeesAssetSetup->contains($employeesAssetSetup)) {
            $this->employeesAssetSetup->add($employeesAssetSetup);
            $employeesAssetSetup->setUser($this);
        }

        return $this;
    }

    public function removeEmployeesAssetSetup(EmployeesAssetSetup $employeesAssetSetup): static
    {
        if ($this->employeesAssetSetup->removeElement($employeesAssetSetup)) {
            // set the owning side to null (unless already changed)
            if ($employeesAssetSetup->getUser() === $this) {
                $employeesAssetSetup->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Holidays>
     */
    public function getHolidays(): Collection
    {
        return $this->holidays;
    }

    public function addHoliday(Holidays $holiday): static
    {
        if (!$this->holidays->contains($holiday)) {
            $this->holidays->add($holiday);
            $holiday->setUser($this);
        }

        return $this;
    }

    public function removeHoliday(Holidays $holiday): static
    {
        if ($this->holidays->removeElement($holiday)) {
            // set the owning side to null (unless already changed)
            if ($holiday->getUser() === $this) {
                $holiday->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trip>
     */
    public function getTrip(): Collection
    {
        return $this->trip;
    }

    public function addTrip(Trip $trip): static
    {
        if (!$this->trip->contains($trip)) {
            $this->trip->add($trip);
            $trip->setUser($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): static
    {
        if ($this->trip->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getUser() === $this) {
                $trip->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Warning>
     */
    public function getWarning(): Collection
    {
        return $this->warning;
    }

    public function addWarning(Warning $warning): static
    {
        if (!$this->warning->contains($warning)) {
            $this->warning->add($warning);
            $warning->setUser($this);
        }

        return $this;
    }

    public function removeWarning(Warning $warning): static
    {
        if ($this->warning->removeElement($warning)) {
            // set the owning side to null (unless already changed)
            if ($warning->getUser() === $this) {
                $warning->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ManageLeave>
     */
    public function getManageLeave(): Collection
    {
        return $this->manageLeave;
    }

    public function addManageLeave(ManageLeave $manageLeave): static
    {
        if (!$this->manageLeave->contains($manageLeave)) {
            $this->manageLeave->add($manageLeave);
            $manageLeave->setUser($this);
        }

        return $this;
    }

    public function removeManageLeave(ManageLeave $manageLeave): static
    {
        if ($this->manageLeave->removeElement($manageLeave)) {
            // set the owning side to null (unless already changed)
            if ($manageLeave->getUser() === $this) {
                $manageLeave->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Resignation>
     */
    public function getResignation(): Collection
    {
        return $this->resignation;
    }

    public function addResignation(Resignation $resignation): static
    {
        if (!$this->resignation->contains($resignation)) {
            $this->resignation->add($resignation);
            $resignation->setUser($this);
        }

        return $this;
    }

    public function removeResignation(Resignation $resignation): static
    {
        if ($this->resignation->removeElement($resignation)) {
            // set the owning side to null (unless already changed)
            if ($resignation->getUser() === $this) {
                $resignation->setUser(null);
            }
        }

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, GoalTracking>
     */
    public function getGoalTracking(): Collection
    {
        return $this->goalTracking;
    }

    public function addGoalTracking(GoalTracking $goalTracking): static
    {
        if (!$this->goalTracking->contains($goalTracking)) {
            $this->goalTracking->add($goalTracking);
            $goalTracking->setUser($this);
        }

        return $this;
    }

    public function removeGoalTracking(GoalTracking $goalTracking): static
    {
        if ($this->goalTracking->removeElement($goalTracking)) {
            // set the owning side to null (unless already changed)
            if ($goalTracking->getUser() === $this) {
                $goalTracking->setUser(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, TrainingList>
    //  */
    // public function getTrainingList(): Collection
    // {
    //     return $this->trainingList;
    // }

    // public function addTrainingList(TrainingList $trainingList): static
    // {
    //     if (!$this->trainingList->contains($trainingList)) {
    //         $this->trainingList->add($trainingList);
    //         $trainingList->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeTrainingList(TrainingList $trainingList): static
    // {
    //     if ($this->trainingList->removeElement($trainingList)) {
    //         // set the owning side to null (unless already changed)
    //         if ($trainingList->getUser() === $this) {
    //             $trainingList->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Trainer>
     */
    public function getTrainer(): Collection
    {
        return $this->trainer;
    }

    public function addTrainer(Trainer $trainer): static
    {
        if (!$this->trainer->contains($trainer)) {
            $this->trainer->add($trainer);
            $trainer->setUser($this);
        }

        return $this;
    }

    public function removeTrainer(Trainer $trainer): static
    {
        if ($this->trainer->removeElement($trainer)) {
            // set the owning side to null (unless already changed)
            if ($trainer->getUser() === $this) {
                $trainer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Award>
     */
    public function getAward(): Collection
    {
        return $this->award;
    }

    public function addAward(Award $award): static
    {
        if (!$this->award->contains($award)) {
            $this->award->add($award);
            $award->setUser($this);
        }

        return $this;
    }

    public function removeAward(Award $award): static
    {
        if ($this->award->removeElement($award)) {
            // set the owning side to null (unless already changed)
            if ($award->getUser() === $this) {
                $award->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfer(): Collection
    {
        return $this->transfer;
    }

    public function addTransfer(Transfer $transfer): static
    {
        if (!$this->transfer->contains($transfer)) {
            $this->transfer->add($transfer);
            $transfer->setUser($this);
        }

        return $this;
    }

    public function removeTransfer(Transfer $transfer): static
    {
        if ($this->transfer->removeElement($transfer)) {
            // set the owning side to null (unless already changed)
            if ($transfer->getUser() === $this) {
                $transfer->setUser(null);
            }
        }

        return $this;
    }
}
