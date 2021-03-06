<?php

declare(strict_types=1);

namespace SousedskaPomoc\Presenters;

use SousedskaPomoc\Model\OrderManager;

final class OperatorPresenter extends BasePresenter
{
    /** @var OrderManager */
    protected $orderManager;



    public function injectOrderManager(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }



    public function renderDashboard()
    {
        $this->template->newOrders = $this->orderManager->findAllNew();
        $this->template->liveOrders = $this->orderManager->findAllLive();
        $this->template->deliveredOrders = $this->orderManager->findAllDelivered();
    }



    public function handleUpdateOrderStatus($orderId, $orderStatus)
    {
        $this->orderManager->updateStatus($orderId, $orderStatus);
        $this->flashMessage($this->translator->translate('messages.order.statusChanged'));
        $this->redirect('this');
    }



    public function handleAssignCourier()
    {
        $this->orderManager->assignOrder($_POST['courier_id'], $_POST['order_id']);
        $this->flashMessage($this->translator->translate('messages.order.givenToCourier'));
        $this->redirect('this');
    }
}
