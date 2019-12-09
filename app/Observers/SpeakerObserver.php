<?php

namespace App\Observers;

use App\Speaker;

class SpeakerObserver
{
    use UploadObserverTrait;

    protected $field = 'image';
    protected $path = 'speakers/';
    protected $path2 = 'speakers/thumbs/';
    protected $resize = true;
    protected $crop = false;
    protected $resize_width = 512;
    protected $resize_height = 512;
    protected $crop_width = 286;
    protected $crop_height = 180;

    public function creating(Speaker $speaker)
    {
        $this->sendFile($speaker);
    }

    public function deleting(Speaker $speaker)
    {
        $this->removeFile($speaker);
    }

    public function updating(Speaker $speaker)
    {
        $this->updateFile($speaker);
    }
}
