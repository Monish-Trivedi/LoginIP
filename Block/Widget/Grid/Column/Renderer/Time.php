<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Block\Widget\Grid\Column\Renderer;

use DateTime;
use Exception;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

/**
 * Class Time
 * @package TrainingMonish\LoginIP\Block\Widget\Grid\Column\Renderer
 */
class Time extends AbstractRenderer
{
    /**
     * Renders grid column
     *
     * @param DataObject $row
     *
     * @return string
     * @throws Exception
     */
    public function render(DataObject $row)
    {
        return $this->timeElapsedString($row->getData($this->getColumn()->getIndex()));
    }

    /**
     * Convert to elapsed time
     *
     * @param $datetime
     * @param bool $full
     *
     * @return string
     * @throws Exception
     */
    protected function timeElapsedString($datetime, $full = false)
    {
        $now  = new DateTime();
        $ago  = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? __('%1 ago', implode(', ', $string)) : __('just now');
    }
}
