<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */



namespace TrainingMonish\LoginIP\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class LoginLog
 * @package TrainingMonish\LoginIP\Block\Adminhtml
 */
class LoginLog extends Container
{
    /**
     * LoginLog constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_loginlog';
        $this->_blockGroup = 'Mageplaza_Security';
        $this->_headerText = __('Login Log');

        parent::_construct();
    }
}
