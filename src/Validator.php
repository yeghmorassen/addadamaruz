<?php

namespace Yeghmorassen\Addadamaruz;

use Illuminate\Validation\Validator as nativeValidator;
use Illuminate\Support\Str;

class Validator extends nativeValidator{

  /**
   * Replace all error message place-holders with actual values.
   *
   * @param  string  $message
   * @param  string  $attribute
   * @param  string  $rule
   * @param  array   $parameters
   * @return string
   */
  public function makeReplacements($message, $attribute, $rule, $parameters)
  {

    $displayableAttribute = $this->getDisplayableAttribute($attribute);

      $message = $this->replaceAttributePlaceholder(
          $message, $displayableAttribute
      );

      $message = $this->replaceInputPlaceholder($message, $attribute);

      if (isset($this->replacers[Str::snake($rule)])) {
          return $this->callReplacer($message, $attribute, Str::snake($rule), $parameters, $this);
      } elseif (method_exists($this, $replacer = "replace{$rule}")) {
          return $this->$replacer($message, $attribute, $rule, $parameters);
      }

      return $message;
  }

  /**
   * Replace the :attribute placeholder in the given message.
   *
   * @param  string  $message
   * @param  string  $value
   * @return string
   */
  protected function replaceAttributePlaceholder($message, $value)
  {
    if(is_array($value)){
      if(preg_match("#:attribute-am#i", $message) && count($value) > 1){
        return preg_replace("#:attribute-am#i", $value[1], $message);
      } else {
        return preg_replace("#:attribute(-am)?#i", $value[0], $message);
      }
    } else {
      return preg_replace("#:attribute(-am)?#i", $value, $message);
    }
  }
}
