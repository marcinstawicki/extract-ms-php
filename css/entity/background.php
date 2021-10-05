<?php

namespace MsPhp\Css\Entity;

class Background extends SubStyle {
    protected $color;
    protected $image;
    protected $position;
    protected $size;
    protected $repeat;
    protected $origin;
    protected $clip;
    protected $attachment;
    protected $result;

    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
    public function setImage($image)
    {
        $this->image = "url('$image')";
        return $this;
    }
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
    public function setRepeat($repeat)
    {
        $this->repeat = $repeat;
        return $this;
    }
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }
    public function setClip($clip)
    {
        $this->clip = $clip;
        return $this;
    }
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
        return $this;
    }
}
