<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores'; // Nome correto da tabela

    protected $fillable = [
        'empresa_id',
        'nome',
        'email',
        'cargo',
        'data_admissao',
    ];

    protected $casts = [
        'data_admissao' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
