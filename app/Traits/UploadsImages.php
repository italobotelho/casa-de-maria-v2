<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadsImages
{
    /**
     * Lida com o upload de imagem e retorna o caminho para salvar no banco.
     *
     * @param Request $request O request atual.
     * @param string $inputName O nome do campo do arquivo no form.
     * @param string $folderName O nome da pasta de destino em storage/app/public.
     * @param string $defaultImage O caminho da imagem padrão caso nenhuma seja enviada.
     * @return array Retorna o caminho da imagem e opcionalmente dados extras como angulo de rotacao.
     */
    public function uploadImage(Request $request, $inputName, $folderName, $defaultImage = 'default-profile-pic.png')
    {
        $data = [
            'path' => $folderName . '/' . $defaultImage,
            'angulo_rotacao' => 0
        ];

        if ($request->hasFile($inputName)) {
            $imagem = $request->file($inputName);
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            // Salva na pasta (ex: storage/app/public/imagens_pacientes)
            $imagem->storeAs('public/' . $folderName, $nomeImagem);

            $data['path'] = $folderName . '/' . $nomeImagem;
            $data['angulo_rotacao'] = $request->input('angulo_rotacao', 0);
        }

        return $data;
    }
}
