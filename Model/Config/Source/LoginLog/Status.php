<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Model\Config\Source\LoginLog;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package TrainingMonish\LoginIP\Model\Config\Source\LoginLog
 */
class Status implements ArrayInterface
{
    const STATUS_FAIL    = '0';
    const STATUS_SUCCESS = '1';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::STATUS_FAIL    => __('Failed'),
            self::STATUS_SUCCESS => __('Success'),
        ];
    }
}
