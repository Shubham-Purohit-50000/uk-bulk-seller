<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\CartItem;
use Log;

class CartItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cart-Items';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CartItem());

        $grid->column('id', __('Id'));
        $grid->column('product', __('Product'))->display(function ($product) {
            $output = $product['name'] . '<br>';
            $images = $product['image'];
            if (!empty($images[0])) {
                $output .= '<img src="' . asset('storage/' . $images[0]) . '" alt="Image" style="width: 100px; height: auto;"/>';
            } else {
                $output .= '<img src="placeholder.png" alt="Image" style="width: 100px; height: auto;"/>';
            }
            return $output;
        });
        $grid->column('quantity', __('Quantity'));
        $grid->column('actual_price', __('Actual Price'));
        $grid->column('price', __('Applied Price'));
        $grid->column('requested_price', __('Requested Price'));
        $grid->column('total', __('Total Price'));
        $grid->column('approve', __('Status Approve'));
        $grid->column('forwarded_to', __('Forwarded To'));
        $grid->column('approver_name', __('Approver Name'));

        $grid->column('created_at', __('Created at'));

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
        $show = new Show(CartItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user.name', __('User/Store'));
        $show->field('total_amount', __('Total Amount'));
        $show->field('note', __('Note'));
        $show->field('proof', __('Proof'))->unescape()->as(function ($proof) {
            if ($proof !== 'null') {
                return '<a href="'.asset('storage/' . $proof).'" target="_blank">
                            <img src="' . asset('storage/' . $proof) . '" alt="Image" style="width: 100px; height: auto;"/>
                        </a>';
            }
        });
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    
    protected function form()
    {
        $form = new Form(new CartItem());
    
        // Select Product (Dropdown)
        $form->select('product_id', __('Product'))
            ->options(\App\Models\Product::pluck('name', 'id')->toArray())
            ->readonly();
    
        // Quantity & Price Fields
        $form->number('quantity', __('Quantity'))->default(1)->readonly();
        $form->decimal('price', __('Price'))->readonly();
        $form->decimal('requested_price', __('Requested Price'))->readonly();
        $form->decimal('offered_price', __('Offered Price'))
            ->help('Leave it blank to apply Requested Price directly.');
    
        // Approve Toggle
        $form->switch('approve', __('Approve'))->default(1);
    
        // Saving Hook
        $form->saving(function (Form $form) {
            if ($form->approve) {
                $form->model()->approver_name = 'Super Admin';
    
                // Prefer offered_price if provided, otherwise use requested_price
                $form->price = $form->offered_price ?: $form->requested_price;
            }
        });
    
        return $form;
    }
     
}
