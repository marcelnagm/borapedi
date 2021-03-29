<?php

namespace App\Traits;
use Akaunting\Module\Facade as Module;

trait Modules
{


    private function vendorFields($configs){
        $fields=[];
        foreach (Module::all() as $key => $module) {
            $fields=array_merge($fields,$module->get('vendor_fields'));
            //Add active field
            /*array_push($fields,[
                "title" => "Active",
                "key" => $key."_active",
                "ftype" => "bool",
                "value" => false]
            );*/
        }

        

        foreach ($fields as &$field) {
           if(isset($configs[$field['key']])){
            $field['value']=$configs[$field['key']];
           }else if(!isset($field['value'])){
            $field['value']="";
           }
        }
        return $fields;

       
        
    }
}
    