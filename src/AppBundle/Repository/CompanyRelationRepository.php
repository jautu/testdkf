<?php

namespace AppBundle\Repository;

/**
 * Class CompanyRelationRepository
 * @package AppBundle\Repository
 */
class CompanyRelationRepository extends BaseRepository
{

    public function all($filters = [])
    {
        $params = [];

        $dql = 'SELECT
                    a.id,
                    a.name,
                    c.name AS nameCompany,
                    c_c.name AS nameCompanyRelation,
                    cr.id AS idCompanyRelation,
                    r.id AS idRelation,
                    r.name AS nameRelation
                FROM AppBundle:Agreement a
                INNER JOIN AppBundle:Company c AS c.id = a.company
                INNER JOIN AppBundle:CompanyRelation cr AS cr.agreement = a.id
                INNER JOIN AppBundle:Company c_c AS c_c.id = cr.company
                INNER JOIN AppBundle:Relation r AS r.id = cr.relation
                WHERE 1 = 1';

        if (!empty($filters)) {

            // -- Filtro para acuerdo

            $this->addClausuleTypeIn($dql, $params, 'a.id', $filters, 'agreement');

            // -- Filtro para empresa

            $this->addClausuleTypeIn($dql, $params, 'c.id', $filters, 'company');

            // -- Filtro por empresa relationada

            $this->addClausuleTypeIn($dql, $params, 'c_c.id', $filters, 'companyRelation');

            // -- Filtro por relación con proveedores

            $this->addClausuleTypeIn($dql, $params, 'r.id', $filters, 'relation');

        }

        $dql .= 'ORDER BY a.name ASC';

        $query = $this->getEntityManager()->createQuery($dql)->setParameters($params);

        return $query->getArrayResult();
    }

    public function allByAgreement($agreement)
    {
        $dql = 'SELECT 
                    c.name AS nameCompany,
                    r.id AS idRelation
                FROM AppBundle:CompanyRelation cr
                INNER JOIN AppBundle:Company c AS c.id = cr.company
                INNER JOIN AppBundle:Relation r AS r.id = cr.relation
                WHERE cr.agreement = :agreement';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('agreement', $agreement);

        return $query->getArrayResult();
    }

}