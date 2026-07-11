<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerMoved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $classroomId;
    public $playerId;
    public $position;
    public $rotation;

    public function __construct($classroomId, $playerId, $position, $rotation)
    {
        $this->classroomId = $classroomId;
        $this->playerId = $playerId;
        $this->position = $position;
        $this->rotation = $rotation;
    }

    public function broadcastOn(): array
    {
        // আপনার সেই ক্লাসরুম প্রেজেন্স চ্যানেল
        return [
            new PresenceChannel('classroom.'.$this->classroomId),
        ];
    }

    public function broadcastAs(): string
    {
        // ফ্রন্টেন্ডে লিসেন করার সহজ নাম
        return 'player.moved';
    }
}
