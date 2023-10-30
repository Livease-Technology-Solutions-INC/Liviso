<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report/account_statment', name: 'report/account_statement')]
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
        return $this->render('report/productStock.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/profit_&_loss', name: 'report/profit_&_loss')]
    public function profitAndLoss(): Response
    {
        return $this->render('report/profitAndLoss.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/Transaction', name: 'report/transaction')]
    public function Transaction(): Response
    {
        return $this->render('report/Transaction.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/income_summary', name: 'report/income_summary')]
    public function incomeSummary(): Response
    {
        return $this->render('report/incomeSummary.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/expense_summary', name: 'report/expense_summary')]
    public function expenseSummary(): Response
    {
        return $this->render('report/expenseSummary.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/income_vs_expense', name: 'report/income_vs_expense')]
    public function incomeVsExpense(): Response
    {
        return $this->render('report/incomeVsExpense.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/tax_summary', name: 'report/tax_summary')]
    public function taxSummary(): Response
    {
        return $this->render('report/taxSummary.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/payroll', name: 'report/payroll')]
    public function payroll(): Response
    {
        return $this->render('report/payroll.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/leave', name: 'report/leave')]
    public function leave(): Response
    {
        return $this->render('report/leave.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/monthly_attendance', name: 'report/monthly_attendance')]
    public function monthlyAttendance(): Response
    {
        return $this->render('report/monthlyAttendance.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/lead', name: 'report/lead')]
    public function lead(): Response
    {
        return $this->render('report/lead.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/deal', name: 'report/deal')]
    public function deal(): Response
    {
        return $this->render('report/deal.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/warehouse_report', name: 'report/warehouse_report')]
    public function warehouseReport(): Response
    {
        return $this->render('report/warehouseReport.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/purchase_daily/monthly_report', name: 'report/purchase_daily/monthly_report')]
    public function purchaseDailyMonthlyReport(): Response
    {
        return $this->render('report/purchaseDailyMonthlyReport.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/report/pos_daily/monthly_report', name: 'report/pos_daily/monthly_report')]
    public function posDailyMonthlyReport(): Response
    {
        return $this->render('report/posDailyMonthlyReport.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
}
