<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */



namespace TrainingMonish\LoginIP\Block\Widget\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;
use TrainingMonish\LoginIP\Model\Config\Source\LoginLog\Status as LogStatus;

/**
 * Class Status
 * @package TrainingMonish\LoginIP\Block\Widget\Grid\Column\Renderer
 */
class Status extends AbstractRenderer
{
    /**
     * Renders grid column
     *
     * @param DataObject $row
     *
     * @return  string
     */
    public function render(DataObject $row)
    {
        if ($row->getData($this->getColumn()->getIndex()) === LogStatus::STATUS_FAIL) {
            return '<div class="grid-severity-minor">' . __('Failed') . '</div>';
        }

        return '<div class="grid-severity-notice">' . __('Success') . '</div>';
    }
}
