<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agreement;
use AppBundle\Entity\Company;
use AppBundle\Entity\Relation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommonController
 * @package AppBundle\Controller
 */
class CommonController extends Controller
{

    /**
     * @Route("/option/company/{type}", name="app_common_company")
     */
    public function companyAction(Request $request, $type)
    {
        $result = [];

        switch ($type) {
            case 'customer':
                $items = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->allCustomers($request->query->all());
                break;
            case 'provider':
                $items = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->allProviders($request->query->all());
                break;
            case 'relation':
                $items = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->allRelated($request->query->all());
                break;
            default:
                $items = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->all($request->query->all());
                break;
        }

        if (!empty($items)) {
            foreach ($items as $item) {
                $result[$item->getId()] = $item->getName();
            }
        }

        return new JsonResponse($result);
    }

}
