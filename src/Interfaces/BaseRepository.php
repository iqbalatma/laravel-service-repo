<?php

namespace Iqbalatma\LaravelExtend;

class BaseRepository
{
    private string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function hello()
    {
        echo $this->name;
    }
}
