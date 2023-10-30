<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report/account_statment', name: 'report/account_statment')]
    public function accountStatment(): Response
    {
        return $this->render('report/accountStatment.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/invoice_summary', name: 'report/invoice_summary')]
    public function invoiceSummary(): Response
    {
        return $this->render('report/invoiceSummary.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/bill_summary', name: 'report/bill_summary')]
    public function billSummary(): Response
    {
        return $this->render('report/billSummaryhtml.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/product_stock', name: 'report/product_stock')]
    public function productStock(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/profit_&_loss', name: 'app_report')]
    public function profitAndLoss(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/Transaction', name: 'app_report')]
    public function Transaction(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/income_summary', name: 'app_report')]
    public function incomeSummary(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/expense_summary', name: 'app_report')]
    public function expenseSummary(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/income_vs_expense', name: 'app_report')]
    public function incomeVsExpense(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/tax_summary', name: 'app_report')]
    public function taxSummary(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/payroll', name: 'app_report')]
    public function payroll(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/leave', name: 'app_report')]
    public function leave(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/monthly_attendance', name: 'app_report')]
    public function monthlyAttendance(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/lead', name: 'app_report')]
    public function lead(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/deal', name: 'app_report')]
    public function deal(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/warehouse_report', name: 'app_report')]
    public function warehouseReport(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/purchase_daily/monthly_report', name: 'app_report')]
    public function purchaseDailyMonthlyReport(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/pos_daily/monthly_report', name: 'app_report')]
    public function posDailyMonthlyReport(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
}
