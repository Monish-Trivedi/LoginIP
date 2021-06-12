<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class LoginLog
 * @package TrainingMonish\LoginIP\Model
 */
class LoginLog extends AbstractModel
{
    /**
     * Initialize model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel\LoginLog::class);
    }
}
