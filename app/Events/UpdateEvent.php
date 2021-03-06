<?php

namespace App\Events;
use Auth;
use App\Models\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UpdateEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $data)
    {
        //
        $this->user = $user;
        if (env('APP_DEBUG_NO_DEVCO') == 'true') {
           // Auth::onceUsingId(1); // TEST BRIAN
            Auth::onceUsingId(286); // TEST
            $this->user = Auth::user();
        }
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('communications.'.$this->user->id);
        return new PrivateChannel('updates.'.$this->user->id);
        Log::info('Sent info to user id '.$this->user->id);
    }
}
