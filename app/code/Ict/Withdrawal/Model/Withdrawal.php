<?php
namespace Ict\Withdrawal\Model;

use Magento\Framework\Model\AbstractModel;

class Withdrawal extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Ict\Withdrawal\Model\ResourceModel\Withdrawal::class);
    }
}