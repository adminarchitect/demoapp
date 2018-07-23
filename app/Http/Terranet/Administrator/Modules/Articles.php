<?php

namespace App\Http\Terranet\Administrator\Modules;

use App\Article;
use App\Tag;
use App\User;
use Terranet\Administrator\Collection\Group;
use Terranet\Administrator\Columns\Element;
use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Filters\FilterElement;
use Terranet\Administrator\Form\FormElement;
use Terranet\Administrator\Form\Type\MultiCheckbox;
use Terranet\Administrator\Form\Type\Select;
use Terranet\Administrator\Scaffolding;
use Terranet\Administrator\Traits\Module\AllowFormats;
use Terranet\Administrator\Traits\Module\AllowsNavigation;
use Terranet\Administrator\Traits\Module\HasFilters;
use Terranet\Administrator\Traits\Module\HasForm;
use Terranet\Administrator\Traits\Module\HasSortable;
use Terranet\Administrator\Traits\Module\ValidatesForm;

/**
 * Administrator Resource Articles
 *
 * @package Terranet\Administrator
 */
class Articles extends Scaffolding implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats, AllowsNavigation;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * @return array
     */
    protected function inputTypes()
    {
        // make body a wysiwyg editor
        // available: tinymce, ckeditor, markdown, medium
        return ['body' => 'markdown'];
    }

    /**
     * @return \Terranet\Administrator\Collection\Mutable
     */
    public function columns()
    {
        return $this->scaffoldColumns()
                    ->without('user_id')
                    ->push('slug', function (Element $element) {
                        return $element->display(function ($row) {
                            $url = url($row->slug);

                            return '<a href="'.$url.'">/'.$row->slug.'.html';
                        });
                    })
                    ->update('title', function (Element $element) {
                        $element->setStandalone(true);
                    })
                    ->join(['title', 'slug'], 'article', 'after:id')
                    ->group('user', function (Group $element) {
                        $element
                            ->push(new Element('user_id'))
                            ->push(new Element('user.phone'))
                            ->push(new Element('user.web_site'));
                    });
    }

    /**
     * @return mixed|\Terranet\Administrator\Form\Collection\Mutable
     * @throws \Terranet\Administrator\Exception
     */
    public function form()
    {
        return $this->scaffoldForm()
                    ->update('user_id', function (FormElement $element) {
                        // BelongsTo Relation
                        $selectInput = new Select('user_id');
                        $selectInput->setOptions(User::pluck('name', 'id'));
                        $element->setInput($selectInput);
                    })
                    ->create(FormElement::multiCheckbox('tags.tag_id'), function (FormElement $element) {
                        $element->getInput()->setStyle(['width' => '100px;']);
                        $element->getInput()->setOptions(Tag::pluck('title', 'id')->toArray());
                    });
    }

    /**
     * @return array|\Terranet\Administrator\Form\Collection\Mutable
     */
    public function filters()
    {
        return $this->scaffoldFilters()
                    ->push(FilterElement::select('user_id', [], ['' => '--Any--'] + User::pluck('name', 'id')->toArray()));
    }
}