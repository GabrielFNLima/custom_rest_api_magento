<?php
namespace GFNL\SimpleApi\Model\Api;

use Magento\Framework\Api\SortOrder;
use GFNL\SimpleApi\Model\SimpleFactory;
use GFNL\SimpleApi\Api\SimpleApiInterface;
use GFNL\SimpleApi\Model\ResourceModel\Simple as SimpleResource;
use GFNL\SimpleApi\Model\ResourceModel\Simple\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Controller\Result\JsonFactory;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

class Simple implements SimpleApiInterface
{
    public function __construct(
        SimpleResource                                                  $customResource,
        SimpleFactory                                                   $customFactory,
        CollectionFactory                                                $collectionFactory,
        CollectionProcessorInterface                                     $collectionProcessor,
        \GFNL\SimpleApi\Api\Data\SimpleSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Webapi\Rest\Request $requestApi,
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        ResponseInterface $response,
        \Magento\Customer\Model\Session $customer,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\CustomerFactory $customerModel,
        // \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \GFNL\SimpleApi\Model\ResourceModel\Simple\CollectionFactory $customerFactory,
        \GFNL\SimpleApi\Model\SimpleFactory $simpleFactory,
        \GFNL\SimpleApi\Helper\Data $helper
    ) {
        $this->simpleResource = $customResource;
        $this->simpleFactory = $customFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;

        $this->searchResultFactory = $searchResultsFactory;

        $this->requestApi = $requestApi;

        $this->resultJsonFactory = $resultJsonFactory;

        $this->request = $request;
        $this->response = $response;

        $this->customer = $customer;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->customerModel = $customerModel;
        $this->_customerFactory = $customerFactory;

        $this->helper = $helper;

        $this->simpleFactory=$simpleFactory;
    }

    public function methodName()
    {
        $orderBy= 'ASC'; // DESC
        if(isset($this->request->getParams()['orderBy'])){
            $orderBy = $this->request->getParams()['orderBy'];
        }
        $collection = $this->_customerFactory->create()
        ->addFieldToSelect("*")
        // ->addFieldToFilter("customer_id", array("eq" => $customerId))
        ->setOrder('created_at',$orderBy);
        // $rawContent = $this->request->getContent();

        // return $this->request->getParams()['orderBy'];
        return $collection->getData();
        // return $this->helper->encodeArray($collection->getData());
    }
}
