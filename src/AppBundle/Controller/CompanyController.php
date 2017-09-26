<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CompanyController
 * @package AppBundle\Controller
 */
class CompanyController extends Controller
{

    /**
     * @Route("/company/{id}/edit", name="app_company_edit")
     */
    public function editAction(Request $request, $id)
    {
        // -- Creación del formulario

        $entity = $this->getDoctrine()->getRepository(Company::class)->findOneById($id);

        if ($entity instanceof Company) {
            $form = $this->createForm(CompanyType::class, $entity);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // -- Guardado de la entidad

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'company.update.ok');

                return $this->redirectToRoute('app_company');
            }

            return $this->render(
                'AppBundle:Company:edit.html.twig',
                [
                    'form' => $form->createView()
                ]
            );
        } else {
            $request->getSession()->getFlashBag()->add('error', 'company.not_exit');

            return $this->redirectToRoute('app_company');
        }
    }

    /**
     * @Route("/company", name="app_company")
     */
    public function landingAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository(Company::class)->findAll();

        return $this->render('AppBundle:Company:landing.html.twig', [
            'dataList' => $items
        ]);
    }

    /**
     * @Route("/company/new", name="app_company_new")
     */
    public function newAction(Request $request)
    {
        // -- Creación del formulario

        $entity = new Company();
        $form = $this->createForm(CompanyType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // -- Guardado de la entidad

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'company.create.ok');

            return $this->redirectToRoute('app_company');
        }

        return $this->render('AppBundle:Company:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
