<?php

namespace App\Swep\FormHelpers;

use Illuminate\Support\Collection;

class __select
{
    private $name,
        $label,
        $placeholder,
        $autocomplete = 'on',
        $value,
        $class,
        $containerClass,
        $cols,
        $type = 'text',
        $options,
        $disableDefault = false,
        $for;

    public static function make()
    {
        return new __select();
    }

    public function __construct()
    {

    }


    public function render(){
        $cls = new \ReflectionClass(__CLASS__);
        $toPass = new Collection();
        foreach ($cls->getProperties() as $property){
            $toPass->{$property->name} = $this->{$property->name};
        }
        return  view('helpers.select')->with([
            'thiss' => $toPass,
        ]);
    }

    public function disableDefault(){
        $this->disableDefault = true;
        return $this;
    }

    public function options(array $array){
        $this->{__FUNCTION__} = $array;
        return $this;
    }

    public function for($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }
    public function cols($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }
    public function label($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }
    public function name($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }

    public function value($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }
    public function type($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }

    public function placeholder($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }

    public function autocomplete($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }
    public function class($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }

    public function containerClass($value)
    {
        $this->{__FUNCTION__} = $value;
        return $this;
    }


}