<?php

namespace App\Repositories\Forms\Form;

use App\Models\Forms\Forms;
use App\Repositories\Forms\Form\FormRepository;

class EloquentFormRepository implements FormRepository
{
    public function getAllForm($request) {
        return Forms::orderBy('date', 'desc')->get();
    }

    public function getFormById($id) {
        return Forms::find($id);
    }

    public function getActualForm() {
        return Forms::where('status', '1')->first();
    }

    public function set($request)
    {
        if ($request->status == 1) {
            $forms = Forms::all();

            foreach ($forms as $form) {
                $form->status = 0;
                $form->save();
            }
        }
        Forms::create([
            "title" => $request->title,
            "date" => $request->date,
            "status" => $request->status,
        ]);
    }

    public function update($request, $id)
    {
        if ($request->status == 1) {
            $forms = Forms::all();

            foreach ($forms as $form) {
                $form->status = 0;
                $form->save();
            }
        }

        $form = Forms::find($id);
        $form->title = $request->title;
        $form->date = $request->date;
        $form->status = $request->status;

        $form->save();
    }
}
