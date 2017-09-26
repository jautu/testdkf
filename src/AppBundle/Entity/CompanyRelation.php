<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyRelation
 *
 * @ORM\Table(name="company_relation", indexes={@ORM\Index(name="company_relation_agreement", columns={"agreement_id"}), @ORM\Index(name="company_relation_company", columns={"company_id"}), @ORM\Index(name="company_relation_relation", columns={"relation_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRelationRepository")
 */
class CompanyRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Agreement
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Agreement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agreement_id", referencedColumnName="id")
     * })
     */
    private $agreement;

    /**
     * @var \AppBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * })
     */
    private $company;

    /**
     * @var \AppBundle\Entity\Relation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Relation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="relation_id", referencedColumnName="id")
     * })
     */
    private $relation;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set agreement
     *
     * @param \AppBundle\Entity\Agreement $agreement
     *
     * @return CompanyRelation
     */
    public function setAgreement(\AppBundle\Entity\Agreement $agreement = null)
    {
        $this->agreement = $agreement;

        return $this;
    }

    /**
     * Get agreement
     *
     * @return \AppBundle\Entity\Agreement
     */
    public function getAgreement()
    {
        return $this->agreement;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return CompanyRelation
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set relation
     *
     * @param \AppBundle\Entity\Relation $relation
     *
     * @return CompanyRelation
     */
    public function setRelation(\AppBundle\Entity\Relation $relation = null)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return \AppBundle\Entity\Relation
     */
    public function getRelation()
    {
        return $this->relation;
    }
}
