<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Helper;

use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Error\Processor;
use Magento\Framework\View\Element\Template\File\Resolver;

require_once BP . '/pub/errors/processor.php';

/**
 * Class ErrorProcessor
 * @package TrainingMonish\LoginIP\Helper
 */
class ErrorProcessor extends Processor
{
    /**
     * @var Resolver
     */
    protected $_resolver;

    /**
     * @var string
     */
    protected $errorCode;

    /**
     * ErrorProcessor constructor.
     *
     * @param Http $response
     * @param Resolver $resolver
     */
    public function __construct(
        Http $response,
        Resolver $resolver
    ) {
        $this->_resolver = $resolver;

        parent::__construct($response);
    }

    /**
     * Process security report
     *
     * @param string $errorCode
     * @param string $reportData
     * @param string $title
     *
     * @return null
     */
    public function processSecurityReport($errorCode = '', $reportData = '', $title = '')
    {
        $this->pageTitle  = $title ?: __('You don\'t have permission to access this page');
        $this->reportData = $reportData;
        $this->errorCode  = $errorCode;

        $html = $this->_renderPage('security_report');

        $this->_response->setHttpResponseCode(401);
        $this->_response->setBody($html);
        $this->_response->sendResponse();

        return null;
    }

    /**
     * Find template path
     *
     * @param string $template
     *
     * @return string
     */
    protected function _getTemplatePath($template)
    {
        if ($template === 'security_report') {
            return $this->_resolver->getTemplateFileName(
                'report.phtml',
                ['module' => 'trainingmonish_loginip', 'area' => FrontNameResolver::AREA_CODE]
            );
        }

        return parent::_getTemplatePath($template);
    }
}
