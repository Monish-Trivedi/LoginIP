<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Model\ResourceModel\LoginLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TrainingMonish\LoginIP\Model\ResourceModel\LoginLog;

/**
 * Class Collection
 * @package TrainingMonish\LoginIP\Model\ResourceModel\LoginLog
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(\TrainingMonish\LoginIP\Model\LoginLog::class, LoginLog::class);
    }
}
