<?php

namespace app\Model;

class Result
{
    public $url;

    public function __toString()
    {
        return "Result ({$this->url})";
    }
}
