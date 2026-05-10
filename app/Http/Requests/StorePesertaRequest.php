<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $peserta = $this->route('peserta');

        $fotoRules = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];

        // foto_formal is required for new participants or if an existing participant does not have one.
        if ($this->isMethod('post') || ($peserta && !$peserta->foto_formal)) {
            $fotoRules = ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        return [
            'nama_peserta' => ['required', 'string', 'max:255'],
            'hp_peserta' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'string', 'in:L,P'],
            'kelas' => ['required', 'string', 'max:255'],
            'nama_ortu' => ['required', 'string', 'max:255'],
            'hp_ortu' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/'],
            'nama_pengawas' => ['required', 'string', 'max:255'],
            'hp_pengawas' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/'],
            'tema_pidato' => ['required', 'string', 'max:1000'],
            'jenjang' => ['required', 'string', 'in:SMP/MTS,SMA/MA'],
            'alamat' => ['required', 'string', 'max:500'],
            'foto_formal' => $fotoRules,
        ];
    }

    /**
     * Get the custom validation messages for the defined rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tanggal_lahir.before' => 'Tanggal Lahir harus sebelum hari ini.',
            'hp_peserta.regex' => 'Format No. HP tidak valid. Awali dengan 08 dan berisi 10-13 digit.',
            'hp_ortu.regex' => 'Format No. HP Orang Tua tidak valid. Awali dengan 08 dan berisi 10-13 digit.',
            'hp_pengawas.regex' => 'Format No. HP Official tidak valid. Awali dengan 08 dan berisi 10-13 digit.',
        ];
    }
}
