<?php

namespace ElTrubetskaia\CustomField\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;

class NewField extends AbstractModifier
{
    public function modifyData(array $data)
    {
        return $data;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Fieldset'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.custom_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_field_select' => $this->getCustomFieldSelect(),
                        'custom_field_text' => $this->getCustomFieldText(),
                        'custom_field_checkbox' => $this->getCustomFieldCheckbox()
                    ],
                ]
            ]
        );

        return $meta;
    }

    public function getCustomFieldSelect()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Field Select'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'visible' => 1,
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                        'options' => [
                            ['value' => '0', 'label' => __('No')],
                            ['value' => '1', 'label' => __('Yes')]
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getCustomFieldText()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Field Text'),
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                        'visible' => 1,
                    ],
                ],
            ],
        ];
    }

    public function getCustomFieldCheckbox()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'dataType' => Number::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Checkbox::NAME,
                        'componentType' => Field::NAME,
                        'label' => __('Custom Field Checkbox'),
                        'value' => '1',
                        'valueMap' => [
                            'true' => '1',
                            'false' => '0',
                        ],
                        'sortOrder' => 30,
                    ],
                ],
            ],
        ];
    }
}
