<?php

namespace App\Http\Terranet\Administrator\Actions;

use App\Http\Terranet\Administrator\Actions\Handlers\TogglePublishStatus;
use Terranet\Administrator\Services\CrudActions;

class Articles extends CrudActions
{
    public function actions()
    {
        return [
             TogglePublishStatus::class
        ];
    }

    public function batchActions()
    {
        return array_merge(parent::batchActions(), [
            // CustomAction::class
        ]);
    }
}