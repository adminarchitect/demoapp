<?php

namespace App\Http\Terranet\Administrator\Actions\Handlers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Terranet\Administrator\Traits\Actions\ActionSkeleton;
use Terranet\Administrator\Traits\Actions\Skeleton;

class TogglePublishStatus
{
    use Skeleton, ActionSkeleton;

    /**
     * Update single entity.
     *
     * @param Eloquent $entity
     * @return mixed
     */
    public function handle(Eloquent $entity)
    {
        $entity->draft = !$entity->draft;
        $entity->save();

        return $entity;
    }

    /**
     * @param Authenticatable $user
     * @param Eloquent $entity
     * @return mixed
     */
    public function authorize(Authenticatable $user, Eloquent $entity)
    {
        return $entity->draft;
    }

    /**
     * @param Eloquent $entity
     * @return mixed
     */
    public function name(Eloquent $entity)
    {
        return $entity->draft ? 'Publish' : 'Hide';
    }
}