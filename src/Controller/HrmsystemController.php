<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\HRMSystem\Trip;
use App\Entity\HRMSystem\Award;
use App\Form\HRMSystem\TripType;
use App\Entity\HRMSystem\Trainer;
use App\Entity\HRMSystem\Warning;
use App\Form\HRMSystem\AwardType;
use App\Entity\HRMSystem\Holidays;
use App\Entity\HRMSystem\Transfer;
use App\Entity\HRMSystem\Promotion;
use App\Form\HRMSystem\TrainerType;
use App\Form\HRMSystem\WarningType;
use App\Entity\HRMSystem\Complaints;
use App\Form\HRMSystem\HolidaysType;
use App\Form\HRMSystem\TransferType;
use App\Entity\HRMSystem\ManageLeave;
use App\Entity\HRMSystem\Resignation;
use App\Entity\HRMSystem\Termination;
use App\Form\HRMSystem\PromotionType;
use App\Entity\HRMSystem\Announcement;
use App\Entity\HRMSystem\GoalTracking;
use App\Form\HRMSystem\ComplaintsType;
use App\Form\HRMSystem\ManageLeaveType;
use App\Form\HRMSystem\ResignationType;
use App\Form\HRMSystem\TerminationType;
use App\Form\HRMSystem\AnnouncementType;
use App\Form\HRMSystem\GoalTrackingType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\HRMSystem\CustomQuestions;
use App\Form\HRMSystem\CustomQuestionsType;
use App\Entity\HRMSystem\EmployeesAssetSetup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\HRMSystem\EmployeesAssetSetupType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HRMSystem\HRM_System_Setup\Leave;
use App\Entity\HRMSystem\HRM_System_Setup\Branch;
use App\Entity\HRMSystem\HRM_System_Setup\Payslip;
use App\Form\HRMSystem\HRM_System_Setup\LeaveType;
use App\Entity\HRMSystem\HRM_System_Setup\Document;
use App\Form\HRMSystem\HRM_System_Setup\BranchType;
use App\Form\HRMSystem\HRM_System_Setup\PayslipType;
use App\Entity\HRMSystem\HRM_System_Setup\Department;
use App\Form\HRMSystem\HRM_System_Setup\DocumentType;
use App\Entity\HRMSystem\HRM_System_Setup\Designation;
use App\Form\HRMSystem\HRM_System_Setup\DepartmentType;
use App\Form\HRMSystem\HRM_System_Setup\DesignationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HrmsystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/hrmsystem/employee_setup', name: 'hrmsystem/employee_setup')]
    public function employeeSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/employeeSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
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
    // delete manage leave
    #[Route('/hrmsystem/manage_leave/{id}/delete/{user_id}', name: 'manageleave_delete', methods: ["GET", "POST"])]
    public function manageleaveDelete(Manageleave $Manageleave, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($Manageleave);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/manage_leave', ['id' => $user_id]);
    }
    // edit manage_leave
    #[Route("/hrmsystem/manage_leave/{id}/edit/{user_id}", name: "manageleave_edit", methods: ["GET", "PUT", "POST"])]
    public function manage_leaveEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Manageleave::class);
        $manageleave = $repository->find($id);

        if (!$manageleave) {
            throw $this->createNotFoundException('manageleave not found');
        }

        $form = $this->createForm(ManageleaveType::class, $manageleave,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $manageleave = $form->getData();
                $this->entityManager->persist($manageleave);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('hrmsystem/manage_leave', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(Manageleave::class);
        $manageleaves = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/edit/manageleave.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'manageLeaves' => $manageleaves,
        ]);
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
    #[Route('/hrmsystem/indicator', name: 'hrmsystem/indicator')]
    public function indicator(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/indicator.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/appraisal', name: 'hrmsystem/appraisal')]
    public function appraisal(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/appraisal.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/goal_tracking/{id}', name: 'hrmsystem/goal_tracking')]
    public function goalTracking(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $goalTracking = new GoalTracking();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $goalTracking->setUser($user);
        $form = $this->createForm(GoalTrackingType::class, $goalTracking, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($goalTracking);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('goalTracking', ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(goalTracking::class);
        $goalTrackings = $repository->findBy(['user' => $currentUser]);

        return $this->render('hrmsystem/goalTracking.html.twig', [
            'controller_name' => 'MainController',
            'goalTrackings' => $goalTrackings,
            'form' => $form->createView(),
        ]);
    }
    // delete goal Tracking
    #[Route('/hrmsystem/goal_tracking/{id}/delete/{user_id}', name: 'goalTracking_delete', methods: ["GET", "POST"])]
    public function goalTrackingDelete(goalTracking $goalTracking, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($goalTracking);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/goal_tracking', ['id' => $user_id]);
    }
    // edit manage_leave
    #[Route("/hrmsystem/goal_tracking/{id}/edit/{user_id}", name: "goalTracking_edit", methods: ["GET", "PUT", "POST"])]
    public function goalTrackingEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(GoalTracking::class);
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
        $repository = $this->entityManager->getRepository(goalTracking::class);
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
    #[Route('/hrmsystem/meeting', name: 'hrmsystem/meeting')]
    public function meeting(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/meeting.html.twig', [
            'controller_name' => 'HrmsystemController',
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
        $leave = new Leave();
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

        $repository = $this->entityManager->getRepository(leave::class);
        $leaves = $repository->findBy(['user' => $currentUser]);
        return $this->render('hrmsystem/hrmsystemsetup/leaveType.html.twig', [
            'controller_name' => 'HrmsystemController',
            'leaves' => $leaves,
            'form' => $form->createView(),
        ]);
    }
    // delete leave
    #[Route('/hrmsystem/hrm_system_setup/leave/{id}/delete/{user_id}', name: 'leave_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupleaveDelete(Leave $leave, int $id, int $user_id): Response
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
        $repository = $this->entityManager->getRepository(Leave::class);
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
        $repository = $this->entityManager->getRepository(leave::class);
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
    } // delete payslip
    #[Route('/hrmsystem/hrm_system_setup/payslip/{id}/delete/{user_id}', name: 'payslip_delete', methods: ["GET", "POST"])]
    public function hrmSystemSetupPayslipDelete(Payslip $payslip, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($payslip);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/hrm_system_setup/payslip-type', ['id' => $user_id]);
    }
    #[Route('/hrmsystem/hrm_system_setup/allowance-option', name: 'hrmsystem/hrm_system_setup/allowance-option')]
    public function hrmSystemSetupAllowanceOption(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/allowanceOption.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/loan-option', name: 'hrmsystem/hrm_system_setup/loan-option')]
    public function hrmSystemSetupLoanOption(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/loanOption.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/deduction-option', name: 'hrmsystem/hrm_system_setup/deduction-option')]
    public function hrmSystemSetupDeductionOption(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/deductionOption.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/goal-type', name: 'hrmsystem/hrm_system_setup/goal-type')]
    public function hrmSystemSetupGoalType(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/goalType.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/training-type', name: 'hrmsystem/hrm_system_setup/training-type')]
    public function hrmSystemSetupTrainingType(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/trainingType.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/award-type', name: 'hrmsystem/hrm_system_setup/award-type')]
    public function hrmSystemSetupAwardType(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/awardType.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/termination-type', name: 'hrmsystem/hrm_system_setup/termination-type')]
    public function hrmSystemSetupTerminationType(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/terminationType.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/job-category', name: 'hrmsystem/hrm_system_setup/job-category')]
    public function hrmSystemSetupJobCategory(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/jobCategory.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/job-stage', name: 'hrmsystem/hrm_system_setup/job-stage')]
    public function hrmSystemSetupJobStage(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/jobStage.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/performance-type', name: 'hrmsystem/hrm_system_setup/performance-type')]
    public function hrmSystemSetupPerformanceType(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/performanceType.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/hrm_system_setup/competencies', name: 'hrmsystem/hrm_system_setup/competencies')]
    public function hrmSystemSetupCompetencies(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmsystemsetup/competencies.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
}
