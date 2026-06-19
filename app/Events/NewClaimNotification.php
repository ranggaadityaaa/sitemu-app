<?php

namespace App\Events;

use App\Models\Claim;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewClaimNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $claim;
    public $itemOwnerId;
    public $itemTitle;

    public function __construct(Claim $claim, $itemOwnerId, $itemTitle)
    {
        $this->claim = $claim;
        $this->itemOwnerId = $itemOwnerId;
        $this->itemTitle = $itemTitle;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.' . $this->itemOwnerId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->claim->user->name . ' mengirim komentar di laporan "' . $this->itemTitle . '"',
            'item_id' => $this->claim->item_id,
        ];
    }

    public function broadcastAs()
    {
        return 'NewClaimNotification';
    }
}