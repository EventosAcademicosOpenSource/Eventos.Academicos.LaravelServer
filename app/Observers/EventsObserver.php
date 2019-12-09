<?php

namespace App\Observers;

use App\Event;

class EventsObserver
{
    use UploadObserverTrait;

    protected $field = 'image';
    protected $path = 'eventos/';
    protected $path2 = 'eventos/thumbs/';
    protected $resize = true;
    protected $crop = true;
    protected $resize_width = 600;
    protected $resize_height = 390;
    protected $crop_width = 600;
    protected $crop_height = 150;

    public function creating(Event $event)
    {
        \Cache::forget('api::events');
        $this->sendFile($event);
    }

    public function deleting(Event $event)
    {
        \Cache::forget('api::events');
        $this->removeFile($event);
    }

    public function updating(Event $event)
    {
        \Cache::forget('api::events');
        $this->updateFile($event);
    }
}
