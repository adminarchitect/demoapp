<?php

namespace App\Http\Terranet\Administrator\Modules;

use App\Http\Terranet\Administrator\Decorators\UrlDecorator;
use Terranet\Administrator\Columns\Element as ColumnElement;
use Terranet\Administrator\Modules\Users as CoreUsersModule;

/**
 * Administrator Users Module.
 */
class Users extends CoreUsersModule
{
    /**
     * Columns (table grid) initialisation.
     * @optional
     *
     * @return \Terranet\Administrator\Collection\Mutable
     * @throws \Terranet\Administrator\Exception
     */
    public function columns()
    {
        return $this->scaffoldColumns()
                    ->move('photo', 'after:id')
                    ->update('web_site', function (ColumnElement $column) {
                        // simple template example
                        // $column->display('<a href="mailto:(:email)" target="_blank">(:email)</a>');

                        // custom view example
                        // $column->display(view('path.to.custom.view'));

                        // custom decorator example
                        return $column->display(new UrlDecorator('web_site'));
                    })
                    ->join(['phone', 'web_site'], 'More...', 'before:is_active')
                    ->push('articles', function (ColumnElement $element) {
                        return $element->display(function () {
                            // $this points to a current row -> user
                            return link_to_route(
                                'scaffold.index',
                                trans_choice('{0}No articles|{1}:count article|[2,*] :count articles', $c = $this->articles()->count(), ['count' => $c]),
                                ['module' => 'articles', 'user_id' => $this->id]
                            );
                        });
                    });
    }

    /**
     * Define validation rules.
     * @optional
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->scaffoldRules();

        // define validation rule
        $rules['web_site'] = 'active_url';

        // append email rule
        $rules['email'] .= '|email';

        return $rules;
    }

    /**
     * Define custom validation messages.
     * @optional
     *
     * @return array
     */
    public function messages()
    {
        return [
            'active_url' => 'Please provide an active site url.',
        ];
    }

    /**
     * Since the `photo` is a dynamic field handled by Paperclip,
     * it can not be exported as a simple column.
     * So for testing purpose we just exclude it from exportable columns.
     *
     * To have more control on query while exporting, extend the `exportableQuery` method,
     * or explore the \Terranet\Administrator\Traits\ExportsCollection Trait.
     *
     * @return array
     */
    public function exportableColumns()
    {
        return array_diff(
            $this->model()->getFillable(),
            ['photo']
        );
    }
}
