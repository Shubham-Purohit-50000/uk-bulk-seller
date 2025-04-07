<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Transaction;

class TransactionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Transaction';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transaction());

        $grid->column('id', __('Id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('tnx_id', __('Tnx id'));
        $grid->column('amount', __('Amount'));
        $grid->column('status', __('Status'));
        $grid->column('payment_method', __('Payment method'));
        $grid->column('payment_provider', __('Payment provider'));
        $grid->column('payment_details', __('Payment details'));
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
        $show = new Show(Transaction::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order id'));
        $show->field('tnx_id', __('Tnx id'));
        $show->field('amount', __('Amount'));
        $show->field('status', __('Status'));
        $show->field('payment_method', __('Payment method'));
        $show->field('payment_provider', __('Payment provider'));
        $show->field('payment_details', __('Payment details'));
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
        $form = new Form(new Transaction());

        $form->number('order_id', __('Order id'));
        $form->text('tnx_id', __('Tnx id'));
        $form->decimal('amount', __('Amount'));
        $form->text('status', __('Status'));
        $form->text('payment_method', __('Payment method'));
        $form->text('payment_provider', __('Payment provider'));
        $form->textarea('payment_details', __('Payment details'));

        return $form;
    }
}
