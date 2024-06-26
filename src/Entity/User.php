<?php

namespace App\Entity;

use App\Entity\Zoom;
use App\Entity\SupportSystem;
use App\Entity\HRMSystem\Trip;
use App\Entity\HRMSystem\Award;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Account\UserImage;
use App\Entity\HRMSystem\Meeting;
use App\Entity\HRMSystem\Trainer;
use App\Entity\HRMSystem\Warning;
use App\Entity\CRMSystem\Contract;
use App\Entity\HRMSystem\Holidays;
use App\Entity\HRMSystem\Transfer;
use App\Entity\POSSystem\Purchase;
use App\Repository\UserRepository;
use App\Entity\Account\UserProfile;
use App\Entity\HRMSystem\Promotion;
use App\Entity\POSSystem\WareHouse;
use App\Entity\HRMSystem\Complaints;
use App\Entity\CRMSystem\FormBuilder;
use App\Entity\HRMSystem\Resignation;
use App\Entity\HRMSystem\Termination;
use App\Entity\HRMSystem\Announcement;
use App\Entity\AccountingSystem\Customer;
use App\Entity\HRMSystem\CustomQuestions;
use Doctrine\Common\Collections\Collection;
use App\Entity\HRMSystem\EmployeesAssetSetup;
use App\Entity\HRMSystem\EmployeeSetupCreate;
use App\Entity\AccountingSystem\FinancialGoal;
use App\Entity\ProductsSystem\ProductServices;
use App\Entity\AccountingSystem\Income\Revenue;
use App\Entity\HRMSystem\HRM_System_Setup\Goal;
use App\Entity\HRMSystem\HRM_System_Setup\Loan;
use App\Entity\HRMSystem\Performance\Indicator;
use App\Entity\AccountingSystem\Banking\Account;
use App\Entity\AccountingSystem\Expense\Payment;
use App\Entity\HRMSystem\CompanyPolicy;
use App\Entity\HRMSystem\DocumentSetup;
use App\Entity\HRMSystem\Performance\Appraisals;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\HRMSystem\HRM_System_Setup\Branch;
use App\Entity\HRMSystem\HRM_System_Setup\Payslip;
use App\Entity\HRMSystem\HRM_System_Setup\AwardHRM;
use App\Entity\HRMSystem\HRM_System_Setup\Document;
use App\Entity\HRMSystem\HRM_System_Setup\JobStage;
use App\Entity\HRMSystem\HRM_System_Setup\Training;
use App\Entity\HRMSystem\Performance\GoalTrackings;
use App\Entity\WorkFlowSystem\Sales\CustomerCreate;
use App\Entity\HRMSystem\HRM_System_Setup\Allowance;
use App\Entity\HRMSystem\HRM_System_Setup\Deduction;
use App\Entity\WorkFlowSystem\Sales\EnquiryCreation;
use App\Entity\HRMSystem\HRM_System_Setup\Department;
use App\Entity\HRMSystem\HRM_System_Setup\Designation;
use App\Entity\HRMSystem\HRM_System_Setup\JobCategory;
use App\Entity\HRMSystem\HRM_System_Setup\LeaveModule;
use App\Entity\HRMSystem\HRM_System_Setup\Performance;
use App\Entity\HRMSystem\HRM_System_Setup\Competencies;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\HRMSystem\HRM_System_Setup\TerminationHRM;
use App\Entity\HRMSystem\LeaveManagementSetup\Attendance\BulkAttendance;
use App\Entity\HRMSystem\LeaveManagementSetup\ManageLeave;
use App\Entity\HRMSystem\PayrollSetup\PaySlip as PayrollSetupPaySlip;
use App\Entity\HRMSystem\PayrollSetup\Salary;
use App\Entity\HRMSystem\PayrollSetup\PaySlips;
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

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

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

    #[ORM\OneToMany(targetEntity: GoalTrackings::class, mappedBy: "user")]
    private Collection $goalTrackings;

    #[ORM\OneToMany(targetEntity: Appraisals::class, mappedBy: "user")]
    private Collection $appraisal;

    #[ORM\OneToMany(targetEntity: Indicator::class, mappedBy: "user")]
    private Collection $indicator;

    // #[ORM\OneToMany(targetEntity: TrainingList::class, mappedBy: "user")]
    // private Collection $trainingList;

    #[ORM\OneToMany(targetEntity: Trainer::class, mappedBy: "user")]
    private Collection $trainer;

    #[ORM\OneToMany(targetEntity: Award::class, mappedBy: "user")]
    private Collection $award;

    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: "user")]
    private Collection $transfer;

    #[ORM\OneToMany(targetEntity: Promotion::class, mappedBy: "user")]
    private Collection $promotion;

    #[ORM\OneToMany(targetEntity: Termination::class, mappedBy: "user")]
    private Collection $termination;

    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: "user")]
    private Collection $announcement;

    #[ORM\OneToMany(targetEntity: Meeting::class, mappedBy: "user")]
    private Collection $meeting;

    #[ORM\OneToMany(targetEntity: Branch::class, mappedBy: "user")]
    private Collection $branch;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: "user")]
    private Collection $department;

    #[ORM\OneToMany(targetEntity: Designation::class, mappedBy: "user")]
    private Collection $designation;

    #[ORM\OneToMany(targetEntity: LeaveModule::class, mappedBy: "user")]
    private Collection $leaveModule;

    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: "user")]
    private Collection $document;

    #[ORM\OneToMany(targetEntity: Payslip::class, mappedBy: "user")]
    private Collection $payslip;

    #[ORM\OneToMany(targetEntity: Allowance::class, mappedBy: "user")]
    private Collection $allowance;

    #[ORM\OneToMany(targetEntity: Loan::class, mappedBy: "user")]
    private Collection $loan;

    #[ORM\OneToMany(targetEntity: Deduction::class, mappedBy: "user")]
    private Collection $deduction;

    #[ORM\OneToMany(targetEntity: Goal::class, mappedBy: "user")]
    private Collection $goal;

    #[ORM\OneToMany(targetEntity: Training::class, mappedBy: "user")]
    private Collection $training;

    #[ORM\OneToMany(targetEntity: AwardHRM::class, mappedBy: "user")]
    private Collection $awardHRM;

    #[ORM\OneToMany(targetEntity: TerminationHRM::class, mappedBy: "user")]
    private Collection $terminationHRM;

    #[ORM\OneToMany(targetEntity: JobCategory::class, mappedBy: "user")]
    private Collection $jobCategory;

    #[ORM\OneToMany(targetEntity: JobStage::class, mappedBy: "user")]
    private Collection $jobStage;

    #[ORM\OneToMany(targetEntity: Performance::class, mappedBy: "user")]
    private Collection $performance;

    #[ORM\OneToMany(targetEntity: Competencies::class, mappedBy: "user")]
    private Collection $competencies;

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: "user")]
    private Collection $purchase;

    #[ORM\OneToMany(targetEntity: WareHouse::class, mappedBy: "user")]
    private Collection $wareHouse;

    #[ORM\OneToMany(targetEntity: Account::class, mappedBy: "user")]
    private Collection $account;

    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: "user")]
    private Collection $transfers;

    #[ORM\OneToMany(targetEntity: Revenue::class, mappedBy: "user")]
    private Collection $revenue;

    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: "user")]
    private Collection $payment;

    #[ORM\OneToMany(targetEntity: Customer::class, mappedBy: "user")]
    private Collection $customer;

    #[ORM\OneToMany(targetEntity: FinancialGoal::class, mappedBy: "user")]
    private Collection $financialGoal;

    #[ORM\OneToMany(targetEntity: Contract::class, mappedBy: "user")]
    private Collection $contract;

    #[ORM\OneToMany(targetEntity: FormBuilder::class, mappedBy: "user")]
    private Collection $formBuilder;

    #[ORM\OneToMany(targetEntity: ProductServices::class, mappedBy: "user")]
    private Collection $productServices;

    #[ORM\OneToMany(targetEntity: CustomerCreate::class, mappedBy: "user")]
    private Collection $customerCreate;

    #[ORM\OneToMany(targetEntity: EnquiryCreation::class, mappedBy: "user")]
    private Collection $enquiryCreation;

    #[ORM\OneToMany(targetEntity: EmployeeSetupCreate::class, mappedBy: "user")]
    private Collection $employeeSetupCreate;

    #[ORM\OneToMany(targetEntity: Salary::class, mappedBy: "user")]
    private Collection $setSalary;

    #[ORM\OneToMany(targetEntity: PaySlips::class, mappedBy: "user")]
    private Collection $payslips;

    #[ORM\OneToMany(targetEntity: BulkAttendance::class, mappedBy: "user")]
    private Collection $bulkAttendance;

    #[ORM\OneToMany(targetEntity: DocumentSetup::class, mappedBy: "user")]
    private Collection $documentSetup;

    #[ORM\OneToMany(targetEntity: CompanyPolicy::class, mappedBy: "user")]
    private Collection $companyPolicy;




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
        // $this->trainingList = new ArrayCollection();
        $this->trainer = new ArrayCollection();
        $this->award = new ArrayCollection();
        $this->transfer = new ArrayCollection();
        $this->promotion = new ArrayCollection();
        $this->termination = new ArrayCollection();
        $this->announcement = new ArrayCollection();
        $this->meeting = new ArrayCollection();
        $this->branch = new ArrayCollection();
        $this->department = new ArrayCollection();
        $this->designation = new ArrayCollection();
        $this->leaveModule = new ArrayCollection();
        $this->document = new ArrayCollection();
        $this->payslip = new ArrayCollection();
        $this->allowance = new ArrayCollection();
        $this->loan = new ArrayCollection();
        $this->deduction = new ArrayCollection();
        $this->goal = new ArrayCollection();
        $this->training = new ArrayCollection();
        $this->awardHRM = new ArrayCollection();
        $this->terminationHRM = new ArrayCollection();
        $this->jobCategory = new ArrayCollection();
        $this->jobStage = new ArrayCollection();
        $this->performance = new ArrayCollection();
        $this->competencies = new ArrayCollection();
        $this->purchase = new ArrayCollection();
        $this->wareHouse = new ArrayCollection();
        $this->appraisal = new ArrayCollection();
        $this->indicator = new ArrayCollection();
        $this->goalTrackings = new ArrayCollection();
        $this->account = new ArrayCollection();
        $this->transfers = new ArrayCollection();
        $this->payment = new ArrayCollection();
        $this->revenue = new ArrayCollection();
        $this->customer = new ArrayCollection();
        $this->financialGoal = new ArrayCollection();
        $this->contract = new ArrayCollection();
        $this->formBuilder = new ArrayCollection();
        $this->productServices = new ArrayCollection();
        $this->customerCreate = new ArrayCollection();
        $this->enquiryCreation = new ArrayCollection();
        $this->employeeSetupCreate = new ArrayCollection();
        $this->setSalary = new ArrayCollection();
        $this->payslips = new ArrayCollection();
        $this->bulkAttendance = new ArrayCollection();
        $this->documentSetup = new ArrayCollection();
        $this->companyPolicy = new ArrayCollection();
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

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotion $promotion): static
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion->add($promotion);
            $promotion->setUser($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): static
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getUser() === $this) {
                $promotion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Termination>
     */
    public function getTermination(): Collection
    {
        return $this->termination;
    }

    public function addTermination(Termination $termination): static
    {
        if (!$this->termination->contains($termination)) {
            $this->termination->add($termination);
            $termination->setUser($this);
        }

        return $this;
    }

    public function removeTermination(Termination $termination): static
    {
        if ($this->termination->removeElement($termination)) {
            // set the owning side to null (unless already changed)
            if ($termination->getUser() === $this) {
                $termination->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncement(): Collection
    {
        return $this->announcement;
    }

    public function addAnnouncement(Announcement $announcement): static
    {
        if (!$this->announcement->contains($announcement)) {
            $this->announcement->add($announcement);
            $announcement->setUser($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): static
    {
        if ($this->announcement->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getUser() === $this) {
                $announcement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeeting(): Collection
    {
        return $this->meeting;
    }

    public function addMeeting(Meeting $meeting): static
    {
        if (!$this->meeting->contains($meeting)) {
            $this->meeting->add($meeting);
            $meeting->setUser($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): static
    {
        if ($this->meeting->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getUser() === $this) {
                $meeting->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Branch>
     */
    public function getBranch(): Collection
    {
        return $this->branch;
    }

    public function addBranch(Branch $branch): static
    {
        if (!$this->branch->contains($branch)) {
            $this->branch->add($branch);
            $branch->setUser($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): static
    {
        if ($this->branch->removeElement($branch)) {
            // set the owning side to null (unless already changed)
            if ($branch->getUser() === $this) {
                $branch->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartment(): Collection
    {
        return $this->department;
    }

    public function addDepartment(Department $department): static
    {
        if (!$this->department->contains($department)) {
            $this->department->add($department);
            $department->setUser($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): static
    {
        if ($this->department->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getUser() === $this) {
                $department->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Designation>
     */
    public function getDesignation(): Collection
    {
        return $this->designation;
    }

    public function addDesignation(Designation $designation): static
    {
        if (!$this->designation->contains($designation)) {
            $this->designation->add($designation);
            $designation->setUser($this);
        }

        return $this;
    }

    public function removeDesignation(Designation $designation): static
    {
        if ($this->designation->removeElement($designation)) {
            // set the owning side to null (unless already changed)
            if ($designation->getUser() === $this) {
                $designation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->document->contains($document)) {
            $this->document->add($document);
            $document->setUser($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->document->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getUser() === $this) {
                $document->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payslip>
     */
    public function getPayslip(): Collection
    {
        return $this->payslip;
    }

    public function addPayslip(Payslip $payslip): static
    {
        if (!$this->payslip->contains($payslip)) {
            $this->payslip->add($payslip);
            $payslip->setUser($this);
        }

        return $this;
    }

    public function removePayslip(Payslip $payslip): static
    {
        if ($this->payslip->removeElement($payslip)) {
            // set the owning side to null (unless already changed)
            if ($payslip->getUser() === $this) {
                $payslip->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Allowance>
     */
    public function getAllowance(): Collection
    {
        return $this->allowance;
    }

    public function addAllowance(Allowance $allowance): static
    {
        if (!$this->allowance->contains($allowance)) {
            $this->allowance->add($allowance);
            $allowance->setUser($this);
        }

        return $this;
    }

    public function removeAllowance(Allowance $allowance): static
    {
        if ($this->allowance->removeElement($allowance)) {
            // set the owning side to null (unless already changed)
            if ($allowance->getUser() === $this) {
                $allowance->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Loan>
     */
    public function getLoan(): Collection
    {
        return $this->loan;
    }

    public function addLoan(Loan $loan): static
    {
        if (!$this->loan->contains($loan)) {
            $this->loan->add($loan);
            $loan->setUser($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): static
    {
        if ($this->loan->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getUser() === $this) {
                $loan->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Deduction>
     */
    public function getDeduction(): Collection
    {
        return $this->deduction;
    }

    public function addDeduction(Deduction $deduction): static
    {
        if (!$this->deduction->contains($deduction)) {
            $this->deduction->add($deduction);
            $deduction->setUser($this);
        }

        return $this;
    }

    public function removeDeduction(Deduction $deduction): static
    {
        if ($this->deduction->removeElement($deduction)) {
            // set the owning side to null (unless already changed)
            if ($deduction->getUser() === $this) {
                $deduction->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getGoal(): Collection
    {
        return $this->goal;
    }

    public function addGoal(Goal $goal): static
    {
        if (!$this->goal->contains($goal)) {
            $this->goal->add($goal);
            $goal->setUser($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): static
    {
        if ($this->goal->removeElement($goal)) {
            // set the owning side to null (unless already changed)
            if ($goal->getUser() === $this) {
                $goal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTraining(): Collection
    {
        return $this->training;
    }

    public function addTraining(Training $training): static
    {
        if (!$this->training->contains($training)) {
            $this->training->add($training);
            $training->setUser($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): static
    {
        if ($this->training->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getUser() === $this) {
                $training->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AwardHRM>
     */
    public function getAwardHRM(): Collection
    {
        return $this->awardHRM;
    }

    public function addAwardHRM(AwardHRM $awardHRM): static
    {
        if (!$this->awardHRM->contains($awardHRM)) {
            $this->awardHRM->add($awardHRM);
            $awardHRM->setUser($this);
        }

        return $this;
    }

    public function removeAwardHRM(AwardHRM $awardHRM): static
    {
        if ($this->awardHRM->removeElement($awardHRM)) {
            // set the owning side to null (unless already changed)
            if ($awardHRM->getUser() === $this) {
                $awardHRM->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TerminationHRM>
     */
    public function getTerminationHRM(): Collection
    {
        return $this->terminationHRM;
    }

    public function addTerminationHRM(TerminationHRM $terminationHRM): static
    {
        if (!$this->terminationHRM->contains($terminationHRM)) {
            $this->terminationHRM->add($terminationHRM);
            $terminationHRM->setUser($this);
        }

        return $this;
    }

    public function removeTerminationHRM(TerminationHRM $terminationHRM): static
    {
        if ($this->terminationHRM->removeElement($terminationHRM)) {
            // set the owning side to null (unless already changed)
            if ($terminationHRM->getUser() === $this) {
                $terminationHRM->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobCategory>
     */
    public function getJobCategory(): Collection
    {
        return $this->jobCategory;
    }

    public function addJobCategory(JobCategory $jobCategory): static
    {
        if (!$this->jobCategory->contains($jobCategory)) {
            $this->jobCategory->add($jobCategory);
            $jobCategory->setUser($this);
        }

        return $this;
    }

    public function removeJobCategory(JobCategory $jobCategory): static
    {
        if ($this->jobCategory->removeElement($jobCategory)) {
            // set the owning side to null (unless already changed)
            if ($jobCategory->getUser() === $this) {
                $jobCategory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobStage>
     */
    public function getJobStage(): Collection
    {
        return $this->jobStage;
    }

    public function addJobStage(JobStage $jobStage): static
    {
        if (!$this->jobStage->contains($jobStage)) {
            $this->jobStage->add($jobStage);
            $jobStage->setUser($this);
        }

        return $this;
    }

    public function removeJobStage(JobStage $jobStage): static
    {
        if ($this->jobStage->removeElement($jobStage)) {
            // set the owning side to null (unless already changed)
            if ($jobStage->getUser() === $this) {
                $jobStage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Performance>
     */
    public function getPerformance(): Collection
    {
        return $this->performance;
    }

    public function addPerformance(Performance $performance): static
    {
        if (!$this->performance->contains($performance)) {
            $this->performance->add($performance);
            $performance->setUser($this);
        }

        return $this;
    }

    public function removePerformance(Performance $performance): static
    {
        if ($this->performance->removeElement($performance)) {
            // set the owning side to null (unless already changed)
            if ($performance->getUser() === $this) {
                $performance->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Competencies>
     */
    public function getCompetencies(): Collection
    {
        return $this->competencies;
    }

    public function addCompetency(Competencies $competency): static
    {
        if (!$this->competencies->contains($competency)) {
            $this->competencies->add($competency);
            $competency->setUser($this);
        }

        return $this;
    }

    public function removeCompetency(Competencies $competency): static
    {
        if ($this->competencies->removeElement($competency)) {
            // set the owning side to null (unless already changed)
            if ($competency->getUser() === $this) {
                $competency->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LeaveModule>
     */
    public function getLeaveModule(): Collection
    {
        return $this->leaveModule;
    }

    public function addLeaveModule(LeaveModule $leaveModule): static
    {
        if (!$this->leaveModule->contains($leaveModule)) {
            $this->leaveModule->add($leaveModule);
            $leaveModule->setUser($this);
        }

        return $this;
    }

    public function removeLeaveModule(LeaveModule $leaveModule): static
    {
        if ($this->leaveModule->removeElement($leaveModule)) {
            // set the owning side to null (unless already changed)
            if ($leaveModule->getUser() === $this) {
                $leaveModule->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchase(): Collection
    {
        return $this->purchase;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->purchase->contains($purchase)) {
            $this->purchase->add($purchase);
            $purchase->setUser($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->purchase->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getUser() === $this) {
                $purchase->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getWareHouse(): Collection
    {
        return $this->wareHouse;
    }

    public function addWareHouse(WareHouse $wareHouse): static
    {
        if (!$this->wareHouse->contains($wareHouse)) {
            $this->wareHouse->add($wareHouse);
            $wareHouse->setUser($this);
        }

        return $this;
    }

    public function removeWareHouse(WareHouse $wareHouse): static
    {
        if ($this->$wareHouse->removeElement($wareHouse)) {
            // set the owning side to null (unless already changed)
            if ($wareHouse->getUser() === $this) {
                $wareHouse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Appraisals>
     */
    public function getAppraisal(): Collection
    {
        return $this->appraisal;
    }

    public function addAppraisal(Appraisals $appraisal): static
    {
        if (!$this->appraisal->contains($appraisal)) {
            $this->appraisal->add($appraisal);
            $appraisal->setUser($this);
        }

        return $this;
    }

    public function removeAppraisal(Appraisals $appraisal): static
    {
        if ($this->appraisal->removeElement($appraisal)) {
            // set the owning side to null (unless already changed)
            if ($appraisal->getUser() === $this) {
                $appraisal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Indicator>
     */
    public function getIndicator(): Collection
    {
        return $this->indicator;
    }

    public function addIndicator(Indicator $indicator): static
    {
        if (!$this->indicator->contains($indicator)) {
            $this->indicator->add($indicator);
            $indicator->setUser($this);
        }

        return $this;
    }

    public function removeIndicator(Indicator $indicator): static
    {
        if ($this->indicator->removeElement($indicator)) {
            // set the owning side to null (unless already changed)
            if ($indicator->getUser() === $this) {
                $indicator->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GoalTrackings>
     */
    public function getGoalTrackings(): Collection
    {
        return $this->goalTrackings;
    }

    public function addGoalTracking(GoalTrackings $goalTracking): static
    {
        if (!$this->goalTrackings->contains($goalTracking)) {
            $this->goalTrackings->add($goalTracking);
            $goalTracking->setUser($this);
        }

        return $this;
    }

    public function removeGoalTracking(GoalTrackings $goalTracking): static
    {
        if ($this->goalTrackings->removeElement($goalTracking)) {
            // set the owning side to null (unless already changed)
            if ($goalTracking->getUser() === $this) {
                $goalTracking->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccount(): Collection
    {
        return $this->account;
    }

    public function addAccount(Account $account): static
    {
        if (!$this->account->contains($account)) {
            $this->account->add($account);
            $account->setUser($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): static
    {
        if ($this->account->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfers(): Collection
    {
        return $this->transfers;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayment(): Collection
    {
        return $this->payment;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payment->contains($payment)) {
            $this->payment->add($payment);
            $payment->setUser($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payment->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getUser() === $this) {
                $payment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Revenue>
     */
    public function getRevenue(): Collection
    {
        return $this->revenue;
    }

    public function addRevenue(Revenue $revenue): static
    {
        if (!$this->revenue->contains($revenue)) {
            $this->revenue->add($revenue);
            $revenue->setUser($this);
        }

        return $this;
    }

    public function removeRevenue(Revenue $revenue): static
    {
        if ($this->revenue->removeElement($revenue)) {
            // set the owning side to null (unless already changed)
            if ($revenue->getUser() === $this) {
                $revenue->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customer->contains($customer)) {
            $this->customer->add($customer);
            $customer->setUser($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customer->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getUser() === $this) {
                $customer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FinancialGoal>
     */
    public function getFinancialGoal(): Collection
    {
        return $this->financialGoal;
    }

    public function addFinancialGoal(FinancialGoal $financialGoal): static
    {
        if (!$this->financialGoal->contains($financialGoal)) {
            $this->financialGoal->add($financialGoal);
            $financialGoal->setUser($this);
        }

        return $this;
    }

    public function removeFinancialGoal(FinancialGoal $financialGoal): static
    {
        if ($this->financialGoal->removeElement($financialGoal)) {
            // set the owning side to null (unless already changed)
            if ($financialGoal->getUser() === $this) {
                $financialGoal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContract(): Collection
    {
        return $this->contract;
    }

    public function addContract(Contract $contract): static
    {
        if (!$this->contract->contains($contract)) {
            $this->contract->add($contract);
            $contract->setUser($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contract->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getUser() === $this) {
                $contract->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormBuilder>
     */
    public function getFormBuilder(): Collection
    {
        return $this->formBuilder;
    }

    public function addFormBuilder(FormBuilder $formBuilder): static
    {
        if (!$this->formBuilder->contains($formBuilder)) {
            $this->formBuilder->add($formBuilder);
            $formBuilder->setUser($this);
        }

        return $this;
    }

    public function removeFormBuilder(FormBuilder $formBuilder): static
    {
        if ($this->formBuilder->removeElement($formBuilder)) {
            // set the owning side to null (unless already changed)
            if ($formBuilder->getUser() === $this) {
                $formBuilder->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductServices>
     */
    public function getProductServices(): Collection
    {
        return $this->productServices;
    }

    public function addProductService(ProductServices $productService): static
    {
        if (!$this->productServices->contains($productService)) {
            $this->productServices->add($productService);
            $productService->setUser($this);
        }

        return $this;
    }

    public function removeProductService(ProductServices $productService): static
    {
        if ($this->productServices->removeElement($productService)) {
            // set the owning side to null (unless already changed)
            if ($productService->getUser() === $this) {
                $productService->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomerCreate>
     */
    public function getCustomerCreate(): Collection
    {
        return $this->customerCreate;
    }

    public function addCustomerCreate(CustomerCreate $customerCreate): static
    {
        if (!$this->customerCreate->contains($customerCreate)) {
            $this->customerCreate->add($customerCreate);
            $customerCreate->setUser($this);
        }

        return $this;
    }

    public function removeCustomerCreate(CustomerCreate $customerCreate): static
    {
        if ($this->customerCreate->removeElement($customerCreate)) {
            // set the owning side to null (unless already changed)
            if ($customerCreate->getUser() === $this) {
                $customerCreate->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EnquiryCreation>
     */
    public function getEnquiryCreation(): Collection
    {
        return $this->enquiryCreation;
    }

    public function addEnquiryCreation(EnquiryCreation $enquiryCreation): static
    {
        if (!$this->enquiryCreation->contains($enquiryCreation)) {
            $this->enquiryCreation->add($enquiryCreation);
            $enquiryCreation->setUser($this);
        }

        return $this;
    }

    public function removeEnquiryCreation(EnquiryCreation $enquiryCreation): static
    {
        if ($this->enquiryCreation->removeElement($enquiryCreation)) {
            // set the owning side to null (unless already changed)
            if ($enquiryCreation->getUser() === $this) {
                $enquiryCreation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeSetupCreate>
     */
    public function getEmployeeSetupCreate(): Collection
    {
        return $this->employeeSetupCreate;
    }

    public function addEmployeeSetupCreate(EmployeeSetupCreate $employeeSetupCreate): static
    {
        if (!$this->employeeSetupCreate->contains($employeeSetupCreate)) {
            $this->employeeSetupCreate->add($employeeSetupCreate);
            $employeeSetupCreate->setUser($this);
        }

        return $this;
    }

    public function removeEmployeeSetupCreate(EmployeeSetupCreate $employeeSetupCreate): static
    {
        if ($this->employeeSetupCreate->removeElement($employeeSetupCreate)) {
            // set the owning side to null (unless already changed)
            if ($employeeSetupCreate->getUser() === $this) {
                $employeeSetupCreate->setUser(null);
            }
        }

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return Collection<int, Salary>
     */
    public function getSetSalary(): Collection
    {
        return $this->setSalary;
    }

    public function addSetSalary(Salary $setSalary): static
    {
        if (!$this->setSalary->contains($setSalary)) {
            $this->setSalary->add($setSalary);
            $setSalary->setUser($this);
        }

        return $this;
    }

    public function removeSetSalary(Salary $setSalary): static
    {
        if ($this->setSalary->removeElement($setSalary)) {
            // set the owning side to null (unless already changed)
            if ($setSalary->getUser() === $this) {
                $setSalary->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaySlips>
     */
    public function getPayslips(): Collection
    {
        return $this->payslips;
    }

    /**
     * @return Collection<int, BulkAttendance>
     */
    public function getBulkAttendance(): Collection
    {
        return $this->bulkAttendance;
    }

    public function addBulkAttendance(BulkAttendance $bulkAttendance): static
    {
        if (!$this->bulkAttendance->contains($bulkAttendance)) {
            $this->bulkAttendance->add($bulkAttendance);
            $bulkAttendance->setUser($this);
        }

        return $this;
    }

    public function removeBulkAttendance(BulkAttendance $bulkAttendance): static
    {
        if ($this->bulkAttendance->removeElement($bulkAttendance)) {
            // set the owning side to null (unless already changed)
            if ($bulkAttendance->getUser() === $this) {
                $bulkAttendance->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DocumentSetup>
     */
    public function getDocumentSetup(): Collection
    {
        return $this->documentSetup;
    }

    public function addDocumentSetup(DocumentSetup $documentSetup): static
    {
        if (!$this->documentSetup->contains($documentSetup)) {
            $this->documentSetup->add($documentSetup);
            $documentSetup->setUser($this);
        }

        return $this;
    }

    public function removeDocumentSetup(DocumentSetup $documentSetup): static
    {
        if ($this->documentSetup->removeElement($documentSetup)) {
            // set the owning side to null (unless already changed)
            if ($documentSetup->getUser() === $this) {
                $documentSetup->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyPolicy>
     */
    public function getCompanyPolicy(): Collection
    {
        return $this->companyPolicy;
    }

    public function addCompanyPolicy(CompanyPolicy $companyPolicy): static
    {
        if (!$this->companyPolicy->contains($companyPolicy)) {
            $this->companyPolicy->add($companyPolicy);
            $companyPolicy->setUser($this);
        }

        return $this;
    }

    public function removeCompanyPolicy(CompanyPolicy $companyPolicy): static
    {
        if ($this->companyPolicy->removeElement($companyPolicy)) {
            // set the owning side to null (unless already changed)
            if ($companyPolicy->getUser() === $this) {
                $companyPolicy->setUser(null);
            }
        }

        return $this;
    }
}
