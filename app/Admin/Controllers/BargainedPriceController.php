<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\BargainedPrice;

class BargainedPriceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BargainedPrice';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BargainedPrice());

        $grid->column('id', __('Id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('user_id', __('User id'));
        $grid->column('price', __('Price'));
        $grid->column('approved_by', __('Approved by'));
        $grid->column('approver_id', __('Approver id'));
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
        $show = new Show(BargainedPrice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_id', __('Product id'));
        $show->field('user_id', __('User id'));
        $show->field('price', __('Price'));
        $show->field('approved_by', __('Approved by'));
        $show->field('approver_id', __('Approver id'));
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
        $form = new Form(new BargainedPrice());

        $form->text('product_id', __('Product id'));
        $form->text('user_id', __('User id'));
        $form->text('price', __('Price'));
        $form->text('approved_by', __('Approved by'));
        $form->text('approver_id', __('Approver id'));

        return $form;
    }
}
