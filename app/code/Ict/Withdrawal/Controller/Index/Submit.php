<?php
namespace Ict\Withdrawal\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Ict\Withdrawal\Model\WithdrawalFactory;
use Magento\Sales\Model\OrderFactory;

class Submit extends Action
{
    protected $withdrawalFactory;
    protected $orderFactory;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        WithdrawalFactory $withdrawalFactory,
        OrderFactory $orderFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->withdrawalFactory = $withdrawalFactory;
        $this->orderFactory = $orderFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();

        $orderNumber = $post['order_number'] ?? '';
        $email = $post['email'] ?? '';

        if (!$orderNumber || !$email) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $order = $this->orderFactory->create()->loadByIncrementId($orderNumber);

        if (!$order->getId() || $order->getCustomerEmail() !== $email) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $token = hash('sha256', uniqid() . $email . time());

        $withdrawal = $this->withdrawalFactory->create();
        $withdrawal->setData([
            'order_number' => $orderNumber,
            'email'        => $email,
            'token'        => $token,
            'status'       => 'pending'
        ]);
        $withdrawal->save();

        return $this->resultRedirectFactory->create()
            ->setPath('withdrawal/index/confirm', [
                'id' => $withdrawal->getId(),
                'token' => $token
            ]);
    }
}