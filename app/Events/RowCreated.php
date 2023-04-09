<?php

namespace App\Events;

use App\Models\Row;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RowCreated implements ShouldBroadcast
{
    public Row $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('rows');
    }
}

