<?php
namespace Ict\Withdrawal\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Withdrawal extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ict_withdrawal', 'entity_id');
    }
}