<?php


namespace Excellence\EmailAttachment\Controller\Index;

use Excellence\EmailAttachment\Mail\Template\TransportBuilder;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\MailException;

class Index extends \Magento\Framework\App\Action\Action
{
    /**@#+
     * Test Data.
     */
    const TEST_TEMPLATE_IDENTIFIER = 'excellence_test_attachment';
    const TEST_FROM_EMAIL = 'general';
    const TEST_TO_EMAIL = 'mjoy@excellencetechnologies.in';
    const TEST_FILE_CONTENT = 'Test file content.';
    const TEST_FILE_NAME = 'test';
    const TEST_FILE_TYPE = 'txt';
    /**@#-*/

    /**
     * @var \Excellence\EmailAttachment\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * TestAttachment constructor.
     *
     * @param \Excellence\EmailAttachment\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\App\State $state
     * @param null $name
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        TransportBuilder $transportBuilder, State $state)
    {
        $this->transportBuilder = $transportBuilder;
        $this->state = $state;
        return parent::__construct($context);
    }
     
    public function execute()
    {
        try {
            // $this->state->setAreaCode(Area::AREA_FRONTEND);

            $this->transportBuilder
                ->setTemplateIdentifier(self::TEST_TEMPLATE_IDENTIFIER)
                ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => 1])
                ->setTemplateVars([])
                ->addAttachment(self::TEST_FILE_CONTENT, self::TEST_FILE_NAME, self::TEST_FILE_TYPE)
                ->setFrom(self::TEST_FROM_EMAIL)
                ->addTo(self::TEST_TO_EMAIL)
                ->getTransport()
                ->sendMessage();

            print_r(__('Everything is fine, email has been sent.'));
        } catch (MailException $me) {
            print_r(__('MailException: %1', $me->getMessage()));
        } catch (\Exception $e) {
            print_r(__('Exception: %1', $e->getMessage()));
        }
    } 
}