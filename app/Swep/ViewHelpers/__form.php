<?php

namespace App\Swep\ViewHelpers;

use App\Swep\Helpers\__sanitize;
use App\Swep\Helpers\__dataType;
use Carbon\Carbon;


class __form{



    /** Default **/
    public static function textbox($class, $key, $type, $label, $placeholder, $old_val, $error_has, $error_first, $extra_attr,$self_class = null,$tooltip = null){
        if(is_object($old_val)){
            $old_value = $old_val->$key;
        }else{
            $old_value = $old_val;
        }

        $tt = '';
        if($tooltip != null){
            $tt = '<i class="fa fa-question-circle" title="'.$tooltip.'"></i>';
        }

        $error = '';
        if($error_has != ''){
            $error = 'has-error';
        }

       return '<div class="form-group col-md-'. $class .' '.$error.'">
                <label for="'. $key .'">'. $label .'</label> '.$tt.'
                <input class="form-control '.$self_class.'" id="'. $key .'" name="'. $key .'" type="'. $type .'" value="'. self::string_value($old_value) .'" placeholder="'. $placeholder .'" '. $extra_attr .'>
              </div>';

    }



    public static function textbox_numeric($class, $key, $type, $label, $placeholder, $old_value, $error_has, $error_first, $extra_attr, $class_input=null,$tooltip = null){
        $tt = '';
        if($tooltip != null){
            $tt = '<i class="fa fa-question-circle" title="'.$tooltip.'"></i>';
        }

       return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'" >
                <label for="'. $key .'" >'. $label .'</label> '.$tt.' 
                <input class="form-control priceformat '.$class_input.'" id="'. $key .'" name="'. $key .'" type="'. $type .'" value="'. __sanitize::html_attribute_encode($old_value) .'" placeholder="'. $placeholder .'" '. $extra_attr .'>
                  '. self::error_message($error_has, $error_first) .'
              </div>';

    }



    public static function select_dynamic($class, $key, $label, $old_value, $array, $var1, $var2, $error_has, $error_first, $select2, $extra_attr){
      
       return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'">
                <label for="'. $key .'">'. $label .'</label>
                <select name="'. $key .'" id="'. $key .'" class="form-control '. $select2 .'" '. $extra_attr .'>
                  <option value="">Select</option>
                  '. self::dynamic_options($array, $var1, $var2, $old_value) .'
                </select>
                '. self::error_message($error_has, $error_first) .'
              </div>';
                
    }

    public static function a_select($length, $label, $name, $array , $value, $attr, $class = null ){
        if($class != null){
            $fg_class = "fg-".$class;
            $input_class = "input-".$class;
        }else{
            $fg_class = '';
            $input_class = '';
        }

        $options = '';
        foreach ($array as $option => $val) {
            if($value === $val){
                $options = $options.'<option value="'.$val.'" selected>'.$option.'</option>';
            }else{
                $options = $options.'<option value="'.$val.'">'.$option.'</option>';
            }
        }

        return '<div class="form-group col-md-'.$length.' '.$fg_class.'" id="fg-'.$name.'">
        <label for="is_menu">'.$label.'</label>
        <select name="'.$name.'" class="form-control '.$input_class.'" '.$attr.'">
          <option value="">Select</option>
          '.$options.'
        </select>  
      </div>';
    }



    public static function select_static($class, $key, $label, $old_val, $array, $error_has, $error_first, $select2, $extra_attr,$select_class = null){
        if(is_object($old_val)){
            $old_value = $old_val->$key;
        }else{
            $old_value = $old_val;
        }

         return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'">
                  <label for="'. $key .'">'. $label .'</label>
                  <select name="'. $key .'" id="'. $key .'" class="form-control '. $select2 .'" '. $extra_attr .'>
                    <option value="">Select</option>
                    '. self::static_options($array, $old_value) .'
                  </select>
                  '. self::error_message($error_has, $error_first) .'
                </div>';

    }


    public static function textbox_password_btn($class, $name, $label, $placeholder, $old_value, $id, $error_first, $extra_attr){
        if($name == ""){
            $name = "";
        }else{
            $name = 'name="'.$name.'" ';
        }
        return '<div class="col-md-'.$class.' form-group">
                <label for="">'.$label.'</label>
                <div class="input-group">
                  <input type="password" '.$name.' placeholder="'.$placeholder.'" class="form-control" '.$extra_attr.'>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default show_pass" data-toggle="tooltip" title="Show/Hide Password" tabindex="-1">
                      <i class="fa fa-eye-slash"></i>
                    </button>
                  </span>
                </div>
              </div>';
    }


    public static function select_static2($class, $key, $label, $old_val, $array, $error_has, $error_first, $select2, $extra_attr){
        if(is_object($old_val)){
            $old_value = $old_val->$key;
        }else{
            $old_value = $old_val;
        }
      $select = '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'">
              <label for="'. $key .'">'. $label .'</label>
              <select name="'. $key .'" id="'. $key .'" class="form-control '. $select2 .'" '. $extra_attr .'>';

      if($old_value == null){
        $select .= '<option value="" selected>Select</option>';
      }else{
        $select .= '<option value="">Select</option>';
      }

      foreach ($array as $key => $value) {
        $s = '';
        if(is_array($value)){
            $select .= '<optgroup label="'.$key.'"></optgroup>';
            foreach ($value as $disp => $option){
                if($old_value == $option){
                    $s = "selected";
                }
                $select .= '<option value="'.$option.'" '.$s.' >'.$disp.'</option>' ;
            }
        }else{
            if($old_value == $value){
                $s = "selected";
            }
            $select .= '<option value="'.$value.'" '.$s.' >'.$key.'</option>' ;
        }
      }
      

      $select .= '</select></div>';


      
     return $select;
                
    }

    public static function select_year($length, $label, $name, $array , $value, $attr, $class = null ){
        if($class != null){
            $fg_class = "fg-".$class;
            $input_class = "input-".$class;
        }else{
            $fg_class = '';
            $input_class = '';
        }
        $year_now =Carbon::now()->year;
        $start_year = $year_now-8;
        $end_year =$year_now+5;


        while ($start_year <= $end_year) {
            $arr[$start_year]= $start_year;

            $start_year++;
        }
        //return print_r($arr);
        $options = '';
        foreach ($arr as $option => $val) {

            if($value == ''){
                if($val == $year_now){
                    $options = $options.'<option value="'.$val.'" selected>'.$option.'</option>';
                }
            }
            if($value === $val){
                $options = $options.'<option value="'.$val.'" selected>'.$option.'</option>';
            }else{
                if($val != $year_now){
                    $options = $options.'<option value="'.$val.'">'.$option.'</option>';
                }
            }
        }

        return '<div class="form-group col-md-'.$length.' '.$fg_class.'" id="fg-'.$name.'">
        <label for="is_menu">'.$label.'</label>
        <select name="'.$name.'" class="form-control '.$input_class.'" '.$attr.'">
          <option value="">Select</option>
          '.$options.'
        </select>  
      </div>';
    }


    public static function textarea($class, $key, $label, $old_value, $error_has, $error_first, $extra_attr, $tooltip = null){
        $tt = '';
        if($tooltip != null){
            $tt = '<i class="fa fa-question-circle" title="'.$tooltip.'"></i>';
        }

       return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'">
                <label for="'. $key .'">'. $label .'</label> '.$tt.'
                <textarea class="form-control" id="editor" name="'. $key .'" rows="5" '. $extra_attr .'>'. __sanitize::html_encode($old_value) .'</textarea>
                '. self::error_message($error_has, $error_first) .'
              </div>';

    }



    public static function datepicker($class, $key, $label, $old_value, $error_has, $error_first){

       $old_value = __dataType::date_parse($old_value, 'm/d/Y');

       return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'" style="overflow:hidden;">
                <label for="'. $key .'">'. $label .'</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input id="'. $key .'" name="'. $key .'" value="'. __sanitize::html_attribute_encode($old_value) .'" type="text" class="form-control datepicker" placeholder="mm/dd/yy" autocomplete="off">
                </div>
                '. self::error_message($error_has, $error_first) .'
              </div>';

    }



    public static function timepicker($class, $key, $label, $old_value, $error_has, $error_first){

       return '<div class="col-md-'. $class .' bootstrap-timepicker">
                <div class="form-group '. self::error_response($error_has) .'">
                  <label>'. $label .'</label>
                  <div class="input-group">
                    <input id="'. $key .'" name="'. $key .'" value="'. __sanitize::html_attribute_encode($old_value) .'" type="text" class="form-control timepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  '. self::error_message($error_has, $error_first) .'
                </div>
              </div>';

    }



    public static function file($class, $key, $label, $error_has, $error_first, $extra_attr){

       return '<div class="form-group col-md-'. $class .' '. self::error_response($error_has) .'">
                <label for="'. $key .'">'. $label .'</label>
                <div class="file-loading">
                  <input class="file" name="'. $key .'" id="'. $key .'" type="file" '. $extra_attr .' multiple >
                </div>
                '. self::error_message($error_has, $error_first) .'
              </div>';

    }




    /** Inlines **/
    public static function textbox_inline($key, $type, $label, $placeholder, $old_value, $error_has, $error_first, $extra_attr){

       return '<div class="form-group '. self::error_response($error_has) .'">
                  <label for="'. $key .'" class="col-sm-2 control-label">'. $label .'</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="'. $key .'" id="'. $key .'" type="'. $type .'" value="'. __sanitize::html_attribute_encode($old_value) .'" placeholder="'. $placeholder .'" '. $extra_attr .'>
                    '. self::error_message($error_has, $error_first) .'
                  </div>
                </div>';

    }



    public static function password_inline($key, $label, $placeholder, $error_has, $error_first, $extra_attr){

       return '<div class="form-group '. self::error_response($error_has) .'">
                  <label for="'. $key .'" class="col-sm-2 control-label">'. $label .'</label>
                  <div class="col-sm-8">
                    <input class="form-control" name="'. $key .'" id="'. $key .'" type="password" placeholder="'. $placeholder .'" '. $extra_attr .'>
                    '. self::error_message($error_has, $error_first) .'
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                        <label>
                            <input name="show_'. $key .'" id="show_'. $key .'" type="checkbox"> Show
                        </label>
                    </div>
                  </div>
                </div>';
                
    }



    public static function select_dynamic_inline($key, $label, $old_value, $array, $var1, $var2, $error_has, $error_first, $select2, $extra_attr){
      
       return '<div class="form-group '. self::error_response($error_has) .'">
                <label for="'. $key .'" class="col-sm-2 control-label">'. $label .'</label>
                <div class="col-sm-10">
                  <select name="'. $key .'" id="'. $key .'" class="form-control '. $select2 .'" '. $extra_attr .'>
                    <option value="">Select</option>
                    '. self::dynamic_options($array, $var1, $var2, $old_value) .'
                  </select>
                  '. self::error_message($error_has, $error_first) .'
                </div>
              </div>';
                
    }





    /** For Filters **/

    public static function select_static_for_filter($class, $key, $label, $old_value, $array, $form, $select2, $extra_attr){
      
      $string = "'";

       return '<div class="form-group col-md-'. $class .'">
                <label for="'. $key .'">'. $label .'</label>
                <select name="'. $key .'" id="'. $key .'" class="form-control input-md '. $select2 .'" onchange="document.getElementById('. $string .''. $form .''. $string .').click()" '. $extra_attr .'>
                  <option value="">Select</option>
                  '. self::static_options($array, $old_value) .'
                </select>
              </div>';
                
    }




    public static function select_dynamic_for_filter($class, $key, $label, $old_value, $array, $var1, $var2, $form, $select2, $extra_attr){
      
      $string = "'";

       return '<div class="form-group col-md-'. $class .'">
                <label for="'. $key .'">'. $label .'</label>
                <select name="'. $key .'" id="'. $key .'" class="form-control input-md '. $select2 .'" onchange="document.getElementById('. $string .''. $form .''. $string .').click()" '. $extra_attr .'>
                  <option value="">Select</option>
                  '. self::dynamic_options($array, $var1, $var2, $old_value) .'
                </select>
              </div>';
                
    }
    




    /** For Dynamic Tables **/

    public static function textbox_for_dt($name, $placeholder, $value, $error_first,$type = 'text'){

       return '<div class="form-group">
                  <input type="'.$type.'" name="'. $name .'" class="form-control" placeholder="'. $placeholder .'" value="'. __sanitize::html_attribute_encode($value) .'">
                  <small class="text-danger">'. $error_first .'</small>
                </div>';

    }




    public static function textbox_numeric_for_dt($name, $placeholder, $value, $error_first){

       return '<div class="form-group">
                  <input type="text" name="'. $name .'" class="form-control priceformat" placeholder="'. $placeholder .'" value="'. __sanitize::html_attribute_encode($value) .'">
                  <small class="text-danger">'. $error_first .'</small>
                </div>';

    }




    public static function datepicker_for_dt($name, $value, $error_first){

       $value = __dataType::date_parse($value, 'm/d/Y');

       return '<div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input name="'. $name .'" type="text" class="form-control datepicker" placeholder="mm/dd/yy" value="'. __sanitize::html_attribute_encode($value) .'">
                  </div>
                  <small class="text-danger">'. $error_first .'</small>
                </div>';

    }




    public static function select_static_for_dt($name, $array, $value, $error_first){

       return '<div class="form-group">
                  <select name="'. $name .'" class="form-control">
                    <option value="">Select</option>
                    '. self::static_options($array, $value) .'
                  </select>
                  <small class="text-danger">'. $error_first .'</small>
                </div>';

    }




    /** UTILITY METHODS **/ 


    public static function string_value($value){

        $value = isset($value) ? $value : '';
        return $value;

    }


    public static function error_response($error_has){

      return $error_has ? 'has-error' : '';

    }



    public static function error_message($error_has, $error_first){

      if($error_has){

        return '<p class="help-block"> '. $error_first .' </p>';

      }

    }



    public static function static_options($array, $old_value){

      $string = '';

      foreach($array as $item => $value){

        $condition = $value == $old_value ? 'selected' : '';

        $string .= '<option value="'. $value .'" '. $condition .'>'. $item .'</option>';

      }

      return $string;

    }



    public static function dynamic_options($array, $var1, $var2, $old_value){

      $string = '';

      if(is_object($array)){
          foreach($array as $value){

              $condition = $value->$var1 == $old_value ? 'selected' : '';

              $string .= '<option value="'. $value->$var1 .'" '. $condition .'>'. $value->$var2 .'</option>';

          }
      }

      if(is_array($array)){
          foreach($array as $key => $value){

              $condition = $key == $old_value ? 'selected' : '';

              $string .= '<option value="'. $key .'" '. $condition .'>'. $value .'</option>';

          }
      }

      return $string;

    }

    public static function textbox_icon($class, $key, $type, $label, $placeholder, $old_value, $id, $error_first, $extra_attr){

        if($id == ""){
            $id = "";
        }else{
            $id= 'id = "'.$id.'"';
        }

        return '<div class="form-group col-md-'. $class .'">
              <label for="'. $key .'">'. $label .'</label>
              <div class="input-group">  
                <input class="form-control with-icon" '. $id .' name="'. $key .'" type="'. $type .'" value="'. self::string_value($old_value) .'" placeholder="'. $placeholder .'" '. $extra_attr .'>
                <span class="input-group-addon"><i class="fa '.$old_value.'"></i></span>
              </div></div>';

    }




}