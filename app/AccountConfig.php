<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Configurações de uma conta 
 * (Ex.: Quantidade máxima de % de faltas para um aluno 
 *       não ser aprovado em um disciplina)
 */
class AccountConfig extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value', 'default'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Percentual máximo de faltas que um aluno 
     * pode ter para não ser reprovado por falta.
     * 
     * @return float
     */
    public static function getPercentageAbsencesReprove()
    {
    	$config = self::where('name', 'percentage_absences_reprove')->first();
		$value = null;
    	if ($config) {
    		$value = empty($config->value) ? $config->default : $config->value;  
    	}

    	return (float) $value;
    }
}
