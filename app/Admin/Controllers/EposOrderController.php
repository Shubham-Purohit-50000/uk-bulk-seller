<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Order;
use \App\Models\User;
use \App\Models\Product;
use Admin;

class EposOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Epos-Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->model()->where('type','epos')->latest();

        $grid->column('id', __('Id'));
        $grid->column('user.name', __('Customer'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('status', __('Status'));
        $grid->column('discount', __('Discount'));
        $grid->column('tax', __('Tax'));
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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('Customer'))->as(function () {
            return $this->user->name ?? '-';
        });

        $show->field('total_amount', __('Total Amount'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created At'));
        $show->field('updated_at', __('Updated At'));

        // Show Order Items
        $show->orderItems('Order Items', function ($items) {
            $items->resource('/admin/order-items');
            $items->column('p_image', __('Image'))->display(function () {
                $images = $this->product->image;
                if (!empty($images[0])) {
                    return '<img src="' . asset('storage/' . $images[0]) . '" alt="Image" style="width: 100px; height: auto;"/>';
                } else {
                    return '<img src="placeholder.png" alt="Image" style="width: 100px; height: auto;"/>';
                }
            });
            $items->column('p_name', __('Name'))->display(function () {
                return $this->product->name;
            });

            $items->column('price', __('Price'));
            $items->column('quantity', __('Quantity'));
            $items->column('total', __('Total (Price x Quantity)'));
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
        $form = new Form(new Order());

        $customers = User::whereHas('roles', function ($query) {
            $query->whereNot('name', 'relational-manager');
        })->pluck('name', 'id');
        $form->select('user_id', __('Customer'))
            ->options($customers)
            ->rules('required');

        $form->hasMany('orderItems', 'Items', function (Form\NestedForm $form) {

            $form->text('barcode', __('Scan Barcode'))->attribute(['id' => 'barcode-input']);
            $form->html('<button type="button" class="simulate-scan">Simulate Scan</button>');
            $form->html('<h4>OR</h4>');

            $form->select('product_id', __('Product'))
                ->options(Product::all()->pluck('name', 'id'))
                ->rules('required');

            $form->decimal('price', __('Rate'))->required()->readonly();
            $form->decimal('quantity', 'Quantity')->default(1)->rules('required|min:1');
        });

        $form->html('<br>');

        $form->decimal('total_amount', __('Total amount'))->required()->readonly();


        $form->footer(function ($footer) {
            $footer->disableReset();
        });

        $form->saving(function (Form $form) {
            $form->model()->type = 'epos';
            $totalAmount = 0;
            foreach ($form->orderItems as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }
            $form->total_amount = $totalAmount;
        });
    

        // Inject JavaScript into Open Admin
        $script = <<<SCRIPT

            function fetchProductByBarcode(barcode, row) {
                let customer_id = $('[name="user_id"]').val();
                if (!barcode){
                    alert('Please Enter valid barcode');
                    return ;
                };

                $.ajax({
                    url: '/admin/get/product-by-barcode',
                    type: 'GET',
                    data: { barcode: barcode, customer_id: customer_id },
                    success: function (response) {
                        if (response.product) {
                            let productSelect = row.find('[name^="orderItems"][name$="[product_id]"]');
                            let priceInput = row.find('[name^="orderItems"][name$="[price]"]');
                            let productSelectWrapper = productSelect.closest('.choices.orderItems.product_id');

                            if(productSelectWrapper.length){
                                productSelectWrapper.replaceWith('<select name="product_id" class="form-control"><option value="' + response.product_id + '" selected>' + response.product_name + '</option></select>');
                            }else{
                                productSelect.val(response.product_id).trigger('change');
                                alert(productSelect);
                            }
                            priceInput.val(response.price);
                            updateTotal();
                        } else {
                            alert('Product not found!');
                        }
                    }
                });

                row.find('[name^="orderItems"][name$="[barcode]"]').val(''); // Clear input after scan
            }

            function updateTotal() {
                let total = 0;
                $('[name^="orderItems"][name$="[price]"]').each(function () {
                    let rowPrefix = $(this).attr('name').replace('[price]', ''); // Get row identifier
                    let price = parseFloat($(this).val()) || 0;
                    let quantity = parseInt($('[name="' + rowPrefix + '[quantity]"]').val()) || 0;
                    total += price * quantity;
                });
                $('[name="total_amount"]').val(total.toFixed(2));
            }

            $(document).ready(function () {
                let barcodeBuffer = '';
                let barcodeTimeout;

                $('#barcode-input').on('input', function (e) {
                    clearTimeout(barcodeTimeout);
                    let barcodeInput = $(this);
                    let currentRow = barcodeInput.closest('.has-many-orderItems-form');

                    barcodeBuffer += e.originalEvent.data || e.target.value; // Capture scanned input

                    barcodeTimeout = setTimeout(function () {
                        if (barcodeBuffer.length >= 6) { // Minimum barcode length (adjust if needed)
                            fetchProductByBarcode(barcodeBuffer.trim(), currentRow);
                        }
                        barcodeBuffer = ''; // Reset buffer
                    }, 200); // Small delay to detect barcode completion
                });

                $(document).on('click', '.simulate-scan', function () {
                    let fakeBarcode = '12345671'; // Use a real barcode from your database
                    let currentRow = $(this).closest('.has-many-orderItems-form'); // Get the clicked row

                    if (currentRow.length) {
                        let barcodeInput = currentRow.find('[name^="orderItems"][name$="[barcode]"]'); // Find barcode field
                        fetchProductByBarcode(fakeBarcode, currentRow); // Pass the correct row
                    } else {
                        alert('No order item rows available!');
                    }
                });

                $(document).on('change', '[name^="orderItems"][name$="[product_id]"]', function () {
                    let customer_id = $('[name="user_id"]').val();
                    let productSelect = $(this);
                    let rowPrefix = productSelect.attr('name').replace('[product_id]', ''); // Get row identifier

                    if (productSelect.val()) {
                        $.ajax({
                            url: '/admin/get/product-price',
                            type: 'GET',
                            data: { 
                                product_id: productSelect.val(),
                                customer_id: customer_id,
                            },
                            success: function (response) {
                                if (response.price) {
                                    $('[name="' + rowPrefix + '[price]"]').val(response.price);
                                    updateTotal();
                                }
                            }
                        });
                    }
                });

                $(document).on('input', '[name^="orderItems"][name$="[quantity]"]', function () {
                    updateTotal();
                });

                $(document).on('click', '.has-many-orderItems-form .remove', function () {
                    setTimeout(updateTotal, 100);
                });
            });


        SCRIPT;

        Admin::script($script);

        return $form;
    }

}
