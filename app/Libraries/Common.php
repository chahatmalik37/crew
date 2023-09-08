<?php namespace App\Libraries;



class Common
{
    /**
     * Get all recipes
     * @return array
     */
    public function getRecord($modelInstanceName,$modelId)
    {
        if($modelId){
        
            $modelReturn =$modelInstanceName->where('id',$modelId)->first();
        }
        else
        $modelReturn = null;
        return $modelReturn; 
    }
    public function SaveRecord($modelInstanceName,$data,$isIgnore = true)
    {
        if($modelInstanceName){
            $modelReturn = $modelInstanceName->ignore($isIgnore)->insert($data);   
           
        }
        else
        $modelReturn  = null;
        return  $modelReturn;
    }
    public function SaveRecordGetId($modelInstanceName,$data,$isIgnore = true)
    {
        if($modelInstanceName){

            $modelInstanceName->ignore($isIgnore)->insert($data);
            $insertId = $modelInstanceName->insertID();   
          
        }
        else
            $insertId=null;
        return $insertId;
    }
    public function UpdateRecord($modelInstanceName,$data,$id)
    {
        if($modelInstanceName){

            $modelReturn = $modelInstanceName->update($id,$data);
          
        }
        else
           $modelReturn =null;
        return $modelReturn;
    }
    public function DeleteRecord($modelInstanceName,$id)
    {
        if($modelInstanceName){

            $modelReturn = $modelInstanceName->delete($id);
          
        }
        else
           $modelReturn =null;
        return $modelReturn;
    }

    
    
}