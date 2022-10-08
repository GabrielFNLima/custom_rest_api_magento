<?php
namespace GFNL\SimpleApi\Model;

use Magento\Framework\Api\SortOrder;
use GFNL\SimpleApi\Model\SimpleFactory;
use GFNL\SimpleApi\Api\SimpleRepositoryInterface;
use GFNL\SimpleApi\Model\ResourceModel\Simple as SimpleResource;
use GFNL\SimpleApi\Model\ResourceModel\Simple\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Controller\Result\JsonFactory;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

class SimpleRepository implements SimpleRepositoryInterface
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

    public function save(\GFNL\SimpleApi\Api\Data\SimpleInterface $simple)
    {
        try {
            if ($simple->getId()) {
                $simple = $this->getById((int) $simple->getId())->addData($simple->getData());
            }
            $this->simpleResource->save($simple);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save new simple. Error: %1', $e->getMessage()));
        }

        return $simple;
    }

    /**
     * @inheritDoc
     */
    public function getById($simpleId)
    {
        $simple = $this->simpleFactory->create();
        $this->simpleResource->load($simple, $simpleId);
        if (!$simple->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Unable to find ID "%1"', $simpleId));
        }
        return $simple;
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }


    /**
     * @inheritDoc
     */
    public function delete(\GFNL\SimpleApi\Api\Data\SimpleInterface $custom)
    {
        try {
            $this->simpleResource->delete($custom);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    public function getTest($id, $argument)
    {
        $body = $this->requestApi->getBodyParams();
        // $resultJson = $this->resultJsonFactory->create();
        // return $resultJson->setData(['json_data' => 'come from json']);
        $response = ['success' => true, 'message' => 'rawContent'];
        header("Content-Type: application/json; charset=utf-8");
        $returnArray = json_encode($response);
        // $this->response = json_encode($responseArray);
        // print_r($returnArray,false);
        // return '$argument;
        $rawContent = $this->request->getContent();
        $params = json_decode($rawContent, true);

        $response = $this->response;
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        // $response->setContent(json_encode([
        // 'status' => false,
        // 'request_params' => $this->request->getContent()
        // ]));
            return json_decode($rawContent, false)->name;
        $response->send();
        // throw new \Magento\Framework\Exception\InputException(__('Not a valid data'));
        die();
        return $returnArray;
        return json_decode(json_encode($body), true);
    }

    public function apiinvokedmethod($firstname, $secondname, $email)
    {
        return '$firstname';
    }

    public function getCustomer($customerId)
    {
        // return $this->_customerFactory->create()->load($customerId);
        // return $this->customerModel->getCollection()
        // ->addAttributeToSelect("*")
        // ->load($customerId);
        return $this->getCollectionCustomer($customerId);
        // return json_encode($this->_customerRepositoryInterface->getById($customerId)->getData());
        // return 'customer '.$customerId;
    }

    private function getCollectionCustomer($customerId)
    {
        $orderBy= 'ASC'; // DESC
        if(isset($this->request->getParams()['orderBy'])){
            $orderBy = $this->request->getParams()['orderBy'];
        }
        $collection = $this->_customerFactory->create()
        ->addFieldToSelect("*")
        ->addFieldToFilter("customer_id", array("eq" => $customerId))
        ->setOrder('created_at',$orderBy);
        // $rawContent = $this->request->getContent();

        // return $this->request->getParams()['orderBy'];
        return $collection->getData();
        // return $this->helper->encodeArray($collection->getData());
    }

    public function saveDB($customer_id,$id)
    {
                // $body=json_decode($this->request->getContent(), false);

                // $obj = $this->simpleFactory->create()->addData([
                // 'customer_id'=>$customerId,
                // 'descripion'=>$body->descripion
                // ]);
                return $customer_id .'-'.$id;
        // return $this->save($obj)->getCustomerId();
    }
}
