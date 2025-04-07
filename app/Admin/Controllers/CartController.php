<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Cart;

class CartController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Bargained Cart';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cart());

        // Filter carts that have at least one cartItem with is_bargained = true
        $grid->model()->whereHas('cartItems', function ($query) {
            $query->where('approve', false);
            $query->where('forwarded_to', 'admin');
        });

        $grid->column('id', __('Id'));
        $grid->column('user.name', __('User/Store'));
        $grid->column('total_amount', __('Total Amount'));
        $grid->column('note', __('Note'));
        $grid->column('proof', __('Proof'))->display(function ($proofs) {
            $proofs = json_decode($proofs);
            if (filled($proofs)) {
                foreach($proofs as $proof)
                    return '<a href="'.asset('storage/' . $proof).'" target="_blank">
                                <img src="' . asset('storage/' . $proof) . '" alt="Image" style="width: 100px; height: auto;"/>
                            </a>';
            }
        });
        $grid->column('created_at', __('Created at'));

        // $grid->disableActions();
        $grid->actions(function ($actions) {
            $actions->disableEdit();   // Disable Edit button
            $actions->disableDelete(); // Disable Delete button
        });
        $grid->disableCreateButton();

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
        $show = new Show(Cart::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user.name', __('User/Store'));
        $show->field('total_amount', __('Total Amount'));
        $show->field('note', __('Note'));
        $show->field('proof', __('Proof'))->unescape()->as(function ($proofs) {
            $proofs = json_decode($proofs);
            if (filled($proofs)) {
                foreach($proofs as $proof)
                    return '<a href="'.asset('storage/' . $proof).'" target="_blank">
                                <img src="' . asset('storage/' . $proof) . '" alt="Image" style="width: 100px; height: auto;"/>
                            </a>';
            }
        });
        $show->field('created_at', __('Created at'));

        $show->cartItems('Items', function ($items) {
            $items->model()->where('approve', false)->where('forwarded_to', 'admin');
            $items->resource('/admin/cart-items');
            $items->column('id', __('ID'));
            $items->column('product.name', __('Product Name'));
            $items->column('product.image', __('Image'))->display(function ($images) {
                if (!empty($images[0])) {
                    return '<img src="' . asset('storage/' . $images[0]) . '" alt="Image" style="width: 100px; height: auto;"/>';
                } else {
                    return '<img src="placeholder.png" alt="Image" style="width: 100px; height: auto;"/>';
                }
            });
            $items->column('quantity', __('Quantity'));
            $items->column('price', __('price'));
            $items->column('requested_price', __('Requested Price'));
            $items->actions(function ($actions) {
                $actions->disableDelete(); // Disable Delete button
            });
            $items->disableCreateButton();
        });

        // Disable Edit and Delete buttons
        $show->panel()
        ->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Cart());

        $form->select('user_id', __('User/Store'))->options(\App\Models\User::pluck('name', 'id'))->required();
        $form->decimal('total_amount', __('Total Amount'))->required();
        $form->textarea('note', __('Note'));

        $form->image('proof', __('Proof'))->move('cart_proofs')->uniqueName()->removable();

        $form->hasMany('cartItems', 'Cart Items', function (Form\NestedForm $form) {
            $form->select('product_id', __('Product'))->options(\App\Models\Product::pluck('name', 'id'))->required();
            $form->number('quantity', __('Quantity'))->default(1)->required();
            $form->decimal('price', __('Price'))->required();
            $form->decimal('requested_price', __('Requested Price'))->required();
            $form->switch('approve', __('Approve'))->default(1); // Removed `states()` method
            $form->hidden('forwarded_to')->default('admin');
        });

        return $form;
    }


}
