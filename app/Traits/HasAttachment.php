<?php

namespace App\Traits;
use App\Models\Attachment;
use App\Enum\ImageTypeEnum;
trait HasAttachment
{

    public function attachments()
    {
        return $this->morphMany(Attachment::class,'attachmentable');
    }

    public function storeAttachment($data=[]){
        return $this->attachments()->create($data);
    }

    public function updateAttachment($data=[])
    {
        $this->attachments->each(function ($attachment){
            $attachment->delete();
        });
        $this->storeAttachment($data);
    }

    public function deleteAttachments()
    {

        $this->attachments()->each(function ($attachment){
            unlink(public_path($attachment->path."/".$attachment->filename));
           $attachment->delete();
        });
    }

    public function deleteAttachmentsLogo()
    {

        $this->attachments()->where('type', ImageTypeEnum::LOGO)->each(function ($attachment){
            unlink(public_path($attachment->path."/".$attachment->filename));
           $attachment->delete();
        });
    }

}
