<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Plugin;

use Magento\Backend\Model\Session;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\HTTP\Header;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Framework\UrlInterface;
use TrainingMonish\LoginIP\Helper\Data;
use TrainingMonish\LoginIP\Helper\ErrorProcessor;

/**
 * Class Login
 * @package TrainingMonish\LoginIP\Plugin
 */
class Login
{
    const ERROR_CODE = 'trainingmonish_loginip_401';

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var RedirectInterface
     */
    protected $_redirect;

    /**
     * @var Session
     */
    protected $_backendSession;

    /**
     * @var Header
     */
    protected $_header;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var ErrorProcessor
     */
    protected $errorHelper;

    /**
     * Login constructor.
     *
     * @param Data $helper
     * @param RedirectInterface $redirect
     * @param Session $session
     * @param Header $header
     * @param UrlInterface $urlInterface
     * @param Request $request
     * @param ErrorProcessor $errorHelper
     */
    public function __construct(
        Data $helper,
        RedirectInterface $redirect,
        Session $session,
        Header $header,
        UrlInterface $urlInterface,
        Request $request,
        ErrorProcessor $errorHelper
    ) {
        $this->_helper         = $helper;
        $this->_redirect       = $redirect;
        $this->_backendSession = $session;
        $this->_header         = $header;
        $this->_urlInterface   = $urlInterface;
        $this->_request        = $request;
        $this->errorHelper     = $errorHelper;
    }

    /**
     * @param \Magento\Backend\Controller\Adminhtml\Auth\Login $login
     * @param $page
     *
     * @return null
     */
    public function afterExecute(\Magento\Backend\Controller\Adminhtml\Auth\Login $login, $page)
    {
        if ($this->_helper->isEnabled() && ($login->getRequest()->getModuleName() !== 'mpsecurity')) {
            $this->_backendSession->setRefererUrl($this->_redirect->getRefererUrl());
            $this->_backendSession->setBrowserAgent(
                $this->_helper->getBrowser($this->_header->getHttpUserAgent())
                . '--' . $this->_header->getHttpUserAgent()
            );
            $this->_backendSession->setUrl($this->_urlInterface->getCurrentUrl());

            $clientIps = array_filter(array_map('trim', explode(',', $this->_request->getClientIp())));

            //check Black List
            $isBlackList = false;
            $blackList   = $this->_helper->getConfigBlackWhiteList('black_list');
            if ($blackList) {
                $blackList = explode(',', $blackList);
                foreach ($blackList as $item) {
                    foreach ($clientIps as $clientIp) {
                        if ($this->_helper->checkIp($clientIp, $item)) {
                            $isBlackList = true;
                            break;
                        }
                    }
                    if ($isBlackList === true) {
                        break;
                    }
                }
            }
            if ($isBlackList) {
                return $this->errorReport();
            }

            //check White List
            $isWhiteList = false;
            $whiteList   = $this->_helper->getConfigBlackWhiteList('white_list');
            if ($whiteList) {
                $whiteList = explode(',', $whiteList);
                foreach ($whiteList as $item) {
                    foreach ($clientIps as $clientIp) {
                        if ($this->_helper->checkIp($clientIp, $item)) {
                            $isWhiteList = true;
                            break;
                        }
                    }
                    if ($isWhiteList === true) {
                        break;
                    }
                }
            } else {
                $isWhiteList = true;
            }
            if (!$isWhiteList) {
                return $this->errorReport();
            }
        }

        return $page;
    }

    /**
     * @return null
     */
    protected function errorReport()
    {
        return $this->errorHelper->processSecurityReport(self::ERROR_CODE, __('Your IP has been blocked.'));
    }
}
