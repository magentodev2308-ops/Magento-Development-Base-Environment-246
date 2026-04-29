<?php

namespace CommerceLoyalty\CustomerLoyaltyLevelSystem\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\View\Element\Html\Select;

class TierRows extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        // Tier Activation State
        $this->addColumn('status', [
            'label' => __('Tier State'),
            'renderer' => $this->getStatusRenderer()
        ]);

        // Loyalty Tier Title
        $this->addColumn('tier_name', [
            'label' => __('Loyalty Tier Title'),
            'class' => 'required-entry'
        ]);

        // Qualification Spend
        $this->addColumn('minimum_spend', [
            'label' => __('Qualification Spend'),
            'class' => 'validate-number'
        ]);

        // Reward Rate
        $this->addColumn('reward_discount', [
            'label' => __('Reward Rate (%)'),
            'class' => 'validate-number'
        ]);

        // Retention Period
        $this->addColumn('validity_period', [
            'label' => __('Retention Period (Days)'),
            'class' => 'validate-number'
        ]);

        // Redemption Limit
        $this->addColumn('tier_cap', [
            'label' => __('Redemption Limit'),
            'class' => 'validate-number'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Loyalty Tier');
    }

    /**
     * Tier State Renderer (Active / Inactive)
     */
    private function getStatusRenderer()
    {
        $renderer = $this->getLayout()->createBlock(
            Select::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );

        $renderer->setOptions([
            ['value' => '1', 'label' => __('Active')],
            ['value' => '0', 'label' => __('Inactive')],
        ]);

        return $renderer;
    }
}