<?php

namespace App\Events;

use App\Motorcycle;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MotorcycleSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Motorcycle
     */
    public $motorcycle;

    /**
     * Create a new event instance.
     *
     * @param Motorcycle $motorcycle
     */
    public function __construct(Motorcycle $motorcycle)
    {
        $this->motorcycle = $motorcycle;
    }
}
