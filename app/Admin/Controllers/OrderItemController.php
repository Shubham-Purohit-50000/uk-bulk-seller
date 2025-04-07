<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\OrderItem;
use \App\Models\Product;
use \App\Models\User;

use Admin;

class OrderItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OrderItem';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderItem());

        $grid->column('id', __('Id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('price', __('Price'));
        $grid->column('total', __('Total'));
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
        $show = new Show(OrderItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order id'));
        $show->field('product_id', __('Product id'));
        $show->field('quantity', __('Quantity'));
        $show->field('price', __('Price'));
        $show->field('total', __('Total'));
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
        $form = new Form(new OrderItem());

        $form->number('order_id', __('Order ID'))->readonly();
                
        $form->text('barcode', __('Scan Barcode'))->attribute(['id' => 'barcode-input']);
        $form->html('<button type="button" class="simulate-scan">Simulate Scan</button>');
        $form->html('<h4>OR</h4>');

        $form->select('product_id', __('Product'))
            ->options(Product::all()->pluck('name', 'id'))
            ->rules('required');

        $form->decimal('price', __('Rate'))->required()->readonly();
        $form->decimal('quantity', __('Quantity'))->default(1)->rules('required|min:1');
        $form->decimal('total', __('Total'))->readonly();

        $form->saving(function (Form $form) {
            $form->total = $form->price * $form->quantity;
        });

        $script = <<<SCRIPT
            function fetchProductByBarcode(barcode) {

                let order_id = $('[name="order_id"]').val();

                if (!barcode){
                    alert('Please enter a valid barcode');
                    return;
                }

                $.ajax({
                    url: '/admin/get/product-by-barcode',
                    type: 'GET',
                    data: { barcode: barcode, order_id: order_id},
                    success: function (response) {
                        if (response.product) {
                            $('[name="product_id"]').val(response.product_id).trigger('change');
                            $('[name="price"]').val(response.price);
                            updateTotal();
                        } else {
                            alert('Product not found!');
                        }
                    }
                });
                $('#barcode-input').val(''); // Clear input after scan
            }

            function updateTotal() {
                let price = parseFloat($('[name="price"]').val()) || 0;
                let quantity = parseInt($('[name="quantity"]').val()) || 0;
                $('[name="total"]').val((price * quantity).toFixed(2));
            }

            $(document).ready(function () {
                let order_id = $('[name="order_id"]').val();
                
                $('#barcode-input').on('change', function () {
                    fetchProductByBarcode($(this).val().trim());
                });

                $(document).on('click', '.simulate-scan', function () {
                    fetchProductByBarcode('12345671'); // Replace with a real barcode
                });

                $(document).on('change', '[name="product_id"]', function () {
                    $.ajax({
                        url: '/admin/get/product-price',
                        type: 'GET',
                        data: { product_id: $(this).val(), order_id: order_id},
                        success: function (response) {
                            if (response.price) {
                                $('[name="price"]').val(response.price);
                                updateTotal();
                            }
                        }
                    });
                });

                $(document).on('input', '[name="quantity"]', function () {
                    updateTotal();
                });
            });
        SCRIPT;

        Admin::script($script);

        return $form;
    }

}
