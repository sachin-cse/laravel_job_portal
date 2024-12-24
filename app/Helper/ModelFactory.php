<?php 

use App as Application;

    class ModelFactory{

        // get make static models
        public static function getModels($modelName){
            $namespace = "App\\Models\\";

            $className = $namespace . $modelName;

            if(class_exists($className)){
                return App::make($className);
            }
            
            return sendAjaxRequest('error', "Model {$modelName} not found",'');

        } 
    }

    
?>