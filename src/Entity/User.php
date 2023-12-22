<?php

namespace App\Entity;

use App\Entity\Zoom;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Account\UserImage;
use App\Repository\UserRepository;
use App\Entity\Account\UserProfile;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(targetEntity: UserProfile::class, inversedBy: "user", cascade: ["persist", "remove"])]
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
    
    public function __construct()
    {
        $this->profile = new UserProfile();
        $this->profile->setUser($this);
        $this->userImages = new ArrayCollection();
        $this->linkedUsers = new ArrayCollection();
        $this->zoomMeetings = new ArrayCollection();
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
}
