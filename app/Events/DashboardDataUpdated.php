<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class DashboardDataUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $dashboardData;

    // Pass the dashboard data to the event constructor
    public function __construct($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    // Broadcast the event on the 'dashboard' channel
    public function broadcastOn()
    {
        return new Channel('dashboard');
    }

    // Define the data to broadcast
    public function broadcastWith()
    {
        return [
            'total_orders' => $this->dashboardData['total_orders'],
            'total_revenue' => $this->dashboardData['total_revenue'],
            'total_sales' => $this->dashboardData['total_sales'],
            'total_customer' => $this->dashboardData['total_customer'],
            'revenue_by_category' => $this->dashboardData['revenue_by_category'],
            'categories' => $this->dashboardData['categories'],
            'revenues' => $this->dashboardData['revenues'],
            'revenue_by_year' => $this->dashboardData['revenue_by_year'],
        ];
    }
}
