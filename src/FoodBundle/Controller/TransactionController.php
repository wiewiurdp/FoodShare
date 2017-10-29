<?php

namespace FoodBundle\Controller;

use FoodBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Transaction controller.
 *
 * @Route("transaction")
 */
class TransactionController extends Controller
{
    /**
     * Lists all transaction entities.
     *
     * @Route("/", name="transaction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $transactionsByUserId = $em->getRepository('FoodBundle:Transaction')->findFilteredOrderedByUserId($user);
        $transactionsByPoistUserId = $em->getRepository('FoodBundle:Transaction')->findFilteredOrderedByPostUserId($user);

        return $this->render('transaction/index.html.twig', array(
            'transactionsByUserId' => $transactionsByUserId,
            'transactionsByPostUserId' => $transactionsByPoistUserId,
            'user' => $this->getUser(),
        ));
    }

    /**
     * Creates a new transaction entity.
     *
     * @Route("/new", name="transaction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $transaction = new Transaction();
        $form = $this->createForm('FoodBundle\Form\TransactionType', $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return $this->redirectToRoute('transaction_show', array('id' => $transaction->getId()));
        }

        return $this->render('transaction/new.html.twig', array(
            'transaction' => $transaction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transaction entity.
     *
     * @Route("/{id}", name="transaction_show")
     * @Method("GET")
     */
    public function showAction(Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);

        return $this->render('transaction/show.html.twig', array(
            'transaction' => $transaction,
            'user' => $this->getUser(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transaction entity.
     *
     * @Route("/{id}/edit", name="transaction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);
        $editForm = $this->createForm('FoodBundle\Form\TransactionType', $transaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_edit', array('id' => $transaction->getId()));
        }

        return $this->render('transaction/edit.html.twig', array(
            'transaction' => $transaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transaction entity.
     *
     * @Route("/{id}", name="transaction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transaction $transaction)
    {
        $form = $this->createDeleteForm($transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transaction);
            $em->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }

    /**
     * Creates a form to delete a transaction entity.
     *
     * @param Transaction $transaction The transaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transaction $transaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transaction_delete', array('id' => $transaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
