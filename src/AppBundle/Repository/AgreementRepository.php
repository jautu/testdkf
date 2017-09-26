<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Relation;

class AgreementRepository extends BaseRepository
{

    public function all($filters = [])
    {
        $params = [
            'relationCustomer' => Relation::TYPE_CUSTOMER,
            'relationProvider' => Relation::TYPE_PROVIDER,
        ];

        $dql = 'SELECT a
                FROM AppBundle:Agreement a
                INNER JOIN AppBundle:Company c AS c.id = a.company
                LEFT JOIN AppBundle:CompanyRelation cr_c AS cr_c.agreement = a.id AND cr_c.relation = :relationCustomer
                LEFT JOIN AppBundle:CompanyRelation cr_p AS cr_p.agreement = a.id AND cr_p.relation = :relationProvider
                WHERE 1 = 1';

        if (!empty($filters)) {

            // -- Filtro por relación con clientes

            $this->addClausuleTypeIn($dql, $params, 'c.id', $filters, 'company');

            // -- Filtro por relación con clientes

            $this->addClausuleTypeIn($dql, $params, 'cr_c.company', $filters, 'companyCustomer');

            // -- Filtro por relación con proveedores

            $this->addClausuleTypeIn($dql, $params, 'cr_p.company', $filters, 'companyProvider');

        }

        $dql .= 'ORDER BY a.name ASC';

        $query = $this->getEntityManager()->createQuery($dql)->setParameters($params);

        return $query->getResult();
    }

    public function getById($id) {

        $dql = 'SELECT
                    a.name,
                    c.name AS nameCompany
                FROM AppBundle:Agreement a
                INNER JOIN AppBundle:Company c AS c.id = a.company
                WHERE a.id = :id';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);

        $item = $query->getArrayResult();

        if (count($item) > 0) {
            $item = $item[0];
        }

        return $item;
    }

}