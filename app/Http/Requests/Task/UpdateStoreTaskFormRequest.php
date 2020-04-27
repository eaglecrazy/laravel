<?php

namespace App\Http\Requests\Task;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreTaskFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//в любом случае редактирование-добавление можно делать только из адмики, посредник уже отработал
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if(isset($request->id))
            return Task::rules($request->id);
        return Task::rules();
    }

    public function attributes()
    {
        return Task::fieldNames();
    }
}
