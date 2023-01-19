<?php

namespace Kyzegs\Prunable\Console\Commands;

use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Prunable;
use Kyzegs\Prunable\Concerns\SafeMassPrunable;
use Kyzegs\Prunable\Concerns\SafePrunable;

class PruneCommand extends \Illuminate\Database\Console\PruneCommand
{
    /**
     * Determine if the given model class is prunable.
     *
     * @param  string  $model
     * @return bool
     */
    protected function isPrunable($model)
    {
        $uses = class_uses_recursive($model);

        return ! empty(array_intersect($uses, [
            Prunable::class,
            MassPrunable::class,
            SafePrunable::class,
            SafeMassPrunable::class,
        ]));
    }
}
