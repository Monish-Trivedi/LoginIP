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

/**
 * Class LoginSuccess
 * @package TrainingMonish\LoginIP\Observer
 */
class LoginSuccess implements ObserverInterface
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
     * LoginSuccess constructor.
     *
     * @param Request $request
     * @param Session $session
     * @param LoginLogFactory $loginLogFactory
     * @param Data $helperData
     */
    public function __construct(
        Request $request,
        Session $session,
        LoginLogFactory $loginLogFactory,
        Data $helperData
    ) {
        $this->_request         = $request;
        $this->_backendSession  = $session;
        $this->_loginLogFactory = $loginLogFactory;
        $this->_helperData      = $helperData;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_helperData->isEnabled()) {
            $loginLog = [
                'time'          => time(),
                'user_name'     => $observer->getUser()->getUserName(),
                'ip'            => $this->_request->getClientIp(),
                'browser_agent' => $this->_backendSession->getBrowserAgent(),
                'url'           => $this->_backendSession->getUrl(),
                'referer'       => $this->_backendSession->getRefererUrl(),
                'status'        => Status::STATUS_SUCCESS
            ];
            $this->_loginLogFactory->create()->addData($loginLog)->save();
        }
    }
}
