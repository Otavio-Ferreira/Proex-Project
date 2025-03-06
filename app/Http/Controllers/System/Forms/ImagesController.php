<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Forms\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();

        // Verifica se um arquivo de imagem foi enviado
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Define o caminho para salvar a imagem
            $path = "imagens/form_{$form->id}/response_{$response->id}";

            // Salva a imagem no storage e obtém o caminho
            $imagePath = $request->file('image')->store($path, 'public');

            // Obtém a URL da imagem
            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = null; // Caso não tenha imagem
        }

        Images::create([
            "response_forms_id" => $response->id,
            "image" => $imageUrl,
            "address" => $request->address,
            "date" => $request->date,
            "description" => $request->description,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();

        $image = Images::findOrFail($id);

        // Atualiza os outros campos
        $image->address = $request->address;
        $image->date = $request->date;
        $image->description = $request->description;

        // Verifica se uma nova imagem foi enviada
        if ($request->hasFile('image')) {
            // Ajusta o caminho da imagem antiga para deletar corretamente
            $oldImagePath = str_replace('storage/', 'public/', $image->image);

            // Deleta a imagem antiga se existir
            if ($image->image && Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }

            // Define o caminho personalizado para armazenar a nova imagem
            $path = "imagens/form_{$form->id}/response_{$response->id}";

            // Salva a nova imagem no storage
            $imagePath = $request->file('image')->store($path, 'public');

            // Atualiza o campo da imagem no banco
            $image->image = "storage/" . $imagePath; // Salva o caminho corretamente no banco
        }

        // Salva as alterações no banco
        $image->save();

        return redirect()->back()->with('success', 'Imagem atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $image = Images::findOrFail($id);

        // Ajusta o caminho da imagem para exclusão
        if ($image->image) {
            $oldImagePath = str_replace('storage/', 'public/', $image->image);

            // Deleta a imagem do storage se existir
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }

        // Deleta o registro do banco
        $image->delete();

        return redirect()->back()->with('success', 'Imagem excluída com sucesso!');
    }
}
