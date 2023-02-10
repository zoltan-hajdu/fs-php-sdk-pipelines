<?php
//define BaseBuilder class
namespace App\Builder;

abstract class BaseBuilder
{
    abstract public function build();

}

abstract class BaseBuilderSaleAuthorized
{

    abstract public function newbuild();
}
