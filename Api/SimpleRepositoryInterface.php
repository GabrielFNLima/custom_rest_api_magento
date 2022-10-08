<?php
namespace GFNL\SimpleApi\Api;

interface SimpleRepositoryInterface
{
    /**
     * @param \GFNL\SimpleApi\Api\Data\SimpleInterface $simple
     * @return int
     */
    public function save(\GFNL\SimpleApi\Api\Data\SimpleInterface $simple);

    /**
     * @param $id
     * @return \GFNL\SimpleApi\Api\Data\SimpleInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \GFNL\SimpleApi\Api\Data\SimpleSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    /**
     * @param \GFNL\SimpleApi\Api\Data\SimpleInterface $simple
     * @return \GFNL\SimpleApi\Api\Data\SimpleInterface
     */

    public function delete(\GFNL\SimpleApi\Api\Data\SimpleInterface $simple);
    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
    /**
     *@param mixed $id
     *@param mixed $argument
     *
     * @return void
     */
    public function getTest($id,$argument);

    /**
     * @param mixed $customerId
     * @return void
     */
    public function getCustomer($customerId);
        /**
     * @param mixed $customer_id
     * @param mixed $id
     * @return void
     */
    public function saveDB($customer_id,$id);
}
