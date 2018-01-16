<?php
namespace App\Listeners;

use App\Events\MotorcycleSaved;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMotorcycleViewsCache implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  MotorcycleSaved $event
     * @return void
     */
    public function handle(MotorcycleSaved $event)
    {
        $this->cacheShowView($event);
    }

    public function cacheShowView(MotorcycleSaved $event)
    {
        $showView = view('motorcycles.show', ['motorcycle' => $event->motorcycle->id])->render();
        \Cache::forever('views-show-' . $event->motorcycle->id, $showView);
    }
}
