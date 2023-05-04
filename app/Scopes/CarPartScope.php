<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CarPartScope implements Scope
{
    public function apply(
        Builder $builder,
        Model $model
    ): void
    {
        $builder->whereIn('car_part_type_id',
            [3574, 3744, 3746, 3749, 3616, 3617, 3812]
        );
    }
}
