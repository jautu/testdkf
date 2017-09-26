<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Relation;

/**
 * Class CompanyRepository
 * @package AppBundle\Repository
 */
class CompanyRepository extends BaseRepository
{

    public function all($filters = [])
    {
        $params = [];

        $dql = 'SELECT c
                FROM AppBundle:Company c
                INNER JOIN AppBundle:Agreement a AS a.company = c.id
                WHERE 1 = 1';

        if (!empty($filters)) {

            // -- Filtro por texto

            $this->addClausuleTypeLike($dql, $params, 'c.name', $filters, 'q');
        }

        $dql .= ' ORDER BY c.name ASC';

        $query = $this->getEntityManager()->createQuery($dql)->setParameters($params);

        return $query->getResult();
    }

    public function allCustomers($filters = [])
    {
        $filters['relation'] = Relation::TYPE_CUSTOMER;

        return $this->allRelated($filters);
    }

    public function allProviders($filters = [])
    {
        $filters['relation'] = Relation::TYPE_PROVIDER;

        return $this->allRelated($filters);
    }

    public function allRelated($filters = [])
    {
        $params = [];

        $dql = 'SELECT c
                FROM AppBundle:Company c
                INNER JOIN AppBundle:CompanyRelation cr AS cr.company = c.id
                WHERE 1 = 1';

        if (!empty($filters)) {

            // -- Filtro por texto

            $this->addClausuleTypeLike($dql, $params, 'c.name', $filters, 'q');

            // -- Filtro por relación

            $this->addClausuleTypeIn($dql, $params, 'cr.relation', $filters, 'relation');
        }

        $dql .= ' ORDER BY c.name ASC';

        $query = $this->getEntityManager()->createQuery($dql)->setParameters($params);

        return $query->getResult();
    }

}