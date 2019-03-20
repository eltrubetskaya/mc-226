<?php

namespace ElTrubetskaia\AskQuestion\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Mail extends AbstractHelper
{
    /**
     * Path to field ask a question module enabled emails sending.
     */
    private const XML_PATH_ASK_QUESTION_ENABLED_EMAIL_SENDING = 'ask_question/general/enable_emails_sending';

    /**
     * Path to field a customer support - sender email.
     */
    private const XML_PATH_STORE_SUPPORT_EMAIL = 'trans_email/ident_support/email';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Mail constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    /**
     * @param $emailFrom
     * @param $message
     * @param string $customerName
     *
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendMail($emailFrom, $message, $customerName = ''): void
    {
        $templateVars = [
            'store' => $this->storeManager->getStore(),
            'customer_name' => $customerName,
            'message'   => $message
        ];
        $from = ['email' => $emailFrom, 'name' => $customerName];
        $to = [$this->getStoreSupportEmail()];
        $this->send($from, $to, $templateVars);
    }

    /**
     * @param $from
     * @param $to
     * @param $templateVars
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function send($from, $to, $templateVars): void
    {
        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];
        $this->inlineTranslation->suspend();
        $transport = $this->transportBuilder->setTemplateIdentifier('ask_question_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    /**
     * @return boolean
     */
    public function isEnabledEmailsSending(): bool
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ASK_QUESTION_ENABLED_EMAIL_SENDING,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getStoreSupportEmail(): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STORE_SUPPORT_EMAIL,
            ScopeInterface::SCOPE_STORE
        );
    }
}
