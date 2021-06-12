<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Controller\Adminhtml\LoginLog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use TrainingMonish\LoginIP\Model\LoginLog;
use TrainingMonish\LoginIP\Model\LoginLogFactory;

/**
 * Class Edit
 * @package TrainingMonish\LoginIP\Controller\Adminhtml\LoginLog
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var LoginLogFactory
     */
    protected $_logFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param LoginLogFactory $logFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        LoginLogFactory $logFactory,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry          = $registry;
        $this->_logFactory       = $logFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|Redirect
     * |\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $log = $this->initLog();
        if (!$log) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('mpsecurity/loginlog/');

            return $resultRedirect;
        }

        $this->registry->register('trainingmonish_loginip_loginlog', $log);

        /** @var \Magento\Backend\Model\View\Result\Page|Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Login record details'));
        $resultPage->getConfig()->getTitle()->prepend(__('Login record details'));

        return $resultPage;
    }

    /**
     * @param bool $register
     *
     * @return bool|LoginLog
     */
    protected function initLog($register = false)
    {
        $logId = (int) $this->getRequest()->getParam('id');
        $log   = $this->_logFactory->create();

        if ($logId) {
            $log = $log->load($logId);
            if (!$log->getId()) {
                $this->messageManager->addErrorMessage(__('This log no longer exists.'));

                return false;
            }
        }

        if ($register) {
            $this->registry->register('trainingmonish_loginip_loginlog', $log);
        }

        return $log;
    }
}
