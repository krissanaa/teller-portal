<?php

namespace App\Events;

use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOnboardingRequest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $onboardingRequest;
    public int $pendingCount;

    /**
     * Create a new event instance.
     */
    public function __construct(OnboardingRequest $onboardingRequest)
    {
        $this->onboardingRequest = $onboardingRequest;
        // Capture the latest pending count so listeners can update badges without another request.
        $this->pendingCount = OnboardingRequest::where('approval_status', 'pending')->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-channel'),
        ];
    }

    /**
     * Payload sent to the client.
     */
    public function broadcastWith(): array
    {
        return [
            'onboardingRequest' => [
                'id' => $this->onboardingRequest->id,
                'store_name' => $this->onboardingRequest->store_name,
                'refer_code' => $this->onboardingRequest->refer_code,
                'approval_status' => $this->onboardingRequest->approval_status,
            ],
            'pendingCount' => $this->pendingCount,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'NewOnboardingRequest';
    }
}
