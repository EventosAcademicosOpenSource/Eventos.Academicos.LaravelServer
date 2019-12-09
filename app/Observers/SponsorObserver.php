<?php

namespace App\Observers;

use App\Sponsor;

class SponsorObserver
{
    use UploadObserverTrait;

    protected $field = 'image';
    protected $path = 'sponsors/';
    protected $path2 = 'sponsors/thumbs/';
    protected $resize = true;
    protected $crop = false;
    protected $resize_width = 512;
    protected $resize_height = 512;
    protected $crop_width = 286;
    protected $crop_height = 180;

    public function creating(Sponsor $sponsor)
    {
        $this->sendFile($sponsor);
    }

    public function deleting(Sponsor $sponsor)
    {
        $this->removeFile($sponsor);
    }

    public function updating(Sponsor $sponsor)
    {
        $this->updateFile($sponsor);
    }
}
