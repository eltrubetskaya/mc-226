<?php
namespace ElTrubetskaia\AskQuestion\Model\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Config value backend model.
 */
class Enabled extends Value
{
    /**
     * Path to field ask a question module enabled into config structure.
     */
    const XML_PATH_ASK_QUESTION_ENABLED = 'ask_question/general/enable';

    /**
     * Path to field ask a question cron enabled into config structure.
     */
    const XML_PATH_ASK_QUESTION_AUTO_CONFIRMING_ENABLED = 'ask_question/cron/enable_auto_confirming';

    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param WriterInterface $configWriter
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        WriterInterface $configWriter,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->configWriter = $configWriter;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Add additional handling after config value was saved.
     *
     * @return Value
     * @throws LocalizedException
     */
    public function afterSave()
    {
        try {
            if ($this->isValueChanged()) {
                if (!$this->getValue()) {
                    $this->configWriter->delete(Cron::CRON_SCHEDULE_PATH);
                }
            }
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
            throw new LocalizedException(__('There was an error save new configuration value.'));
        }

        return parent::afterSave();
    }
}
