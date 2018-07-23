<?php

namespace App\Http\Terranet\Administrator\Decorators;

use Terranet\Administrator\Columns\Decorators\CellDecorator;

class UrlDecorator extends CellDecorator
{
    protected function render($row)
    {
        return '<a href="'.$row->web_site.'" target="_blank">'.$row->web_site.'</a>';
    }
}