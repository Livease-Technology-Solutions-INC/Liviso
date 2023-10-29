<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsystemController extends AbstractController
{
    #[Route('/projectsystem/project', name: 'projectsystem/project')]
    public function projects(): Response
    {
        return $this->render('projectsystem/project.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/task', name: 'projectsystem/task')]
    public function task(): Response
    {
        return $this->render('projectsystem/task.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/timesheet', name: 'projectsystem/timesheet')]
    public function timesheet(): Response
    {
        return $this->render('projectsystem/timesheet.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/bug', name: 'projectsystem/bug')]
    public function bug(): Response
    {
        return $this->render('projectsystem/bug.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/Task_calendar', name: 'projectsystem/task_calendar')]
    public function taskCalendar(): Response
    {
        return $this->render('projectsystem/taskCalendar.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/Tracker', name: 'projectsystem/tracker')]
    public function tracker(): Response
    {
        return $this->render('projectsystem/tracker.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/project_report', name: 'projectsystem/project_report')]
    public function projectReport(): Response
    {
        return $this->render('projectsystem/projectReport.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/project_task_stages', name: 'projectsystem/project_task_stages')]
    public function projectSystemSetup(): Response
    {
        return $this->render('projectsystem/projectTaskStages.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
    #[Route('/projectsystem/bug_status', name: 'projectsystem/bug_status')]
    public function bugStatus(): Response
    {
        return $this->render('projectsystem/bugStatus.html.twig', [
            'controller_name' => 'ProjectsystemController',
        ]);
    }
}
