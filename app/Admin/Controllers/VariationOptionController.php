<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\VariationOption;
use \App\Models\VariationAttribute;

class VariationOptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Variation-Option';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VariationOption());

        $grid->column('id', __('Id'));
        $grid->column('variation_id', __('Variation id'));
        $grid->column('value', __('Value'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(VariationOption::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('variation_id', __('Variation id'));
        $show->field('value', __('Value'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        $form = new Form(new VariationOption());

        // Fetch variations
        $form->select('variation_id', __('Variation'))
            ->options(VariationAttribute::all()->pluck('name', 'id'))
            ->rules('required')
            ->when('2', function (Form $form) {
                $form->color('color_code', 'Color Code')->required();
            });

        $form->text('value', __('Value'))->rules('required');

        return $form;
    }

}
