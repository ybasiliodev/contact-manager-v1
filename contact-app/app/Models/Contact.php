<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'social_number',
        'phone',
        'address',
        'address_complement',
        'lat',
        'lon'
    ];

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'social_number' => 'required|cpf|unique:contacts,social_number',
            'phone' => 'required|Celular',
            'address' => 'required|string|max:255',
            'address_complement' => 'string|max:255',
            'lat' => 'required|string',
            'lon' => 'required|string',
            'user_id' => 'required|integer'
        ];
    }

    public function feedback() {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'social_number.required' => 'O campo CPF',
            'social_number.cpf' => 'Insira um número de CPF válido',
            'social_number.unique' => 'O número de CPF já está sendo utilizado',
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.Celular' => 'Insira um número de telefone válido',
            'phone.required' => 'O campo endereço é obrigatório',
        ];
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

}
