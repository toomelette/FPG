<?php

namespace App\Swep\FormHelpers;

class __textbox
{

    public static $label, $placeholder, $value, $columns, $class, $type;
    private function __construct(){

    }
    public static function render(){
        return '<div class="form-group  col-md-'.self::$columns.' '.self::$class.'">
                <label for="lastname">'.self::$label.'</label> 
                <input class="form-control " name="lastname" type="'.self::$type.'" value="'.self::$value.'" placeholder="'.(self::$placeholder ?? self::$label).'" autocomplete="">
              </div>';
    }

    public static function type($value){
        self::$type = $value;
        return new self;
    }
    public static function label($value){
        self::$label = $value;
        return new self;
    }
    public static function placeholder($value){
        self::$placeholder = $value;
        return new self;
    }
    public static function value($value){
        self::$value = $value;
        return new self;
    }
    public static function columns($value){
        self::$columns = $value;
        return new self;
    }

    public static function class($value){
        self::$class = $value;
        return new self;
    }

}