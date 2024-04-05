<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\HRMSystem\Trip;
use App\Entity\HRMSystem\Award;
use App\Form\HRMSystem\TripType;
use App\Entity\HRMSystem\Meeting;
use App\Entity\HRMSystem\Trainer;
use App\Entity\HRMSystem\Warning;
use App\Form\HRMSystem\AwardType;
use App\Entity\HRMSystem\Holidays;
use App\Entity\HRMSystem\Transfer;
use App\Entity\HRMSystem\Promotion;
use App\Form\HRMSystem\MeetingType;
use App\Form\HRMSystem\TrainerType;
use App\Form\HRMSystem\WarningType;
use App\Entity\HRMSystem\Complaints;
use App\Form\HRMSystem\HolidaysType;
use App\Form\HRMSystem\TransferType;
use App\Entity\HRMSystem\Resignation;
use App\Entity\HRMSystem\Termination;
use App\Form\HRMSystem\PromotionType;
use App\Entity\HRMSystem\Announcement;
use App\Form\HRMSystem\ComplaintsType;
use App\Form\HRMSystem\ResignationType;
use App\Form\HRMSystem\TerminationType;
use App\Form\HRMSystem\AnnouncementType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\HRMSystem\CustomQuestions;
use App\Form\HRMSystem\CustomQuestionsType;
use App\Entity\HRMSystem\EmployeesAssetSetup;
use App\Entity\HRMSystem\EmployeeSetupCreate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\HRMSystem\HRM_System_Setup\Goal;
use App\Entity\HRMSystem\HRM_System_Setup\Loan;
use App\Entity\HRMSystem\Performance\Indicator;
use App\Form\HRMSystem\EmployeesAssetSetupType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HRMSystem\HRM_System_Setup\Leave;
use App\Entity\HRMSystem\Performance\Appraisals;
use App\Form\HRMSystem\EmployeeSetupCreateType;
use App\Entity\HRMSystem\HRM_System_Setup\Branch;
use App\Form\HRMSystem\HRM_System_Setup\GoalType;
use App\Form\HRMSystem\HRM_System_Setup\LoanType;
use App\Form\HRMSystem\Performance\AppraisalType;
use App\Form\HRMSystem\Performance\IndicatorType;
use App\Entity\HRMSystem\HRM_System_Setup\Payslip;
use App\Form\HRMSystem\HRM_System_Setup\LeaveType;
use App\Entity\HRMSystem\HRM_System_Setup\AwardHRM;
use App\Entity\HRMSystem\HRM_System_Setup\Document;
use App\Entity\HRMSystem\HRM_System_Setup\JobStage;
use App\Entity\HRMSystem\HRM_System_Setup\Training;
use App\Entity\HRMSystem\Performance\GoalTrackings;
use App\Form\HRMSystem\HRM_System_Setup\BranchType;
use App\Entity\HRMSystem\HRM_System_Setup\Allowance;
use App\Entity\HRMSystem\HRM_System_Setup\Deduction;
use App\Form\HRMSystem\HRM_System_Setup\PayslipType;
use App\Form\HRMSystem\Performance\GoalTrackingType;
use App\Entity\HRMSystem\HRM_System_Setup\Department;
use App\Form\HRMSystem\HRM_System_Setup\AwardHRMType;
use App\Form\HRMSystem\HRM_System_Setup\DocumentType;
use App\Form\HRMSystem\HRM_System_Setup\JobStageType;
use App\Form\HRMSystem\HRM_System_Setup\TrainingType;
use App\Entity\HRMSystem\HRM_System_Setup\Designation;
use App\Entity\HRMSystem\HRM_System_Setup\JobCategory;
use App\Entity\HRMSystem\HRM_System_Setup\LeaveModule;
use App\Entity\HRMSystem\HRM_System_Setup\Performance;
use App\Form\HRMSystem\HRM_System_Setup\AllowanceType;
use App\Form\HRMSystem\HRM_System_Setup\DeductionType;
use App\Entity\HRMSystem\HRM_System_Setup\Competencies;
use App\Form\HRMSystem\HRM_System_Setup\DepartmentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\HRMSystem\HRM_System_Setup\DesignationType;
use App\Form\HRMSystem\HRM_System_Setup\JobCategoryType;
use App\Form\HRMSystem\HRM_System_Setup\PerformanceType;
use App\Entity\HRMSystem\HRM_System_Setup\TerminationHRM;
use App\Form\HRMSystem\HRM_System_Setup\CompetenciesType;
use App\Entity\HRMSystem\LeaveManagementSetup\ManageLeave;
use App\Form\HRMSystem\HRM_System_Setup\TerminationHRMType;
use App\Form\HRMSystem\LeaveManagementSetup\ManageLeaveType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HrmsystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/hrmsystem/employee_setup/{id}', name: 'hrmsystem/employee_setup')]
    public function employeeSetup(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $employeeSetupCreate = new EmployeeSetupCreate();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $employeeSetupCreate->setUser($user);

        $repository = $this->entityManager->getRepository(EmployeeSetupCreate::class);
        $employeeSetupCreates = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/employeeSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
            'employeeSetupCreates' => $employeeSetupCreates,
        ]);
    }


    #[Route('/hrmsystem/employee_setup/create/{id}', name: 'hrmsystem/employee_setup/create')]
    public function employeeSetupCreate(Request $request, int $id, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $employeeSetupCreate = new EmployeeSetupCreate();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $employeeSetupCreate->setUser($user);
        $form = $this->createForm(EmployeeSetupCreateType::class, $employeeSetupCreate, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUserEmployee = new User();
            // $user->getCompanyName();
            // $newUserEmployee = $form->getData();
            $newUserEmployee->setCompanyName($user->getCompanyName());
            $newUserEmployee->setParentUser($user);
            $hashedPassword = $userPasswordHasher->hashPassword($newUserEmployee, $employeeSetupCreate->getPassword());
            $newUserEmployee->setPassword($hashedPassword);
            $newUserEmployee->setEmail($employeeSetupCreate->getEmail());
            $newUserEmployee->setFullName($employeeSetupCreate->getName());
            $uploadedFiles = $request->files->get('employees_setup_create');

            foreach (['certificate', 'photo'] as $field) {
                $file = $uploadedFiles[$field] ?? null;

                if ($file instanceof UploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('support_dir'),
                            $fileName
                        );
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'There was an issue with one of the files');
                        return $this->redirectToRoute('employee_setup/create');
                    }
                    // Set the filename in the entity
                    $setter = 'set' . ucfirst($field);
                    $employeeSetupCreate->$setter($fileName);
                }
            }
            $this->entityManager->persist($newUserEmployee);
            $this->entityManager->persist($employeeSetupCreate);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('hrmsystem/employee_setup',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(EmployeeSetupCreate::class);
        $employeeSetupCreates = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/employeeSetupCreate.html.twig', [
            'controller_name' => 'HrmsystemController',
            'employeeSetupCreates' => $employeeSetupCreates,
            'form' => $form->createView(),
        ]);
    }

    //delete employeeSetup create
    #[Route('/hrmsystem/employee_setup/delete/{id}/delete/{user_id}', name: 'employee_setup_delete', methods: ["GET", "POST"])]
    public function employeeSetupDelete(EmployeeSetupCreate $employeeSetupCreate, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$employeeSetupCreate) {
            throw $this->createNotFoundException('employee setup create not found');
        }

        $this->entityManager->remove($employeeSetupCreate);
        $this->entityManager->flush();

        return $this->redirectToRoute('hrmsystem/employee_setup/create', ['id' => $user_id]);
    }

    #[Route("/hrmsystem/employee_setup/{id}/edit/{user_id}", name: "employee_setup_edit", methods: ["GET", "PUT", "POST"])]
    public function employeeSetupEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(EmployeeSetupCreate::class);
        $employeeSetupCreate = $repository->find($id);

        if (!$employeeSetupCreate) {
            throw $this->createNotFoundException('employee setup create not found');
        }

        $form = $this->createForm(EmployeeSetupCreateType::class, $employeeSetupCreate,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $employeeSetupCreate = $form->getData();
                $this->entityManager->persist($employeeSetupCreate);
                $this->entityManager->flush();

                // Redirect after successful form submission
                return $this->redirectToRoute('workflowsystem/customercreation', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(EmployeeSetupCreate::class);
        $employeeSetupCreates = $repository->findBy(['user' => $currentUser]);

        return $this->render('workflowsystem/edit/customerCreation.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'employeeSetupCreates' => $employeeSetupCreates,
        ]);
    }


    #[Route('/hrmsystem/set_salary', name: 'hrmsystem/set_salary')]
    public function setSalary(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/setSalary.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/payslip', name: 'hrmsystem/payslip')]
    public function payslip(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/payslip.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/manage_leave/{id}', name: 'hrmsystem/manage_leave')]
    public function manageLeave(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $manageleave = new ManageLeave();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $manageleave->setUser($user);
        $form = $this->createForm(ManageLeaveType::class, $manageleave);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($manageleave);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/manage_leave', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(ManageLeave::class);
        $manageleaves = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/manageleave.html.twig', [
            'controller_name' => 'HrmsystemController',
            'manageLeaves' => $manageleaves,
            'form' => $form->createView(),
        ]);
    }
    // edit manage_leave
    #[Route("/hrmsystem/manage_leave/{id}/edit/{user_id}", name: "manageleave_edit", methods: ["GET", "PUT", "POST"])]
    public function manage_leaveEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $data = json_decode($request->getContent(), true);

        $repository = $this->entityManager->getRepository(Manageleave::class);

        $manageleave = $repository->find($id);

        if (!$manageleave) {

            throw $this->createNotFoundException('Manageleave not found');
        }
        try {

            empty($data['employee']) ? true : $manageleave->setUser($data['employee']);
            empty($data['leaveReason']) ? true : $manageleave->setLeaveReason($data['leaveReason']);
            empty($data['leaveType']) ? true : $manageleave->setLeaveType($data['leaveType']);
            empty($data['startDate']) ? true : $manageleave->setStartDate(new \DateTime($data['startDate']));
            empty($data['endDate']) ? true : $manageleave->setEndDate(new \DateTime($data['endDate']));
            empty($data['remark']) ? true : $manageleave->setRemark($data['remark']);

            $this->entityManager->persist($manageleave);
            $this->entityManager->flush();

            return $this->redirectToRoute('hrmsystem/manage_leave', ['id' => $user_id]);
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
    }

    // delete manage leave
    #[Route('/hrmsystem/manage_leave/{id}/delete/{user_id}', name: 'manageleave_delete', methods: ["GET", "POST"])]
    public function manageleaveDelete(Manageleave $Manageleave, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($Manageleave);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/manage_leave', ['id' => $user_id]);
    }

    #[Route('/hrmsystem/bulk_attendance', name: 'hrmsystem/bulk_attendance')]
    public function bulkAttendance(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/bulkAttendance.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/mark_attendance', name: 'hrmsystem/mark_attendance')]
    public function markAttendance(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/markAttendance.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }

    #[Route('/hrmsystem/indicator{id}', name: 'hrmsystem/indicator')]
    public function indicator(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $indicator = new Indicator();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $indicator->setUser($user);
        $form = $this->createForm(IndicatorType::class, $indicator, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($indicator);
            $this->entityManager->flush();

            $this->addFlash('success', 'indicator created successfully.');

            // Redirect after successful form submission
            return $this->redirectToRoute('hrmsystem/indicator',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(indicator::class);
        $indicators = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/indicator.html.twig', [
            'controller_name' => 'HrmsystemController',
            'indicators' => $indicators,
            'form' => $form->createView(),
        ]);
    }
    //delete indicator
    #[Route('/hrmsystem/indicator/{id}/delete/{user_id}', name: 'indicator_delete', methods: ["GET", "POST"])]
    public function indicatorDelete(indicator $indicatior, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$indicatior) {
            throw $this->createNotFoundException('indicator not found');
        }

        $this->entityManager->remove($indicatior);
        $this->entityManager->flush();

        return $this->redirectToRoute('hrmsystem/indicator', ['id' => $user_id]);
    }

    // edit indicator
    #[Route("/hrmsystem/indicator/{id}/edit/{user_id}", name: "indicator_edit", methods: ["GET", "PUT", "POST"])]
    public function indicatorEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $data = json_decode($request->getContent(), true);

        $repository = $this->entityManager->getRepository(Indicator::class);

        $indicator = $repository->find($id);

        if (!$indicator) {
            throw $this->createNotFoundException('indicator not found');
        }
        try {

            empty($data['branch']) ? true : $indicator->setBranch($data['branch']);
            empty($data['department']) ? true : $indicator->setDepartment($data['department']);
            empty($data['designation']) ? true : $indicator->setDesignation($data['designation']);
            empty($data['overallRating']) ? true : $indicator->setOverallRating(($data['OverallRating']));
            empty($data['addedBy']) ? true : $indicator->setAddedBy(($data['AddedBy']));
            empty($data['createdBy']) ? true : $indicator->setCreatedBy($data['CreatedBy']);

            $this->entityManager->persist($indicator);
            $this->entityManager->flush();

            return $this->redirectToRoute('hrmsystem/indicator', ['id' => $user_id]);
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
    }

    #[Route('/hrmsystem/appraisal{id}', name: 'hrmsystem/appraisal')]
    public function appraisal(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $appraisal = new Appraisals();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $appraisal->setUser($user);
        $form = $this->createForm(AppraisalType::class, $appraisal, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($appraisal);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/appraisal',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(appraisals::class);
        $appraisals = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/appraisal.html.twig', [
            'controller_name' => 'HrmsystemController',
            'appraisals' => $appraisals,
            'form' => $form->createView(),
        ]);
    }
    //delete appraisal
    #[Route('/hrmsystem/appraisal/{id}/delete/{user_id}', name: 'appraisal_delete', methods: ["GET", "POST"])]
    public function appraisalDelete(appraisals $appraisal, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$appraisal) {
            throw $this->createNotFoundException('appraisal not found');
        }

        $this->entityManager->remove($appraisal);
        $this->entityManager->flush();

        return $this->redirectToRoute('hrmsystem/appraisal', ['id' => $user_id]);
    }

    // edit appraisal
    #[Route("/hrmsystem/appraisal/{id}/edit/{user_id}", name: "appraisal_edit", methods: ["GET", "PUT", "POST"])]
    public function appraisalEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Appraisals::class);
        $appraisal = $repository->find($id);

        if (!$appraisal) {
            throw $this->createNotFoundException('appraisal not found');
        }

        $form = $this->createForm(AppraisalType::class, $appraisal,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $appraisal = $form->getData();
                $this->entityManager->persist($appraisal);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/appraisal', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(appraisals::class);
        $appraisals = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/appraisal.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'appraisal' => $appraisals,
        ]);
    }


    #[Route('/hrmsystem/goal_tracking/{id}', name: 'hrmsystem/goal_tracking')]
    public function goalTracking(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $goalTracking = new GoalTrackings();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $goalTracking->setUser($user);
        $form = $this->createForm(GoalTrackingType::class, $goalTracking, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($goalTracking);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/goal_tracking', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(goalTrackings::class);
        $goalTrackings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/goalTracking.html.twig', [
            'controller_name' => 'MainController',
            'goalTrackings' => $goalTrackings,
            'form' => $form->createView(),
        ]);
    }
    // delete goal Tracking
    #[Route('/hrmsystem/goal_tracking/{id}/delete/{user_id}', name: 'goalTracking_delete', methods: ["GET", "POST"])]
    public function goalTrackingDelete(goalTrackings $goalTracking, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($goalTracking);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/goal_tracking', ['id' => $user_id]);
    }
    // edit goal tracking
    #[Route("/hrmsystem/goal_tracking/{id}/edit/{user_id}", name: "goalTracking_edit", methods: ["GET", "PUT", "POST"])]
    public function goalTrackingEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(GoalTrackings::class);
        $goalTracking = $repository->find($id);
        if (!$goalTracking) {
            throw $this->createNotFoundException('goalTracking not found');
        }
        $form = $this->createForm(GoalTrackingType::class, $goalTracking,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $goalTracking = $form->getData();
                $this->entityManager->persist($goalTracking);
                $this->entityManager->flush();
                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/goal_tracking', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(goalTrackings::class);
        $goalTrackings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/goalTracking.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'goalTrackings' => $goalTrackings,
        ]);
    }
    #[Route('/hrmsystem/training_list/{id}', name: 'hrmsystem/training_list')]
    public function trainingList(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/trainingList.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/hrmsystem/trainer/{id}', name: 'hrmsystem/trainer')]
    public function trainer(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $trainer = new Trainer();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $trainer->setUser($user);
        $form = $this->createForm(TrainerType::class, $trainer, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($trainer);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/trainer', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(trainer::class);
        $trainers = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/trainer.html.twig', [
            'controller_name' => 'MainController',
            'trainers' => $trainers,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/hrmsystem/trainer/{id}/delete/{user_id}', name: 'trainer_delete', methods: ["GET", "POST"])]
    public function trainerDelete(trainer $trainer, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($trainer);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/trainer', ['id' => $user_id]);
    }
    #[Route('/hrmsystem/trainer/{id}/edit/{user_id}', name: 'trainer_edit', methods: ["GET", "PUT", "POST"])]
    public function trainerEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Trainer::class);
        $trainer = $repository->find($id);
        if (!$trainer) {
            throw $this->createNotFoundException('trainer not found');
        }
        $form = $this->createForm(TrainerType::class, $trainer,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $trainer = $form->getData();
                $this->entityManager->persist($trainer);
                $this->entityManager->flush();
                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/trainer', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(trainer::class);
        $trainers = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/trainer.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'trainers' => $trainers,
        ]);
    }
    #[Route('/hrmsystem/jobs', name: 'hrmsystem/jobs')]
    public function jobs(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/jobs.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/job_create', name: 'hrmsystem/job_create')]
    public function jobCreate(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/jobCreate.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/job_application', name: 'hrmsystem/job_application')]
    public function jobApplication(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/jobApplication.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/job_candidate', name: 'hrmsystem/job_candidate')]
    public function jobCandidate(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/jobCandidate.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/job_on-boarding', name: 'hrmsystem/job_on-boarding')]
    public function jobOnBoarding(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/jobOnBoarding.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/custom_question/{id}', name: 'hrmsystem/custom_question', methods: ["GET", "POST"])]
    public function customQuestion(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $customQuestion = new CustomQuestions();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $customQuestion->setUser($user);
        $form = $this->createForm(CustomQuestionsType::class, $customQuestion,  ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($customQuestion);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/custom_question', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(CustomQuestions::class);
        $customQuestions = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/customQuestion.html.twig', [
            'controller_name' => 'HrmsystemController',
            'customQuestions' => $customQuestions,
            'form' => $form->createView(),
        ]);
    }
    // delete customQuestions
    #[Route('/hrmsystem/customQuestions/{id}/delete/{user_id}', name: 'customQuestions_delete', methods: ["GET", "POST"])]
    public function customQuestionsDelete(CustomQuestions $customQuestions, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($customQuestions);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/custom_question', ['id' => $user_id]);
    }

    // edit customQuestion
    #[Route("/hrmsystem/customQuestion/{id}/edit/{user_id}", name: "customQuestions_edit", methods: ["GET", "PUT", "POST"])]
    public function customQuestionEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(CustomQuestions::class);
        $customQuestion = $repository->find($id);

        if (!$customQuestion) {
            throw $this->createNotFoundException('customQuestion not found');
        }

        $form = $this->createForm(CustomQuestionsType::class, $customQuestion);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $customQuestion = $form->getData();
                $this->entityManager->persist($customQuestion);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/custom_question', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(CustomQuestions::class);
        $customQuestions = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/customQuestion.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'customQuestions' => $customQuestions,
        ]);
    }


    #[Route('/hrmsystem/interview_schedule', name: 'hrmsystem/interview_schedule')]
    public function interviewSchedule(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/interviewSchedule.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/career', name: 'hrmsystem/career')]
    public function career(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/career.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/award/{id}', name: 'hrmsystem/award', methods: ["GET", "PUT", "POST"])]
    public function award(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $award = new Award();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $award->setUser($user);
        $form = $this->createForm(AwardType::class, $award, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($award);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/award', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(award::class);
        $awards = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/award.html.twig', [
            'controller_name' => 'MainController',
            'awards' => $awards,
            'form' => $form->createView(),
        ]);
    }
    // delete award 
    #[Route('/hrmsystem/award/{id}/delete/{user_id}', name: 'award_delete', methods: ["GET", "POST"])]
    public function awardDelete(award $award, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($award);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/award', ['id' => $user_id]);
    }
    // edit award
    #[Route("/hrmsystem/award/{id}/edit/{user_id}", name: "award_edit", methods: ["GET", "PUT", "POST"])]
    public function awardEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Award::class);
        $award = $repository->find($id);
        if (!$award) {
            throw $this->createNotFoundException('award not found');
        }
        $form = $this->createForm(AwardType::class, $award,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $award = $form->getData();
                $this->entityManager->persist($award);
                $this->entityManager->flush();
                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/award', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(award::class);
        $awards = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/award.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'awards' => $awards,
        ]);
    }
    #[Route('/hrmsystem/transfer/{id}', name: 'hrmsystem/transfer',  methods: ["GET", "PUT", "POST"])]
    public function transfer(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $transfer = new Transfer();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $transfer->setUser($user);
        $form = $this->createForm(TransferType::class, $transfer, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($transfer);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/transfer', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(transfer::class);
        $transfers = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/transfer.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'transfers' => $transfers
        ]);
    }
    // delete transfer 
    #[Route('/hrmsystem/transfer/{id}/delete/{user_id}', name: 'transfer_delete', methods: ["GET", "POST"])]
    public function transferDelete(transfer $transfer, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($transfer);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/transfer', ['id' => $user_id]);
    }
    // edit transfer
    #[Route("/hrmsystem/transfer/{id}/edit/{user_id}", name: "transfer_edit", methods: ["GET", "PUT", "POST"])]
    public function transferEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Transfer::class);
        $transfer = $repository->find($id);
        if (!$transfer) {
            throw $this->createNotFoundException('transfer not found');
        }
        $form = $this->createForm(TransferType::class, $transfer,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $transfer = $form->getData();
                $this->entityManager->persist($transfer);
                $this->entityManager->flush();
                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/transfer', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(transfer::class);
        $transfers = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/transfer.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'transfers' => $transfers,
        ]);
    }
    // Resignation
    #[Route('/hrmsystem/resignation/{id}', name: 'hrmsystem/resignation', methods: ["GET", "POST"])]
    public function resignation(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $resignation = new Resignation();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $resignation->setUser($user);
        $form = $this->createForm(ResignationType::class, $resignation,  ['current_user' => $this->getUser()]);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($resignation);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/resignation', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Resignation::class);
        $resignations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/resignation.html.twig', [
            'controller_name' => 'HrmsystemController',
            'resignations' => $resignations,
            'form' => $form->createView(),
        ]);
    }
    // delete resignation
    #[Route('/resignation/{id}/delete/{user_id}', name: 'resignation_delete', methods: ["GET", "POST"])]
    public function resignationDelete(Resignation $resignation, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($resignation);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/resignation',  ['id' => $user_id]);
    }
    // edit resignation
    #[Route("/hrmsystem/resignation/{id}/edit/{user_id}", name: "resignation_edit", methods: ["GET", "PUT", "POST"])]
    public function resignationEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Resignation::class);
        $resignation = $repository->find($id);

        if (!$resignation) {
            throw $this->createNotFoundException('Resignation not found');
        }

        $form = $this->createForm(ResignationType::class, $resignation,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $resignation = $form->getData();
                $this->entityManager->persist($resignation);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/resignation', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Resignation::class);
        $resignations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/resignation.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'resignations' => $resignations,
        ]);
    }

    #[Route('/hrmsystem/trip/{id}', name: 'hrmsystem/trip')]
    public function trip(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $trip = new Trip();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $trip->setUser($user);
        $form = $this->createForm(TripType::class, $trip, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($trip);
            $this->entityManager->flush();

            return $this->redirectToRoute('hrmsystem/trip', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Trip::class);
        $trips = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/trip.html.twig', [
            'controller_name' => 'HrmsystemController',
            'trips' => $trips,
            'form' => $form->createView(),
        ]);
    }
    // delete trip
    #[Route('/hrmsystem/trip/{id}/delete/{user_id}', name: 'trip_delete', methods: ["GET", "POST"])]
    public function tripDelete(Trip $trip, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($trip);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/trip', ['id' => $user_id]);
    }
    // edit trip
    #[Route("/hrmsystem/trip/{id}/edit/{user_id}", name: "trip_edit", methods: ["GET", "PUT", "POST"])]
    public function tripEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Trip::class);
        $trip = $repository->find($id);

        if (!$trip) {
            throw $this->createNotFoundException('trip not found');
        }

        $form = $this->createForm(TripType::class, $trip, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $trip = $form->getData();
                $this->entityManager->persist($trip);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/trip', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Trip::class);
        $trips = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/trip.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'trips' => $trips,
        ]);
    }


    #[Route('/hrmsystem/promotion/{id}', name: 'hrmsystem/promotion')]
    public function promotion(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $promotion = new Promotion();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $promotion->setUser($user);
        $form = $this->createForm(PromotionType::class, $promotion, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($promotion);
            $this->entityManager->flush();

            return $this->redirectToRoute('hrmsystem/promotion', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(promotion::class);
        $promotions = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/promotion.html.twig', [
            'controller_name' => 'HrmsystemController',
            'promotions' => $promotions,
            'form' => $form->createView(),
        ]);
    }
    // delete promotion
    #[Route('/hrmsystem/promotion/{id}/delete/{user_id}', name: 'promotion_delete', methods: ["GET", "POST"])]
    public function promotionDelete(Promotion $promotion, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($promotion);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/promotion', ['id' => $user_id]);
    }
    // edit promotion
    #[Route("/hrmsystem/promotion/{id}/edit/{user_id}", name: "promotion_edit", methods: ["GET", "PUT", "POST"])]
    public function promotionEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Promotion::class);
        $promotion = $repository->find($id);

        if (!$promotion) {
            throw $this->createNotFoundException('promotion not found');
        }

        $form = $this->createForm(PromotionType::class, $promotion, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $promotion = $form->getData();
                $this->entityManager->persist($promotion);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/promotion', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Promotion::class);
        $promotions = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/promotion.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'promotions' => $promotions,
        ]);
    }
    #[Route('/hrmsystem/complaints/{id}', name: 'hrmsystem/complaints', methods: ["GET", "POST"])]
    public function complaints(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $complaints = new Complaints();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $complaints->setUser($user);
        $form = $this->createForm(ComplaintsType::class, $complaints,  ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($complaints);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/complaints', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Complaints::class);
        $complaintss = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/complaints.html.twig', [
            'controller_name' => 'HrmsystemController',
            'complaintss' => $complaintss,
            'form' => $form->createView(),
        ]);
    }
    // delete complaints
    #[Route('/hrmsystem/complaints/{id}/delete/{user_id}', name: 'complaints_delete', methods: ["GET", "POST"])]
    public function ComplaintsDelete(Complaints $complaints, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($complaints);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/complaints', ['id' => $user_id]);
    }
    // edit complaints
    #[Route("/hrmsystem/complaints/{id}/edit/{user_id}", name: "complaints_edit", methods: ["GET", "PUT", "POST"])]
    public function complaintsEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Complaints::class);
        $complaints = $repository->find($id);

        if (!$complaints) {
            throw $this->createNotFoundException('complaints not found');
        }

        $form = $this->createForm(ComplaintsType::class, $complaints, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $complaints = $form->getData();
                $this->entityManager->persist($complaints);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/complaints', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Complaints::class);
        $complaintss = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/complaints.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'complaintss' => $complaintss,
        ]);
    }
    #[Route('/hrmsystem/warning/{id}', name: 'hrmsystem/warning')]
    public function warning(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $warning = new Warning();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $warning->setUser($user);
        $form = $this->createForm(WarningType::class, $warning, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($warning);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/warning', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Warning::class);
        $warnings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/warning.html.twig', [
            'controller_name' => 'HrmsystemController',
            'warnings' => $warnings,
            'form' => $form->createView(),
        ]);
    }
    // delete warning
    #[Route('/hrmsystem/warning/{id}/delete/{user_id}', name: 'warning_delete', methods: ["GET", "POST"])]
    public function warningDelete(Warning $warning, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($warning);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/warning', ['id' => $user_id]);
    }
    // edit warning
    #[Route("/hrmsystem/warning/{id}/edit/{user_id}", name: "warning_edit", methods: ["GET", "PUT", "POST"])]
    public function warningEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Warning::class);
        $warning = $repository->find($id);

        if (!$warning) {
            throw $this->createNotFoundException('warning not found');
        }

        $form = $this->createForm(WarningType::class, $warning, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $warning = $form->getData();
                $this->entityManager->persist($warning);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/warning', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Warning::class);
        $warnings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/warning.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'warnings' => $warnings,
        ]);
    }
    #[Route('/hrmsystem/termination/{id}', name: 'hrmsystem/termination')]
    public function termination(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $termination = new Termination();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $termination->setUser($user);
        $form = $this->createForm(TerminationType::class, $termination, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($termination);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/termination', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(termination::class);
        $terminations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/termination.html.twig', [
            'controller_name' => 'HrmsystemController',
            'terminations' => $terminations,
            'form' => $form->createView(),
        ]);
    }
    // delete termination
    #[Route('/hrmsystem/termination/{id}/delete/{user_id}', name: 'termination_delete', methods: ["GET", "POST"])]
    public function terminationDelete(Termination $termination, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($termination);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/termination', ['id' => $user_id]);
    }
    //edit termination
    #[Route("/hrmsystem/termination/{id}/edit/{user_id}", name: "termination_edit", methods: ["GET", "PUT", "POST"])]
    public function terminationEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(termination::class);
        $termination = $repository->find($id);

        if (!$termination) {
            throw $this->createNotFoundException('termination not found');
        }

        $form = $this->createForm(TerminationType::class, $termination, ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $termination = $form->getData();
                $this->entityManager->persist($termination);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/termination', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Termination::class);
        $terminations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/termination.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'terminations' => $terminations,
        ]);
    }
    #[Route('/hrmsystem/announcement/{id}', name: 'hrmsystem/announcement')]
    public function announcement(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $announcement = new Announcement();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $announcement->setUser($user);
        $form = $this->createForm(AnnouncementType::class, $announcement, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($announcement);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/announcement', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(announcement::class);
        $announcements = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/announcement.html.twig', [
            'controller_name' => 'HrmsystemController',
            'announcements' => $announcements,
            'form' => $form->createView(),
        ]);
    }
    // announcement delete
    #[Route('/hrmsystem/announcement/{id}/delete/{user_id}', name: 'announcement_delete', methods: ["GET", "POST"])]
    public function announcementDelete(Announcement $announcement, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($announcement);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/announcement', ['id' => $user_id]);
    }
    // announcement edit
    #[Route("/hrmsystem/announcement/{id}/edit/{user_id}", "announcement_edit", methods: ["GET", "PUT", "POST"])]
    public function announcementEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Announcement::class);
        $announcement = $repository->find($id);

        if (!$announcement) {
            throw $this->createNotFoundException('announcement not found');
        }

        $form = $this->createForm(AnnouncementType::class, $announcement);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $announcement = $form->getData();
                $this->entityManager->persist($announcement);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/announcement', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Announcement::class);
        $announcements = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/announcement.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'announcements' => $announcements,
        ]);
    }
    #[Route('/hrmsystem/holidays/{id}', name: 'hrmsystem/holidays')]
    public function holidays(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $holidays = new Holidays();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $holidays->setUser($user);
        $form = $this->createForm(HolidaysType::class, $holidays, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($holidays);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/holidays', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Holidays::class);
        $holidayss = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/holidays.html.twig', [
            'controller_name' => 'HrmsystemController',
            'holidayss' => $holidayss,
            'form' => $form->createView(),
        ]);
    }
    // holiday delete
    #[Route('/hrmsystem/holidays/{id}/delete/{user_id}', name: 'holidays_delete', methods: ["GET", "POST"])]
    public function holidaysDelete(Holidays $holidays, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($holidays);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/holidays', ['id' => $user_id]);
    }
    // holiday edit
    #[Route("/hrmsystem/holidays/{id}/edit/{user_id}", name: "holidays_edit", methods: ["GET", "PUT", "POST"])]
    public function holidaysEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Holidays::class);
        $holidays = $repository->find($id);

        if (!$holidays) {
            throw $this->createNotFoundException('holidays not found');
        }

        $form = $this->createForm(HolidaysType::class, $holidays);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $holidays = $form->getData();
                $this->entityManager->persist($holidays);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/holidays', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Holidays::class);
        $holidayss = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/holidays.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'holidayss' => $holidayss,
        ]);
    }
    #[Route('/hrmsystem/event_setup', name: 'hrmsystem/event_setup')]
    public function eventSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/eventSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/meeting{id}', name: 'hrmsystem/meeting')]
    public function meeting(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $meeting = new Meeting();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $meeting->setUser($user);
        $form = $this->createForm(MeetingType::class, $meeting, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();

            $this->addFlash('success', 'Meeting created successfully.');

            // Redirect after successful form submission
            return $this->redirectToRoute('hrmsystem/meeting',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(meeting::class);
        $meetings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/meeting.html.twig', [
            'controller_name' => 'HrmsystemController',
            'meetings' => $meetings,
            'form' => $form->createView(),
        ]);
    }

    //delete meeting
    #[Route('/hrmsystem/meeting/{id}/delete/{user_id}', name: 'meeting_delete', methods: ["GET", "POST"])]
    public function meetingDelete(Meeting $meeting, int $id, int $user_id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$meeting) {
            throw $this->createNotFoundException('Meeting not found');
        }

        $entityManager->remove($meeting);
        $entityManager->flush();

        return $this->redirectToRoute('hrmsystem/meeting', ['id' => $user_id]);
    }

    // edit meeting
    #[Route("/hrmsystem/meeting/{id}/edit/{user_id}", name: "meeting_edit", methods: ["GET", "PUT", "POST"])]
    public function meetingEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Meeting::class);
        $meeting = $repository->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('meeting not found');
        }

        $form = $this->createForm(MeetingType::class, $meeting,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $meeting = $form->getData();
                $this->entityManager->persist($meeting);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/meeting', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(meeting::class);
        $meetings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/meeting.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'meetings' => $meetings,
        ]);
    }

    #[Route('/hrmsystem/employees_asset_setup/{id}', name: 'hrmsystem/employees_asset_setup', methods: ["GET", "POST"])]
    public function employeesAssetSetup(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $employeesAssetSetup = new EmployeesAssetSetup();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $employeesAssetSetup->setUser($user);
        $form = $this->createForm(EmployeesAssetSetupType::class, $employeesAssetSetup, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($employeesAssetSetup);
            $this->entityManager->flush();
            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/employees_asset_setup',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(EmployeesAssetSetup::class);
        $employeesAssetSetups = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/employeesAssetSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
            'employeesAssetSetups' => $employeesAssetSetups,
            'form' => $form->createView(),
        ]);
    }
    // delete employeesAssetSetupForm
    #[Route('/hrmsystem/employees_asset_setup/{id}/delete/{user_id}', name: 'employeesAssetSetup_delete', methods: ["GET", "POST"])]
    public function employeesAssetSetupDelete(EmployeesAssetSetup $employeesAssetSetup, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($employeesAssetSetup);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/employees_asset_setup', ['id' => $user_id]);
    }
    // edit resignation
    #[Route("/hrmsystem/employees_asset_setup/{id}/edit/{user_id}", name: "employeesAssetSetup_edit", methods: ["GET", "PUT", "POST"])]
    public function employeesAssetSetupEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(EmployeesAssetSetup::class);
        $employeesAssetSetup = $repository->find($id);

        if (!$employeesAssetSetup) {
            throw $this->createNotFoundException('employeesAssetSetup not found');
        }

        $form = $this->createForm(EmployeesAssetSetupType::class, $employeesAssetSetup);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $employeesAssetSetup = $form->getData();
                $this->entityManager->persist($employeesAssetSetup);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/employees_asset_setup', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(employeesAssetSetup::class);
        $employeesAssetSetups = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/employeesAssetSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'employeesAssetSetups' => $employeesAssetSetups,
        ]);
    }
    #[Route('/hrmsystem/document_setup', name: 'hrmsystem/document_setup')]
    public function documentSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/documentSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/company_policy', name: 'hrmsystem/company_policy')]
    public function companyPolicy(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/companyPolicy.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }

    #[Route('/hrmsystem/hrm_system_setup/branch/{id}', name: 'hrmsystem/hrm_system_setup/branch')]
    public function hrmSystemSetupBranch(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $branch = new Branch();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $branch->setUser($user);
        $form = $this->createForm(BranchType::class, $branch, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($branch);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/branch',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(branch::class);
        $branchs = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/branch.html.twig', [
            'controller_name' => 'HrmsystemController',
            'branchs' => $branchs,
            'form' => $form->createView(),
        ]);
    }
    // delete branch
    #[Route('/hrmsystem/hrm_system_setup/{id}/delete/{user_id}', name: 'branch_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupBranchDelete(Branch $branch, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($branch);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/branch', ['id' => $user_id]);
    }
    // edit resignation
    #[Route("/hrmsystem/hrm_system_setup/{id}/edit/{user_id}", name: "branch_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupBranchEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Branch::class);
        $branch = $repository->find($id);

        if (!$branch) {
            throw $this->createNotFoundException('branch not found');
        }

        $form = $this->createForm(BranchType::class, $branch);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $branch = $form->getData();
                $this->entityManager->persist($branch);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/employees_asset_setup', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Branch::class);
        $branchs = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/branch.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'branchs' => $branchs,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/department/{id}', name: 'hrmsystem/hrm_system_setup/department')]
    public function hrmSystemSetupDepartment(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $department = new Department();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $department->setUser($user);
        $form = $this->createForm(DepartmentType::class, $department, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($department);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/department',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(department::class);
        $departments = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/department.html.twig', [
            'controller_name' => 'HrmsystemController',
            'departments' => $departments,
            'form' => $form->createView(),
        ]);
    }
    // delete department
    #[Route('/hrmsystem/hrm_system_setup/department/{id}/delete/{user_id}', name: 'department_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupDepartmentDelete(Department $department, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($department);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/department', ['id' => $user_id]);
    }
    // edit department
    #[Route("/hrmsystem/hrm_system_setup/department/{id}/edit/{user_id}", name: "department_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupdepartmentEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(department::class);
        $department = $repository->find($id);

        if (!$department) {
            throw $this->createNotFoundException('department not found');
        }

        $form = $this->createForm(DepartmentType::class, $department);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $department = $form->getData();
                $this->entityManager->persist($department);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/employees_asset_setup', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Department::class);
        $departments = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/department.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'departments' => $departments,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/designation/{id}', name: 'hrmsystem/hrm_system_setup/designation')]
    public function hrmSystemSetupDesignation(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $designation = new Designation();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $designation->setUser($user);
        $form = $this->createForm(DesignationType::class, $designation, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($designation);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/designation',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(designation::class);
        $designations = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/designation.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'designations' => $designations,
        ]);
    }
    // delete designation
    #[Route('/hrmsystem/hrm_system_setup/designation/{id}/delete/{user_id}', name: 'designation_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupDesignationDelete(Designation $designation, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($designation);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/designation', ['id' => $user_id]);
    }
    // edit designation
    #[Route("/hrmsystem/hrm_system_setup/designation/{id}/edit/{user_id}", name: "designation_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupDesignationEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Designation::class);
        $designation = $repository->find($id);

        if (!$designation) {
            throw $this->createNotFoundException('designation not found');
        }

        $form = $this->createForm(DesignationType::class, $designation);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $designation = $form->getData();
                $this->entityManager->persist($designation);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/designation', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(designation::class);
        $designations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/designation.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'designations' => $designations,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/leave-type/{id}', name: 'hrmsystem/hrm_system_setup/leave-type')]
    public function hrmSystemSetupLeaveType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $leave = new LeaveModule();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $leave->setUser($user);
        $form = $this->createForm(LeaveType::class, $leave, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($leave);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/leave-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(LeaveModule::class);
        $leaves = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/leaveType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'leaves' => $leaves,
            'form' => $form->createView(),
        ]);
    }
    // delete leave
    #[Route('/hrmsystem/hrm_system_setup/leave/{id}/delete/{user_id}', name: 'leave_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupleaveDelete(LeaveModule $leave, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($leave);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/leave-type', ['id' => $user_id]);
    }
    // edit leave
    #[Route("/hrmsystem/hrm_system_setup/leave/{id}/edit/{user_id}", name: "leave_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupleaveEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(LeaveModule::class);
        $leave = $repository->find($id);

        if (!$leave) {
            throw $this->createNotFoundException('leave not found');
        }

        $form = $this->createForm(LeaveType::class, $leave);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $leave = $form->getData();
                $this->entityManager->persist($leave);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/leave-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(LeaveModule::class);
        $leaves = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/leave.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'leaves' => $leaves,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/document-type/{id}', name: 'hrmsystem/hrm_system_setup/document-type')]
    public function hrmSystemSetupDocumentType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $document = new Document();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $document->setUser($user);
        $form = $this->createForm(DocumentType::class, $document, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($document);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/document-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(document::class);
        $documents = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/documentType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'documents' => $documents,
            'form' => $form->createView(),
        ]);
    }
    // delete document
    #[Route('/hrmsystem/hrm_system_setup/document/{id}/delete/{user_id}', name: 'document_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupdocumentDelete(Document $document, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($document);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/document-type', ['id' => $user_id]);
    }
    // edit document
    #[Route("/hrmsystem/hrm_system_setup/document/{id}/edit/{user_id}", name: "document_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupdocumentEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Document::class);
        $document = $repository->find($id);

        if (!$document) {
            throw $this->createNotFoundException('document not found');
        }

        $form = $this->createForm(DocumentType::class, $document);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $document = $form->getData();
                $this->entityManager->persist($document);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/document-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(document::class);
        $documents = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/document.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'documents' => $documents,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/payslip-type/{id}', name: 'hrmsystem/hrm_system_setup/payslip-type')]
    public function hrmSystemSetupPaySlipType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $payslip = new Payslip();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $payslip->setUser($user);
        $form = $this->createForm(PayslipType::class, $payslip, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($payslip);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/payslip-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(payslip::class);
        $payslips = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/paySlipType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'payslips' => $payslips,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/payslip/{id}/delete/{user_id}', name: 'payslip_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupPayslipDelete(Payslip $payslip, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($payslip);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/payslip-type', ['id' => $user_id]);
    }
    // edit payslip
    #[Route("/hrmsystem/hrm_system_setup/payslip/{id}/edit/{user_id}", name: "payslip_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetuppayslipEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Payslip::class);
        $payslip = $repository->find($id);

        if (!$payslip) {
            throw $this->createNotFoundException('payslip not found');
        }

        $form = $this->createForm(PayslipType::class, $payslip);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $payslip = $form->getData();
                $this->entityManager->persist($payslip);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/payslip-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(payslip::class);
        $payslips = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/payslip.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'payslips' => $payslips,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/allowance-option/{id}', name: 'hrmsystem/hrm_system_setup/allowance-option')]
    public function hrmSystemSetupAllowanceOption(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $allowance = new Allowance();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $allowance->setUser($user);
        $form = $this->createForm(AllowanceType::class, $allowance, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($allowance);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/allowance-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Allowance::class);
        $allowances = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/allowanceOption.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'allowances' => $allowances,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/allowance-option/{id}/delete/{user_id}', name: 'payslip_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupallowanceDelete(Allowance $allowance, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($allowance);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/payslip-type', ['id' => $user_id]);
    }
    // edit allowance
    #[Route("/hrmsystem/hrm_system_setup/allowance/{id}/edit/{user_id}", name: "allowance_edit", methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupallowanceEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Allowance::class);
        $allowance = $repository->find($id);

        if (!$allowance) {
            throw $this->createNotFoundException('allowance not found');
        }

        $form = $this->createForm(AllowanceType::class, $allowance);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $allowance = $form->getData();
                $this->entityManager->persist($allowance);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/allowance-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(allowance::class);
        $allowances = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/allowance.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'allowances' => $allowances,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/loan-option/{id}', name: 'hrmsystem/hrm_system_setup/loan-option')]
    public function hrmSystemSetupLoanOption(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $loan = new Loan();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $loan->setUser($user);
        $form = $this->createForm(LoanType::class, $loan, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($loan);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/loan-option',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(loan::class);
        $loans = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/loanOption.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'loans' => $loans,
        ]);
    }
    // delete loan option
    #[Route('/hrmsystem/hrm_system_setup/loan-option/{id}/delete/{user_id}', name: 'loan_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupLoanOptionDelete(Loan $loan, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($loan);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/loan-option', ['id' => $user_id]);
    }
    // edit loan option
    #[Route("/hrmsystem/hrm_system_setup/loan-option/{id}/edit/{user_id}", name: 'loan_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupLoanOptionEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Loan::class);
        $loan = $repository->find($id);

        if (!$loan) {
            throw $this->createNotFoundException('loan not found');
        }

        $form = $this->createForm(LoanType::class, $loan);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $loan = $form->getData();
                $this->entityManager->persist($loan);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/loan-option', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Loan::class);
        $loans = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/loan.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'loans' => $loans,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/deduction-option/{id}', name: 'hrmsystem/hrm_system_setup/deduction-option')]
    public function hrmSystemSetupDeductionOption(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $deduction = new Deduction();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $deduction->setUser($user);
        $form = $this->createForm(DeductionType::class, $deduction, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($deduction);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/deduction-option',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Deduction::class);
        $deductions = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/deductionOption.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'deductions' => $deductions,
        ]);
    }
    // delete deduction option
    #[Route('/hrmsystem/hrm_system_setup/deduction-option/{id}/delete/{user_id}', name: 'deduction_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupdeductionOptionDelete(Deduction $deduction, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($deduction);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/deduction-option', ['id' => $user_id]);
    }
    // edit deduction option
    #[Route("/hrmsystem/hrm_system_setup/deduction-option/{id}/edit/{user_id}", name: 'deduction_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupdeductionOptionEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Deduction::class);
        $deduction = $repository->find($id);

        if (!$deduction) {
            throw $this->createNotFoundException('deduction not found');
        }

        $form = $this->createForm(DeductionType::class, $deduction);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $deduction = $form->getData();
                $this->entityManager->persist($deduction);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/deduction-option', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Deduction::class);
        $deductions = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/deduction.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'deductions' => $deductions,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/goal-type/{id}', name: 'hrmsystem/hrm_system_setup/goal-type')]
    public function hrmSystemSetupGoalType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $goal = new Goal();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $goal->setUser($user);
        $form = $this->createForm(GoalType::class, $goal, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($goal);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/goal-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(goal::class);
        $goals = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/goalType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'goals' => $goals,
        ]);
    }
    // delete goal option
    #[Route('/hrmsystem/hrm_system_setup/goal-option/{id}/delete/{user_id}', name: 'goal_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupGoalOptionDelete(Goal $goal, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($goal);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/goal-type', ['id' => $user_id]);
    }
    // edit goal option
    #[Route("/hrmsystem/hrm_system_setup/goal-option/{id}/edit/{user_id}", name: 'goal_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupgoalOptionEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(goal::class);
        $goal = $repository->find($id);

        if (!$goal) {
            throw $this->createNotFoundException('goal not found');
        }

        $form = $this->createForm(goalType::class, $goal);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $goal = $form->getData();
                $this->entityManager->persist($goal);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/goal-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(goal::class);
        $goals = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/goal.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'goals' => $goals,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/training-type/{id}', name: 'hrmsystem/hrm_system_setup/training-type')]
    public function hrmSystemSetupTrainingType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $training = new Training();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $training->setUser($user);
        $form = $this->createForm(TrainingType::class, $training, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($training);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/training-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(training::class);
        $trainings = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/trainingType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'trainings' => $trainings,
        ]);
    }
    // delete training option
    #[Route('/hrmsystem/hrm_system_setup/training-type/{id}/delete/{user_id}', name: 'training_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetuptrainingTypeDelete(training $training, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($training);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/training-type', ['id' => $user_id]);
    }
    // edit goal option
    #[Route("/hrmsystem/hrm_system_setup/training-type/{id}/edit/{user_id}", name: 'training_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupTrainingTypeEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(goal::class);
        $training = $repository->find($id);

        if (!$training) {
            throw $this->createNotFoundException('training not found');
        }

        $form = $this->createForm(TrainingType::class, $training);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $training = $form->getData();
                $this->entityManager->persist($training);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/training-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Training::class);
        $trainings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/training.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'trainings' => $trainings,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/award-type/{id}', name: 'hrmsystem/hrm_system_setup/award-type')]
    public function hrmSystemSetupAwardType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $award = new AwardHRM();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $award->setUser($user);
        $form = $this->createForm(AwardHRMType::class, $award, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($award);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/award-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(AwardHRM::class);
        $awards = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/awardType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'awards' => $awards,
        ]);
    }
    // delete award type 
    #[Route('/hrmsystem/hrm_system_setup/award-type/{id}/delete/{user_id}', name: 'awardHRM_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupAwardTypeDelete(AwardHRM $award, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($award);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/award-type', ['id' => $user_id]);
    }
    // edit award type
    #[Route("/hrmsystem/hrm_system_setup/award-type/{id}/edit/{user_id}", name: 'awardHRM_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupawardTypeEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(AwardHRM::class);
        $award = $repository->find($id);

        if (!$award) {
            throw $this->createNotFoundException('award not found');
        }

        $form = $this->createForm(AwardHRM::class, $award);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $award = $form->getData();
                $this->entityManager->persist($award);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/award-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(AwardHRM::class);
        $awards = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/award.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'awards' => $awards,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/termination-type/{id}', name: 'hrmsystem/hrm_system_setup/termination-type')]
    public function hrmSystemSetupTerminationType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $termination = new TerminationHRM();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $termination->setUser($user);
        $form = $this->createForm(TerminationHRMType::class, $termination, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($termination);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/termination-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(terminationHRM::class);
        $terminations = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/terminationType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'terminations' => $terminations,
        ]);
    }
    // delete termination type 
    #[Route('/hrmsystem/hrm_system_setup/terminaiton-type/{id}/delete/{user_id}', name: 'terminationHRM_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupTerminaitonTypeDelete(TerminationHRM $terminaiton, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($terminaiton);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/terminaiton-type', ['id' => $user_id]);
    }
    // edit termination type
    #[Route("/hrmsystem/hrm_system_setup/termination-type/{id}/edit/{user_id}", name: 'terminationHRM_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupterminationTypeEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(terminationHRM::class);
        $termination = $repository->find($id);

        if (!$termination) {
            throw $this->createNotFoundException('termination not found');
        }

        $form = $this->createForm(terminationHRM::class, $termination);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $termination = $form->getData();
                $this->entityManager->persist($termination);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/termination-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(terminationHRM::class);
        $terminations = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/termination.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'terminations' => $terminations,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/job-category/{id}', name: 'hrmsystem/hrm_system_setup/job-category')]
    public function hrmSystemSetupJobCategory(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $jobCategory = new JobCategory();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $jobCategory->setUser($user);
        $form = $this->createForm(JobCategoryType::class, $jobCategory, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($jobCategory);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/job-category',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(JobCategory::class);
        $jobCategorys = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/jobCategory.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'jobCategorys' => $jobCategorys,
        ]);
    }
    // delete job Category type 
    #[Route('/hrmsystem/hrm_system_setup/job-category/{id}/delete/{user_id}', name: 'jobCategory_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupJobCategoryDelete(JobCategory $jobCategory, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($jobCategory);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/job-category', ['id' => $user_id]);
    }
    // edit job Category type
    #[Route("/hrmsystem/hrm_system_setup/job-category/{id}/edit/{user_id}", name: 'jobCategory_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupJobCategoryEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(JobCategory::class);
        $jobCategory = $repository->find($id);

        if (!$jobCategory) {
            throw $this->createNotFoundException('jobCategory not found');
        }

        $form = $this->createForm(JobCategory::class, $jobCategory);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $jobCategory = $form->getData();
                $this->entityManager->persist($jobCategory);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/jobCategory-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(JobCategory::class);
        $jobCategorys = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/jobCategory.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'jobCategorys' => $jobCategorys,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/job-stage/{id}', name: 'hrmsystem/hrm_system_setup/job-stage')]
    public function hrmSystemSetupJobStage(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $jobStage = new JobStage();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $jobStage->setUser($user);
        $form = $this->createForm(JobStageType::class, $jobStage, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($jobStage);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/job-stage',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(JobStage::class);
        $jobStages = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/jobStage.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'jobStages' => $jobStages,
        ]);
    }
    // delete job stage type 
    #[Route('/hrmsystem/hrm_system_setup/job-stage/{id}/delete/{user_id}', name: 'jobstage_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupJobStageDelete(JobStage $jobstage, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($jobstage);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/job-stage', ['id' => $user_id]);
    }
    // edit job stage type
    #[Route("/hrmsystem/hrm_system_setup/job-stage/{id}/edit/{user_id}", name: 'jobstage_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupJobstageEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(JobStage::class);
        $jobstage = $repository->find($id);

        if (!$jobstage) {
            throw $this->createNotFoundException('jobstage not found');
        }

        $form = $this->createForm(JobStage::class, $jobstage);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $jobstage = $form->getData();
                $this->entityManager->persist($jobstage);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/jobstage-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(JobStage::class);
        $jobstages = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/jobstage.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'jobstages' => $jobstages,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/performance-type/{id}', name: 'hrmsystem/hrm_system_setup/performance-type')]
    public function hrmSystemSetupPerformanceType(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $performance = new Performance();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $performance->setUser($user);
        $form = $this->createForm(PerformanceType::class, $performance, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($performance);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/performance-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Performance::class);
        $performances = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/hrmsystemsetup/performanceType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'performances' => $performances,
        ]);
    }
    // delete performance type 
    #[Route('/hrmsystem/hrm_system_setup/performance-type/{id}/delete/{user_id}', name: 'terminationHRM_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupPerformanceTypeDelete(Performance $performance, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($performance);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/performance-type', ['id' => $user_id]);
    }
    // edit job Category type
    #[Route("/hrmsystem/hrm_system_setup/performance-type/{id}/edit/{user_id}", name: 'jobCategory_edit', methods: ["GET", "PUT", "POST"])]
    public function hrmSystemSetupPerformanceTypeEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Performance::class);
        $performance = $repository->find($id);

        if (!$performance) {
            throw $this->createNotFoundException('performance not found');
        }

        $form = $this->createForm(Performance::class, $performance);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $performance = $form->getData();
                $this->entityManager->persist($performance);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/performance-type', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Performance::class);
        $performances = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/performance.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'performances' => $performances,
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/competencies/{id}', name: 'hrmsystem/hrm_system_setup/competencies')]
    public function hrmSystemSetupCompetencies(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $competencies = new Competencies();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $competencies->setUser($user);
        $form = $this->createForm(CompetenciesType::class, $competencies, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($competencies);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/hrm_system_setup/competencies-type',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(competencies::class);
        $competenciess = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/competencies.html.twig', [
            'controller_name' => 'HrmsystemController',
            'form' => $form->createView(),
            'competenciess' => $competenciess,
        ]);
    }
}
