<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class BaseRepository
 * @package ApiRestBundle\Repository
 */
class BaseRepository extends EntityRepository
{

    /**
     * @param $dql
     * @param $params
     * @param $dqlField
     * @param $filters
     * @param $field
     */
    protected function addClausuleTypeIn(&$dql, &$params, $dqlField, $filters, $field)
    {
        if (isset($filters[$field]) && !empty($filters[$field])) {
            $dql .= ' AND '.$dqlField.' IN (';

            if (is_array($filters[$field])) {
                foreach ($filters[$field] as $keyFilter => $valueFilter) {
                    $dql .= ':'.$field.$keyFilter;

                    if ($keyFilter < count($filters[$field]) - 1) {
                        $dql .= ', ';
                    }

                    $params[$field.$keyFilter] = $valueFilter;
                }
            } else {
                $dql .= ':'.$field;
                $params[$field] = $filters[$field];
            }

            $dql .= ')';
        }
    }

    /**
     * @param $dql
     * @param $params
     * @param $dqlFields
     * @param $filters
     * @param $field
     */
    protected function addClausuleTypeLike(&$dql, &$params, $dqlFields, $filters, $field)
    {
        if (isset($filters[$field]) && !empty($filters[$field])) {
            $dql .= ' AND (';

            if (!is_array($dqlFields)) {
                $dqlFields = [$dqlFields];
            }

            foreach ($dqlFields as $keyFilter => $dqlField) {
                if ($keyFilter > 0) {
                    $dql .= ' OR ';
                }

                $dql .= $dqlField.' LIKE :'.$field.$keyFilter;

                $params[$field.$keyFilter] = '%'.$filters[$field].'%';
            }

            $dql .= ')';
        }
    }

    /**
     * @param $dql
     * @param $params
     * @param $dqlField
     * @param $filters
     * @param $field
     */
    protected function addClausuleTypeNotIn(&$dql, &$params, $dqlField, $filters, $field)
    {
        if (isset($filters[$field]) && !empty($filters[$field])) {
            $dql .= ' AND '.$dqlField.' NOT IN (';

            if (is_array($filters[$field])) {
                foreach ($filters[$field] as $keyFilter => $valueFilter) {
                    $dql .= ':'.$field.$keyFilter;

                    if ($keyFilter < count($filters[$field]) - 1) {
                        $dql .= ', ';
                    }

                    $params[$field.$keyFilter] = $valueFilter;
                }
            } else {
                $dql .= ':'.$field;
                $params[$field] = $filters[$field];
            }

            $dql .= ')';
        }
    }

}
