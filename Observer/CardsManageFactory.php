<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Observer;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use TrainingMonish\LoginIP\Block\Adminhtml\Dashboard\LoginLog\Grid;
use TrainingMonish\LoginIP\Helper\Data;

/**
 * Class CardsManageFactory
 * @package TrainingMonish\LoginIP\Observer
 */
class CardsManageFactory implements ObserverInterface
{
    /**
     * @var Data
     */
    public $_helperData;

    /**
     * @var AuthorizationInterface
     */
    protected $_authorization;

    /**
     * CardsManageFactory constructor.
     *
     * @param Data $data
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        Data $data,
        AuthorizationInterface $authorization
    ) {
        $this->_helperData    = $data;
        $this->_authorization = $authorization;
    }

    /**
     * @param Observer $observer
     *
     * @return Observer|void
     */
    public function execute(Observer $observer)
    {
        if ($this->_helperData->isEnabled() && $this->_authorization->isAllowed('trainingmonish_loginip::grid')) {
            $security = ['security' => Grid::class];
            $observer['cards']->addData($security);
        }

        return $observer;
    }
}
