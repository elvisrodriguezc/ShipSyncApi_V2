<?php

namespace App\Events;

use App\Http\Resources\OrderformResource;
use App\Models\Orderform;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderformEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderform;
    public $action;
    public $orderformId;

    public function __construct($orderform, string $action)
    {
        $this->action = $action;
        if ($action === 'deleted') {
            $this->orderformId = is_object($orderform) ? $orderform->id : (int) $orderform;
        } else {
            $this->orderformId = (int) $orderform->id;
        }
        $this->orderform = null; // Always null to keep payload minimal, frontend will fetch it
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('orderforms'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'OrderformChanged';
    }
}
