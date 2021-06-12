<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */



namespace TrainingMonish\LoginIP\Block\Adminhtml\Loginlog;

use Magento\Backend\Block\Widget\Form\Container;

/**
 * Class Edit
 * @package TrainingMonish\LoginIP\Block\Adminhtml\Loginlog
 */
class Edit extends Container
{
    /**
     * Edit Form constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_loginlog';
        $this->_blockGroup = 'Mageplaza_Security';
        $this->_headerText = __('Login Log');

        parent::_construct();

        $this->buttonList->remove('save');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('delete');
    }
}
