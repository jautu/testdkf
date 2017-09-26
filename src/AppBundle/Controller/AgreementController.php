<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agreement;
use AppBundle\Entity\CompanyRelation;
use AppBundle\Entity\Relation;
use AppBundle\Form\AgreementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AgreementController
 * @package AppBundle\Controller
 */
class AgreementController extends Controller
{

    /**
     * @Route("/agreement/{id}/detail", name="app_agreement_detail")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Request $request, $id)
    {
        $agreement = $this->getDoctrine()
            ->getRepository(Agreement::class)
            ->getById($id);

        $relations = $this->getDoctrine()
            ->getRepository(CompanyRelation::class)
            ->allByAgreement($id);

        return $this->render(
            'AppBundle:Agreement:detail.html.twig',
            [
                'dataAgreement' => $agreement,
                'dataRelations' => $relations,
            ]
        );
    }

    /**
     * @Route("/agreement/{id}/edit", name="app_agreement_edit")
     */
    public function editAction(Request $request, $id)
    {
        // -- Creación del formulario

        $entity = $this->getDoctrine()->getRepository(Agreement::class)->findOneById($id);

        $relations = $this->getDoctrine()
            ->getRepository(CompanyRelation::class)
            ->all(['agreement' => $id]);

        if ($entity instanceof Agreement) {
            $form = $this->createForm(AgreementType::class, $entity);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // -- Guardado de la entidad

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'agreement.update.ok');
            }

            return $this->render(
                'AppBundle:Agreement:edit.html.twig',
                [
                    'form' => $form->createView(),
                    'dataList' => $relations
                ]
            );
        } else {
            $request->getSession()->getFlashBag()->add('error', 'agreement.not_exit');

            return $this->redirectToRoute('app_agreement');
        }
    }

    /**
     * @Route("/agreement/filter", name="app_agreement_filter")
     */
    public function filterAction(Request $request)
    {
        $result = [];

        $items = $this->getDoctrine()
            ->getRepository(Agreement::class)
            ->all($request->request->all());

        if (!empty($items)) {
            foreach ($items as $item) {
                $result[$item->getId()] = [
                    'id' => $item->getId(),
                    'name' => $item->getName()
                ];
            }
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/", name="app_agreement")
     */
    public function landingAction(Request $request)
    {
        // -- Filtros

        $dataRelation = $this->getDoctrine()->getRepository(Relation::class)->findAll();

        $items = $this->getDoctrine()
            ->getRepository(Agreement::class)
            ->all($request->request->all());

        return $this->render(
            'AppBundle:Agreement:landing.html.twig',
            [
                'dataList' => $items,
                'dataRelation' => $dataRelation
            ]
        );
    }

    /**
     * @Route("/agreement/new", name="app_agreement_new")
     */
    public function newAction(Request $request)
    {
        // -- Creación del formulario

        $entity = new Agreement();
        $form = $this->createForm(AgreementType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // -- Guardado de la entidad

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'agreement.create.ok');

            return $this->redirectToRoute('app_agreement');
        }

        return $this->render('AppBundle:Agreement:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
