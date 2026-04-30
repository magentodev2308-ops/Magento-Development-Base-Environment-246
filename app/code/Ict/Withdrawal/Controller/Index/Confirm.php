<?php
namespace Ict\Withdrawal\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Ict\Withdrawal\Model\WithdrawalFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class Confirm extends Action
{
    protected $withdrawalFactory;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        WithdrawalFactory $withdrawalFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->withdrawalFactory = $withdrawalFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $token = $this->getRequest()->getParam('token');

        $withdrawal = $this->withdrawalFactory->create()->load($id);

        if (!$withdrawal->getId()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        if (
            $withdrawal->getToken() === $token &&
            $withdrawal->getStatus() === 'pending'
        ) {
            $withdrawal->setStatus('submitted');
            $withdrawal->setToken(null);
            $withdrawal->save();
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}