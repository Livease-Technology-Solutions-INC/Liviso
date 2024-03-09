<?php

namespace App\Controller;

use App\Entity\AccountingSystem\Banking\Account;
use App\Entity\AccountingSystem\Banking\Transfers;
use App\Entity\AccountingSystem\Income\Revenue;
use App\Entity\User;
use App\Form\AccountingSystem\Banking\AccountType;
use App\Form\AccountingSystem\Banking\TransferType;
use App\Form\AccountingSystem\Income\RevenueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountingsystemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
    #[Route('/accountingsystem/account{id}', name: 'accountingsystem/account')]
    public function account(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $account = new Account();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $account->setUser($user);
        $form = $this->createForm(AccountType::class, $account, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($account);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('accountingsystem/account',  ['id' => $id]);
        }
        $repository = $this->entityManager->getRepository(account::class);
        $accounts = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/account.html.twig', [
            'controller_name' => 'AccountingsystemController',
            'accounts' => $accounts,
            'form' => $form->createView(),
        ]);
    }
    //delete account
    #[Route('/accountingsystem/account/{id}/delete/{user_id}', name: 'account_delete', methods: ["GET", "POST"])]
    public function accountDelete(account $account, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$account) {
            throw $this->createNotFoundException('account not found');
        }

        $this->entityManager->remove($account);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('accountingsystem/account', ['id' => $user_id]);
    }

    // edit appraisal
    #[Route("/accountingsystem/account/{id}/edit/{user_id}", name: "account_edit", methods: ["GET", "PUT", "POST"])]
    public function accountEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Account::class);
        $account = $repository->find($id);

        if (!$account) {
            throw $this->createNotFoundException('account not found');
        }

        $form = $this->createForm(AccountType::class, $account,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $account = $form->getData();
                $this->entityManager->persist($account);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('accountingsystem/account', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(account::class);
        $accounts = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/account.html.twig', [
            'controllername' => 'HrmsystemController',
            'form' => $form->createView(),
            'accounts' => $accounts,
        ]);
    }

    #[Route('/accountingsystem/transfer{id}', name: 'accountingsystem/transfer')]
    public function transfer(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $transfer = new Transfers();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $transfer->setUser($user);
        $form = $this->createForm(TransferType::class, $transfer, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity only if the form is submitted and valid
            $this->entityManager->persist($transfer);
            $this->entityManager->flush();

            // Redirect after successful form submission (optional)
            return $this->redirectToRoute('accountingsystem/transfer',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(Transfers::class);
        $transfers = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/transfer.html.twig', [
            'controller_name' => 'AccountingsystemController',
            'transfers' => $transfers,
            'form' => $form->createView(),
        ]);
    }

    //delete transfer
    #[Route('/accountingsystem/transfer/{id}/delete/{user_id}', name: 'accounting_transfer_delete', methods: ["GET", "POST"])]
    public function transferDelete(Transfers $transfer, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$transfer) {
            throw $this->createNotFoundException('transfer not found');
        }

        $this->entityManager->remove($transfer);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('accountingsystem/transfer', ['id' => $user_id]);
    }

    // edit appraisal
    #[Route("/accountingsystem/transfer/{id}/edit/{user_id}", name: "transfer_edit", methods: ["GET", "PUT", "POST"])]
    public function transferEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(Transfers::class);
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

                // Redirect after successful form submission
                return $this->redirectToRoute('accountingsystem/transfer', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(transfers::class);
        $transfers = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/transfer.html.twig', [
            'controllername' => 'AccountingsystemController',
            'form' => $form->createView(),
            'transfers' => $transfers,
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
    #[Route('/accountingsystem/revenue{id}', name: 'accountingsystem/revenue')]
    public function revenue(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $revenue = new Revenue();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $revenue->setUser($user);
        $form = $this->createForm(RevenueType::class, $revenue, ['current_user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get(key: 'revenue')['paymentReceipt']?? null;
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('support_dir'),
                        $fileName
                    );
                } catch (\Exception $e) {
                    $this->addFlash('error', 'There was an issue with the image');
                    return $this->redirectToRoute('revenue');
                }
                $revenue->setPaymentReceipt($fileName);
            }

            $this->entityManager->persist($revenue);
            $this->entityManager->flush();

            // Redirect after successful form submission
            return $this->redirectToRoute('accountingsystem/revenue',  ['id' => $id]);
        }

        $repository = $this->entityManager->getRepository(revenue::class);
        $revenues = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/revenue.html.twig', [
            'controller_name' => 'AccountingsystemController',
            'revenues' => $revenues,
            'form' => $form->createView(),
        ]);
    }
    //delete revenue
    #[Route('/accountingsystem/revenue/{id}/delete/{user_id}', name: 'revenue_delete', methods: ["GET", "POST"])]
    public function revenueDelete(revenue $revenue, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$revenue) {
            throw $this->createNotFoundException('revenue not found');
        }

        $this->entityManager->remove($revenue);
        $this->entityManager->flush();

        return $this->redirectToRoute('accountingsystem/revenue', ['id' => $user_id]);
    }

    #[Route("/accountingsystem/revenue/{id}/edit/{user_id}", name: "revenue_edit", methods: ["GET", "PUT", "POST"])]
    public function revenueEdit(Request $request, int $id, int $user_id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->getUser();
        assert($currentUser instanceof User);
        $repository = $this->entityManager->getRepository(revenue::class);
        $revenue = $repository->find($id);

        if (!$revenue) {
            throw $this->createNotFoundException('revenue not found');
        }

        $form = $this->createForm(RevenueType::class, $revenue,  ['current_user' => $this->getUser()]);
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Persist the entity only if the form is submitted and valid
                $revenue = $form->getData();
                $this->entityManager->persist($revenue);
                $this->entityManager->flush();

                // Redirect after successful form submission (optional)
                return $this->redirectToRoute('accountingsystem/revenue', ['id' => $user_id]);
            }
        } catch (\Exception $error) {
            $this->addFlash('danger', 'An error occurred while processing the form.');
            throw $error;
        }
        $repository = $this->entityManager->getRepository(revenue::class);
        $revenues = $repository->findBy(['user' => $currentUser]);

        return $this->render('accountingsystem/edit/revenue.html.twig', [
            'controllername' => 'AccountingsystemController',
            'form' => $form->createView(),
            'revenues' => $revenues,
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
    #[Route('/accountingsystem/trial_balance', name: 'accountingsystem/trial_balance')]
    public function trialBalance(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accountingsystem/trialBalance.html.twig', [
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
