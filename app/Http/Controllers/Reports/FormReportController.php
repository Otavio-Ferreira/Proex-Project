<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\FormReport;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FormReportController extends Controller
{
    public function generate(FormReport $request, $id)
    {
        // dd($request->all());
        // try {

            // Buscar o formulário
            $form = Forms::findOrFail($id);

            // Iniciar a query para buscar as respostas do formulário
            $form_responses = FormsResponse::where('forms_id', $form->id)
                ->whereIn('was_finished', $request->status);

            // Se "all" for false, aplicar filtro de projetos
            if ($request->all != "true") {
                $form_responses->whereIn('id', $request->projects);
            }

            // Carregar campos adicionais dinamicamente
            if(isset($request->additional_fields))
            foreach ($request->additional_fields as $field) {
                $form_responses->with($field);
            }

            // Obter os dados
            $responses = $form_responses->get();

            // Preparar os dados para a view
            $data = [
                'form' => $form,
                'responses' => $responses,
            ];

            $pdf = Pdf::loadView('pdf.form_general_report', $data)
                ->setPaper('a4', 'landscape');

            return $pdf->download('form_general_report.pdf');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with("toast_error", "Erro ao gerar o relatório em PDF. Por favor, tente novamente mais tarde.");
        // }
    }
}
