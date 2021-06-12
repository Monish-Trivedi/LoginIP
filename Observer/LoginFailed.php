<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Observer;

use Magento\Backend\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use TrainingMonish\LoginIP\Helper\Data;
use TrainingMonish\LoginIP\Model\Config\Source\LoginLog\Status;
use TrainingMonish\LoginIP\Model\LoginLogFactory;
use TrainingMonish\LoginIP\Model\ResourceModel\LoginLog\CollectionFactory;

/**
 * Class LoginFailed
 * @package TrainingMonish\LoginIP\Observer
 */
class LoginFailed implements ObserverInterface
{
    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var Session
     */
    protected $_backendSession;

    /**
     * @var LoginLogFactory
     */
    protected $_loginLogFactory;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @var CollectionFactory
     */
    protected $_loginLogCollectionFactory;

    /**
     * LoginFailed constructor.
     *
     * @param Request $request
     * @param Session $session
     * @param LoginLogFactory $loginLogFactory
     * @param CollectionFactory $loginLogCollectionFactory
     * @param Data $helperData
     */
    public function __construct(
        Request $request,
        Session $session,
        LoginLogFactory $loginLogFactory,
        CollectionFactory $loginLogCollectionFactory,
        Data $helperData
    ) {
        $this->_request                   = $request;
        $this->_backendSession            = $session;
        $this->_loginLogFactory           = $loginLogFactory;
        $this->_helperData                = $helperData;
        $this->_loginLogCollectionFactory = $loginLogCollectionFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_helperData->isEnabled()) {
            $clientIp = $this->_request->getClientIp();
            $userName = $observer->getUserName();
            $loginLog = [
                'time'          => time(),
                'user_name'     => $userName,
                'ip'            => $clientIp,
                'browser_agent' => $this->_backendSession->getBrowserAgent(),
                'url'           => $this->_backendSession->getUrl(),
                'referer'       => $this->_backendSession->getRefererUrl(),
                'status'        => Status::STATUS_FAIL
            ];

            if ($this->_helperData->getConfigBruteForce('enabled')) {
                $failedCount        = (float) $this->_helperData->getConfigBruteForce('failed_count');
                $failedTime         = (float) $this->_helperData->getConfigBruteForce('failed_time');
                $availableTime      = date('Y-m-d H:i:s', strtotime('-' . $failedTime . ' minutes'));
                $loginLogCollection = $this->_loginLogCollectionFactory->create()
                    ->addFieldToFilter('status', Status::STATUS_FAIL)
                    ->addFieldToFilter('time', ['gteq' => $availableTime])
                    ->setOrder('id', 'DESC');

                $warningLog = $this->_loginLogFactory->create()->load(1, 'is_warning');

                if ($loginLogCollection->getSize() >= $failedCount && !$warningLog->getId()) {
                    $loginLog['is_warning'] = 1;
                }
            }
            $this->_loginLogFactory->create()->addData($loginLog)->save();
        }
    }
}
