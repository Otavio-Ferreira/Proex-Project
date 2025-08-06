<?php

namespace App\Repositories\Forms\Form;

use App\Models\Forms\Forms;
use App\Repositories\Forms\Form\FormRepository;

class EloquentFormRepository implements FormRepository
{
    public function getAllForm($request)
    {
        $query = Forms::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(5);
    }


    public function getFormById($id)
    {
        return Forms::find($id);
    }

    public function getActualForm()
    {
        return Forms::where('status', '1')->first();
    }

    public function set($request)
    {
        return Forms::create([
            "title" => $request->title,
            "date" => $request->date,
            "status" => $request->status,
        ]);
    }

    public function update($request, $id)
    {
        $form = Forms::find($id);
        $form->title = $request->title;
        $form->date = $request->date;
        $form->status = $request->status;

        $form->save();
    }
}
