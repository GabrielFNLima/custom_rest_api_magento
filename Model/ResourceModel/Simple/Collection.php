<?php
namespace GFNL\SimpleApi\Model\ResourceModel\Simple;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'gfnl_simpleapi_simple_collection';
	protected $_eventObject = 'simple_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('GFNL\SimpleApi\Model\Simple', 'GFNL\SimpleApi\Model\ResourceModel\Simple');
    }
}
