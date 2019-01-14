<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Warehouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Warehouse controller.
 *
 */
class WarehouseController extends Controller
{
    /**
     * Lists all warehouse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $warehouses = $em->getRepository('AppBundle:Warehouse')->findAll();

        return $this->render('warehouse/index.html.twig', array(
            'warehouses' => $warehouses,
        ));
    }

    /**
     * Creates a new warehouse entity.
     *
     */
    public function newAction(Request $request)
    {
        $warehouse = new Warehouse();
        $form = $this->createForm('AppBundle\Form\WarehouseType', $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($warehouse);
            $em->flush();

            return $this->redirectToRoute('warehouse_show', array('id' => $warehouse->getId()));
        }

        return $this->render('warehouse/new.html.twig', array(
            'warehouse' => $warehouse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a warehouse entity.
     *
     */
    public function showAction(Warehouse $warehouse)
    {
        $deleteForm = $this->createDeleteForm($warehouse);

        return $this->render('warehouse/show.html.twig', array(
            'warehouse' => $warehouse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing warehouse entity.
     *
     */
    public function editAction(Request $request, Warehouse $warehouse)
    {
        $deleteForm = $this->createDeleteForm($warehouse);
        $editForm = $this->createForm('AppBundle\Form\WarehouseType', $warehouse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warehouse_edit', array('id' => $warehouse->getId()));
        }

        return $this->render('warehouse/edit.html.twig', array(
            'warehouse' => $warehouse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a warehouse entity.
     *
     */
    public function deleteAction(Request $request, Warehouse $warehouse)
    {
        $form = $this->createDeleteForm($warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($warehouse);
            $em->flush();
        }

        return $this->redirectToRoute('warehouse_index');
    }

    /**
     * Creates a form to delete a warehouse entity.
     *
     * @param Warehouse $warehouse The warehouse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Warehouse $warehouse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('warehouse_delete', array('id' => $warehouse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
