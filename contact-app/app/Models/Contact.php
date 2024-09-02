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
        'postal_code',
        'city',
        'state',
        'address',
        'address_complement',
        'lat',
        'lon',
        'user_id'
    ];

    public function rules($userId) {
        return [
            'name' => 'required|string|max:255',
            'social_number' => "required|cpf|unique:contacts,user_id,$userId",
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|celular_com_ddd',
            'postal_code' => 'required|formato_cep',
            'address' => 'required|string|max:255',
            'address_complement' => 'string|max:255|nullable',
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
            'phone.celular_com_ddd' => 'Insira um número de telefone válido',
            'postal_code.required' => 'O campo CEP é obrigatório',
            'postal_code.formato_cep' => 'Insira um número de CEP válido',
            'city.required' => 'O campo cidade é obrigatório',
            'state.required' => 'O campo estado é obrigatório',
            'address.required' => 'O campo endereço é obrigatório',
            'lat.required' => 'O campo lat é obrigatório',
            'lng.required' => 'O campo lng é obrigatório',
            'user_id.required' => 'O campo user_id é obrigatório',
        ];
    }

    protected $hidden = [
        "user_id",
        "created_at",
        "updated_at",
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

}
