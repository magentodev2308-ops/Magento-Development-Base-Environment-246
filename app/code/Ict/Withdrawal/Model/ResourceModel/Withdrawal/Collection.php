<?php
namespace Ict\Withdrawal\Model\ResourceModel\Withdrawal;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Ict\Withdrawal\Model\Withdrawal::class,
            \Ict\Withdrawal\Model\ResourceModel\Withdrawal::class
        );
    }
}