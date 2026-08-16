<?php
namespace App\Models\Traits;

use App\Scopes\ClientScope;

trait BelongsToClient
{
    protected static function bootBelongsToClient()
    {
        static::addGlobalScope(new ClientScope);

        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->role === 'client') {
                $model->client_id = auth()->user()->client_id;
            }
        });
    }
}