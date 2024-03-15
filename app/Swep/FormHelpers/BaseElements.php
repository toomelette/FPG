<?php

namespace App\Swep\FormHelpers;

class BaseElements
{
    private $name,
        $label,
        $cols,
        $for;
    public function __construct(){

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


}