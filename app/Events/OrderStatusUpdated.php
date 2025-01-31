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

    public function __construct(Orders $order)
    {
        $this->order = $order;
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
        ];
    }
}

