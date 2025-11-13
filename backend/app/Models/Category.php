<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'color',
        'icon',
    ];

    /**
     * Los atributos que deben ser casteados.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Una categoría tiene muchas tareas
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
