<?php

namespace App\Events;

use App\Models\Orders;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $order;
    public $min_days;
    public $max_days;

    public function __construct(Orders $order)
    {
        // Load the related shippingOption
        $this->order = $order->load('shippingOption');  // Eager load shippingOption relationship

        // Access min_days and max_days from the shippingOption relationship
        $this->min_days = $this->order->shippingOption ? $this->order->shippingOption->min_days : null;
        $this->max_days = $this->order->shippingOption ? $this->order->shippingOption->max_days : null;
    }

    public function broadcastOn()
    {
        return new Channel('order.' . $this->order->id);  // Broadcasting to a specific channel
    }

    public function broadcastWith()
    {
        return [
            'tracking_id' => $this->order->tracking_id,
            'status' => $this->order->order_status,
            'updated_at' => $this->order->updated_at->format('d M, Y'),
            'min_days' => $this->min_days,  // Include min_days
            'max_days' => $this->max_days,  // Include max_days
        ];
    }
}
