<?php

namespace VT\VTCoreBundle\Entity;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\MappedSuperclass
 *
 */
class AbstractVitruEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="row_id", type="string", length=100)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="CREATED_BY", type="string", length=100)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="CREATED", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="LAST_UPD_BY", type="string", length=100)
     */
    private $lastUpdBy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="LAST_UPD", type="datetime")
     */
    private $lastUpd;

    /**
     * @var integer
     *
     * @ORM\Column(name="DELETED", type="integer")
     */
    private $deleted = 0;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param \DateTime $lastUpd
     */
    public function setLastUpd($lastUpd)
    {
        $this->lastUpd = $lastUpd;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpd()
    {
        return $this->lastUpd;
    }

    /**
     * @param string $lastUpdBy
     */
    public function setLastUpdBy($lastUpdBy)
    {
        $this->lastUpdBy = $lastUpdBy;
    }

    /**
     * @return string
     */
    public function getLastUpdBy()
    {
        return $this->lastUpdBy;
    }

    /**
     *
     * Utility method used to invoke getters on the POPO (plain old PHO object) instances.
     * This is useful because sometimes we need to invoke the getters on the proxy objects.
     * This method internally takes care that the object being invoked on is not a proxy object.
     * This was written because Doctrine does not have the equivalent of not-found="ignore" on MTO relations.
     * When we load a MTO relation, and that entity does not exist in the database, then doctrine returns a proxy. Even if we have marked fetch = EAGER in the MTO mapping.
     * Invoking any of the getters on this proxy leads to an infinite loop.
     * To avoid this we have decided to make all MTO relations as fetch = EAGER, and once loaded to extract values out of the loaded object using this utility method only.
     *
     * @param mixed $objectToGetOn
     * @param string $getterName
     * @param mixed null $defaultValue
     * @return mixed
     *
     */
    public static function get($objectToGetOn, $getterName, $defaultValue = null)
    {
        if (!empty($objectToGetOn)) {
            try {
                return $objectToGetOn->$getterName();
            } catch (EntityNotFoundException $e) {

            }
        }

        return $defaultValue;
    }

    /**
     *
     * Converse of the above method, has no relevance to proxy objects etc.
     * This was just written as a utility.
     *
     * @param mixed $objectToSetOn
     * @param string $setterName
     * @param mixed $valueToSet
     *
     */
    public static function set($objectToSetOn, $setterName, $valueToSet)
    {
        if (!empty($objectToSetOn)) {
            $objectToSetOn->$setterName($valueToSet);
        }
    }
}
