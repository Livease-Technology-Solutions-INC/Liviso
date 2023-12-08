<?php

namespace App\Controller;

use App\Entity\HRMSystem\Complaints;
use App\Entity\HRMSystem\ManageLeave;
use App\Form\HRMSystem\ComplaintsType;
use App\Form\HRMSystem\ManageLeaveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    #[Route('/hrmsystem/manage_leave', name: 'hrmsystem/manage_leave')]
    public function manageLeave(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $manageleave = new ManageLeave();
        $form = $this->createForm(ManageLeaveType::class, $manageleave);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($manageleave);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('manageleave');
        }

        $repository = $this->entityManager->getRepository(ManageLeave::class);
        $manageleaves = $repository->findAll();

        return $this->render('hrmsystem/manageleave.html.twig', [
            'controller_name' => 'HrmsystemController',
            'manageleaves' => $manageleaves,
            'form' => $form->createView(),
        ]);
    }
    // delete manage leave
    #[Route('/manage_leave/delete/{id}', name: 'Manageleave_delete', methods: ["GET", "POST"])]
    public function ManageleaveDelete(Manageleave $Manageleave): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($Manageleave);
        $this->entityManager->flush();
        return $this->redirectToRoute('Manageleave');
        // return new Response('post was deleted');
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
    #[Route('/hrmsystem/goal_tracking', name: 'hrmsystem/goal_tracking')]
    public function goalTracking(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/goalTracking.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/training_list', name: 'hrmsystem/training_list')]
    public function trainingList(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/trainingList.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/trainer', name: 'hrmsystem/trainer')]
    public function trainer(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/trainer.html.twig', [
            'controller_name' => 'HrmsystemController',
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
    #[Route('/hrmsystem/custom_question', name: 'hrmsystem/custom_question')]
    public function customQuestion(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/customQuestion.html.twig', [
            'controller_name' => 'HrmsystemController',
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
    #[Route('/hrmsystem/award', name: 'hrmsystem/award')]
    public function award(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/award.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/transfer', name: 'hrmsystem/transfer')]
    public function transfer(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/transfer.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/resignation', name: 'hrmsystem/resignation')]
    public function resignation(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/resignation.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/trip', name: 'hrmsystem/trip')]
    public function trip(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/trip.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/promotion', name: 'hrmsystem/promotion')]
    public function promotion(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/promotion.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/complaints', name: 'hrmsystem/complaints')]
    public function complaints(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $complaints = new Complaints();
        $form = $this->createForm(ComplaintsType::class, $complaints);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($complaints);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('hrmsystem/complaints');
        }

        $repository = $this->entityManager->getRepository(Complaints::class);
        $complaintss = $repository->findAll();

        return $this->render('hrmsystem/complaints.html.twig', [
            'controller_name' => 'HrmsystemController',
            'complaintss' => $complaintss,
            'form' => $form->createView(),
        ]);
    }
    // delete complaints
    #[Route('/complaints/delete/{id}', name: 'complaints_delete', methods: ["GET", "POST"])]
    public function ComplaintsDelete(Complaints $complaints): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->entityManager->remove($complaints);
        $this->entityManager->flush();
        return $this->redirectToRoute('hrmsystem/complaints');
        // return new Response('post was deleted');
    }
    // edit complaint
    #[Route('/hrmsystem/complaints/{id}', name: 'complaints_edit', methods: ["GET", "PUT"])]
    public function ComplaintsEdit(Request $request, Complaints $complaints): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ComplaintsType::class, $complaints);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the updated entity if the form is submitted and valid
            $this->entityManager->flush();

            return $this->redirectToRoute('hrmsystem/complaints');
        } else {
            dd($form->getErrors(true, true));
        }
        return $this->render('hrmsystem/complaints.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/hrmsystem/warning', name: 'hrmsystem/warning')]
    public function warning(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/warning.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/termination', name: 'hrmsystem/termination')]
    public function termination(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/termination.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/announcement', name: 'hrmsystem/announcement')]
    public function announcement(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/announcement.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
    #[Route('/hrmsystem/holidays', name: 'hrmsystem/holidays')]
    public function holidays(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/holidays.html.twig', [
            'controller_name' => 'HrmsystemController',
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
    #[Route('/hrmsystem/employees_asset_setup', name: 'hrmsystem/employees_asset_setup')]
    public function employeesAssetSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/employeesAssetSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
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
    #[Route('/hrmsystem/hrm_system_setup', name: 'hrmsystem/hrm_system_setup')]
    public function hrmSystemSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('hrmsystem/hrmSystemSetup.html.twig', [
            'controller_name' => 'HrmsystemController',
        ]);
    }
}
