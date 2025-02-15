<?php


use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ServiceRepository
{
    public function __construct(public string $repositoryClass)
    {
    }
}
