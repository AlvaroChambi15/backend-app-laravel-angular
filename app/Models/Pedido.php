<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    use HasFactory;

    public function productos()
    {
        return $this->BelongsToMany(Producto::class)->withPivot("cantidad")->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}