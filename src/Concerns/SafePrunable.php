<?php

namespace Kyzegs\Prunable\Concerns;

use Illuminate\Database\Events\ModelsPruned;
use LogicException;

trait SafePrunable
{
    /**
     * Prune all prunable models in the database.
     *
     * @param  int  $chunkSize
     * @return int
     */
    public function pruneAll(int $chunkSize = 1000)
    {
        $total = 0;

        $this->prunable()->chunkById($chunkSize, function ($models) use (&$total) {
            $models->each->prune();

            $total += $models->count();

            event(new ModelsPruned(static::class, $total));
        });

        return $total;
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        throw new LogicException('Please implement the prunable method on your model.');
    }

    /**
     * Prune the model in the database.
     *
     * @return bool|null
     */
    public function prune()
    {
        $this->pruning();

        return $this->delete();
    }

    /**
     * Prepare the model for pruning.
     *
     * @return void
     */
    protected function pruning()
    {
        //
    }
}
