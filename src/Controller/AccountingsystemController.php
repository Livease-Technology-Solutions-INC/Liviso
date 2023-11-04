<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountingsystemController extends AbstractController
{
    #[Route('/accountingsystem/customer', name: 'accountingsystem/customer')]
    public function customer(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/customer.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/vendor', name: 'accountingsystem/vendor')]
    public function vendor(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/vendor.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/proposal', name: 'accountingsystem/proposal')]
    public function proposal(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/proposal.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/account', name: 'accountingsystem/account')]
    public function account(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/account.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/transfer', name: 'accountingsystem/transfer')]
    public function transfer(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/transfer.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/invoice', name: 'accountingsystem/invoice')]
    public function invoice(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/invoice.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/revenue', name: 'accountingsystem/revenue')]
    public function revenue(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/revenue.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/credit_note', name: 'accountingsystem/credit_note')]
    public function creditNote(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/creditNote.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/bill', name: 'accountingsystem/bill')]
    public function bill(): Response
    {
        return $this->render('accountingsystem/bill.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/payment', name: 'accountingsystem/payment')]
    public function payment(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/payment.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/debit_note', name: 'accountingsystem/debit_note')]
    public function debitNote(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/debitNote.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/chart_of_accounts', name: 'accountingsystem/chart_of_accounts')]
    public function chartOfAccounts(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/chartOfAccounts.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/journal_account', name: 'accountingsystem/journal_account')]
    public function journalAccount(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/journalAccount.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/ledger_summary', name: 'accountingsystem/ledger_summary')]
    public function ledgerSummary(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/ledgerSummary.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/balance_Sheet', name: 'accountingsystem/balance_sheet')]
    public function balanceSheet(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/balanceSheet.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/trail_balance', name: 'accountingsystem/trail_balance')]
    public function trialBalance(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/trailBalance.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/budget_planner', name: 'accountingsystem/budget_planner')]
    public function budgetPlanner(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/budgetPlanner.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/financial_goal', name: 'accountingsystem/financial_goal')]
    public function financialGoal(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/financialGoal.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/accounting_setup', name: 'accountingsystem/accounting_setup')]
    public function accountingSetup(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/accountingSetup.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
    #[Route('/accountingsystem/print_settings', name: 'accountingsystem/print_settings')]
    public function printSettings(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/printSettings.html.twig', [
            'controller_name' => 'AccountingsystemController',
        ]);
    }
}
