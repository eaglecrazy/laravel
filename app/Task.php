<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['task'];

    public static function rules($task_id = false)
    {
        if($task_id)
            return ['task' => "required|min:2|max:150|unique:tasks,task,$task_id"];
        else
            return ['task' => "required|min:2|max:150|unique:tasks"];
    }
    public static function fieldNames()
    {
        return ['task' => '"Ресурс"'];
    }

}
