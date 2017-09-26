<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agreement;
use AppBundle\Entity\CompanyRelation;
use AppBundle\Entity\Relation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RelationController
 * @package AppBundle\Controller
 */
class RelationController extends Controller
{

    /**
     * @Route("/relation/filter", name="app_relation_filter")
     */
    public function filterAction(Request $request)
    {
        $result = [];

        $items = $this->getDoctrine()
            ->getRepository(CompanyRelation::class)
            ->all($request->request->all());

        if (!empty($items)) {
            foreach ($items as $item) {
                $result[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'nameCompany' => $item['nameCompany'],
                    'nameRelation' => $item['nameRelation'],
                    'nameCompanyRelation' => $item['nameCompanyRelation'],
                ];
            }
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/relation", name="app_relation")
     */
    public function landingAction(Request $request)
    {
        // -- Filtros

        $dataList = $this->getDoctrine()
            ->getRepository(CompanyRelation::class)
            ->all();
        $dataRelation = $this->getDoctrine()->getRepository(Relation::class)->findAll();

        return $this->render(
            'AppBundle:Relation:landing.html.twig',
            [
                'dataList' => $dataList,
                'dataRelation' => $dataRelation
            ]
        );
    }

    /**
     * @Route("/relation/{id}/delete", name="app_relation_delete")
     */
    public function removeAction(Request $request, $id)
    {
        $result = [
            'type' => 'error',
            'message' => 'This row has NOT been deleted.',
        ];

        $item = $this->getDoctrine()->getRepository(CompanyRelation::class)->findOneById($id);

        if ($item instanceof CompanyRelation) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($item);
            $em->flush();

            $result = [
                'type' => 'success',
                'message' => 'This row has been successfully deleted.',
            ];
        }

        return new JsonResponse($result, 200);
    }

}
