<?php

namespace ElTrubetskaia\AskQuestion\Controller\Submit;

use ElTrubetskaia\AskQuestion\Api\AskQuestionRepositoryInterface;
use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use ElTrubetskaia\AskQuestion\Model\AskQuestionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;

class Index extends \Magento\Framework\App\Action\Action
{
    private const STATUS_ERROR = 'Error';

    private const STATUS_SUCCESS = 'Success';

    /**
     * @var Validator
     */
    private $formKeyValidator;

    /**
     * @var AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var AskQuestionRepositoryInterface
     */
    private $askQuestionRepository;

    /**
     * @var \ElTrubetskaia\AskQuestion\Model\Mail
     */
    protected $mail;

    /**
     * Index constructor.
     * @param Validator $formKeyValidator
     * @param AskQuestionFactory $askQuestionFactory
     * @param AskQuestionRepositoryInterface $askQuestionRepository
     * @param Context $context
     * @param \ElTrubetskaia\AskQuestion\Model\Mail $mail
     */
    public function __construct(
        Validator $formKeyValidator,
        AskQuestionFactory $askQuestionFactory,
        AskQuestionRepositoryInterface $askQuestionRepository,
        Context $context,
        \ElTrubetskaia\AskQuestion\Model\Mail $mail
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->askQuestionRepository = $askQuestionRepository;
        $this->mail = $mail;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }

            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            /** @var AskQuestion $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();
            $askQuestion->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('telephone'))
                ->setSku($request->getParam('sku'))
                ->setQuestion($request->getParam('question'));
            $this->askQuestionRepository->save($askQuestion);

            /**
             * Send Email
             */
            $email = $askQuestion->getEmail();
            $customerName = $askQuestion->getName();
            $message = $request->getParam('question');
            $this->mail->sendMail($email, $message, $customerName);

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => __('Your request was submitted. We\'ll get in touch with you as soon as possible.')
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }
}
