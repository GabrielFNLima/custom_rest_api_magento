<?php
namespace GFNL\SimpleApi\Api\Data;

interface SimpleInterface
{
   /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);


    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $id
     * @return $this
     */
    public function setCustomerId($id);

        /**
     * @return string
     */
    public function getDescripion();

    /**
     * @param mixed $descripion
     * @return $this
     */
    public function setDescripion($descripion);

}
