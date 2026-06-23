<?php

namespace App\Policies;

use App\Models\Batch;
use App\Models\User;

class BatchPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Batch $batch): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Batch $batch): bool
    {
        //
    }

    public function delete(User $user, Batch $batch): bool
    {
        //
    }

    public function restore(User $user, Batch $batch): bool
    {
        //
    }

    public function forceDelete(User $user, Batch $batch): bool
    {
        //
    }
}
