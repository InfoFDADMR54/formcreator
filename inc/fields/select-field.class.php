<?php
require_once(realpath(dirname(__FILE__ ) . '/../../../../inc/includes.php'));
require_once('field.interface.php');

class selectField implements Field
{
   public static function show($field)
   {
      if($field['required'])  $required = ' required';
      else $required = '';

      echo '<div class="form-group' . $required . '" id="form-group-field' . $field['id'] . '">';
      echo '<label>';
      echo  $field['name'];
      if($field['required'])  echo ' <span class="red">*</span>';
      echo '</label>';

      if(!empty($field['values'])) {
         $values         = explode("\r\n", $field['values']);
         $tab_values     = array();
         foreach($values as $value) {
            $tab_values[$value] = $value;
         }
         $default_values = explode("\r\n", $field['default_values']);
         $default_value  = array_shift($default_values);

         if($field['show_empty'])
            array_unshift($values, array('' => '---'));

         Dropdown::showFromArray('formcreator_field_' . $field['id'], $tab_values, array(
            'value' => $default_value,
         ));

      }

      echo '</div>' . PHP_EOL;
   }

   public static function isValid($field, $input)
   {
      return true;
   }

   public static function getName()
   {
      return __('Select', 'formcreator');
   }

   public static function getJSFields()
   {
      $prefs = array(
         'required'       => 1,
         'default_values' => 1,
         'values'         => 1,
         'range'          => 0,
         'show_empty'     => 1,
         'regex'          => 0,
         'show_type'      => 1,
         'dropdown_value' => 0,
      );
      return "tab_fields_fields['select'] = 'showFields(" . implode(', ', $prefs) . ");';";
   }
}