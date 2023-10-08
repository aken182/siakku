<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PenyusutanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'inventaris' => 'required',
            'cek_penyusutan' => 'required',
        ];

        if ($this->input('cek_penyusutan') === 'penyesuaian') {
            $rules['id_penyusutan_penyesuaian'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'inventaris.required' => 'Data inventaris wajib dipilih!',
            'cek_penyusutan.required' => 'Jenis penyusutan wajib dipilih!',
            'id_penyusutan_penyesuaian.required_if' => 'Nomor transaksi penyesuaian penyusutan wajib dipilih!'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
