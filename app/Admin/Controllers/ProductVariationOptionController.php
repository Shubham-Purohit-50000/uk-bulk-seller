<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\ProductVariationOption;
use App\Models\Product;
use App\Models\VariationAttribute;
use App\Models\VariationOption;

class ProductVariationOptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ProductVariationOption';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductVariationOption());

        $grid->column('id', __('ID'));
        $grid->column('product.name', __('Product'));
        $grid->column('attribute.name', __('Attribute'));
        $grid->column('option.value', __('Option'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('created_at', __('Created At'));

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
        $show = new Show(ProductVariationOption::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_id', __('Product id'));
        $show->field('attribute_id', __('Attribute id'));
        $show->field('option_id', __('Option id'));
        $show->field('quantity', __('Quantity'));
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
        $form = new Form(new ProductVariationOption());

        $form->select('product_id', __('Product'))
            ->options(Product::all()->pluck('name', 'id'))
            ->rules('required');

        $form->select('attribute_id', __('Attribute'))
            ->options(VariationAttribute::all()->pluck('name', 'id'))
            ->rules('required');

        $form->select('option_id', __('Option'))
            ->options(VariationOption::all()->pluck('value', 'id'))
            ->rules('required');

        $form->decimal('quantity', __('Quantity'))->rules('required|min:0');

        return $form;
    }
}
