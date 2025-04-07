<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Product;
use \App\Models\Category;
use \App\Models\Level;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Widgets\Form as AdminForm;
use OpenAdmin\Admin\Facades\Admin;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'));
        $grid->column('image', __('Image'))->display(function ($images) {
            if (!empty($images[0])) {
                return '<img src="' . asset('storage/' . $images[0]) . '" alt="Image" style="width: 100px; height: auto;"/>';
            } else {
                return '<img src="placeholder.png" alt="Image" style="width: 100px; height: auto;"/>';
            }
        });
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('cost_price', __('Cost Price'));
        $grid->column('recommended_price', __('Recommended Price'));
        $grid->column('description', __('Description'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('category.name', __('Category'));
        $grid->column('tag', __('Tags'))->display(function ($tag){
            $output = '';
            foreach($tag as $item){
                $output .= '<span class="btn btn-sm btn-success mx-1">'.$item.'</span>';
            }
            return $output;
        });
        $grid->column('created_at', __('Created at'))->display(function ($createdAt) {
            return formatDateTime($createdAt);
        });

        // Add an Import Form at the Top
        $grid->tools(function ($tools) {
            $form = new AdminForm();
            $form->action(route('admin.products.import'))->method('POST')->attribute(['enctype' => 'multipart/form-data']);
            $form->file('file', __('Upload Excel'))->attribute(['accept' => '.csv,.xlsx'])->required();
            $form->submit(__('Import'), 'btn btn-success');
            $form->html('<a href="/demo_product_import.xlsx" target="_blank" class="btn btn-sm btn-primary" title="Download"><i class="icon-download"></i><span class="hidden-xs"> Download Import Template</span></a>');
            $tools->append($form->render());
        });

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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('quantity', __('Quantity'));
        $show->field('category.name', __('Category'));
        
        $show->field('image', __('Image'))->unescape()->as(function ($images) {
            $output = '';
            if (!empty($images)) {
                foreach ($images as $image) {
                    $output .= '<img src="' . asset('storage/' . $image) . '" alt="Image" style="width: 100px; height: auto; margin-right: 5px;"/>';
                }
            } else {
                $output = '<img src="placeholder.png" alt="Image" style="width: 100px; height: auto;"/>';
            }
            return $output;
        });

        $show->field('tag', __('Tags'))->as(function ($tag) {
            $output = '';
            foreach ($tag as $item) {
                $output .= '<span class="btn btn-sm btn-success mx-1">' . $item . '</span>';
            }
            return $output;
        })->unescape();

        $show->field('cost_price', __('Cost Price'));
        $show->field('recommended_price', __('Recommended Price'));
        
        $show->priceVariations('Price Variations', function ($items) {
            $items->resource('/admin/price-variations');
            $items->column('id', __('ID'));
            $items->column('level.name', __('Level'));
            $items->column('price', __('Price'));
        });
        $show->field('description', __('Description'));

        $show->field('created_at', __('Created at'))->as(function ($createdAt) {
            return formatDateTime($createdAt);
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
        $form = new Form(new Product());
    
        $form->text('name', __('Name'))->required();
        $form->decimal('quantity', __('Quantity'))->required();
        $form->select('category_id', __('Category id'))
            ->options(Category::all()->pluck('name', 'id'))
            ->required();
    
        $form->multipleImage('image', __('Multiple Image'))
            ->rules('mimes:webp|max:1024', [
                'mimes' => 'Only webp images are allowed.',
                'max' => 'The image size must not exceed 1 MB.',
            ]);
    
        $form->textarea('description', __('Description'))->required();
    
        $form->text('tag', 'Product Tags')->value('new, best')
            ->help('Enter comma-separated tags like: new, best');

        // $form->tags('tag','Product Tags')
        //     ->help('Enter comma-separated tags like: new, best');

    
        $form->currency('cost_price', 'Cost Price')->rules('required|min:0');
        $form->currency('recommended_price', 'Recommended Price')->rules('required|min:0');
        $form->text('barcode', 'Barcode')->rules('required|min:0');

        $form->hasMany('productVariationOptions', 'Product Variations', function (Form\NestedForm $form) {
            $form->select('attribute_id', __('Variation Attribute'))
                ->options(\App\Models\VariationAttribute::all()->pluck('name', 'id'))
                ->rules('required');
        
            $form->select('option_id', __('Variation Option'))
                ->options(function ($attribute_id) {
                    return \App\Models\VariationOption::where('variation_id', $attribute_id)->pluck('value', 'id');
                })
                ->rules('required');
        
            $form->decimal('quantity', __('Quantity'))->rules('required|min:0');
        });        
    
        $form->hasMany('priceVariations', 'Price Variations', function (Form\NestedForm $form) {
            $form->select('level_id', __('Level'))
                ->options(Level::all()->pluck('name', 'id'))
                ->rules('required');
            $form->decimal('price', __('Price'))->rules('required|min:0');
        });
    
        $form->saving(function (Form $form) {
            // Get the cost price and recommended price from the form
            $costPrice = $form->cost_price;
            $recommendedPrice = $form->recommended_price;
    
            // Loop through price variations
            foreach ($form->priceVariations as $priceVariation) {
                $price = $priceVariation['price'];
                if ($price <= $costPrice || $price > $recommendedPrice) {
                    admin_toastr(
                        "All price variations must be greater than the cost price ({$costPrice}) and less than or equal to the recommended price ({$recommendedPrice}).",
                        'error'
                    );
                    return back()->withInput();
                }
            }
        });
    
        return $form;
    }
     

    public function import_old(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));

            return back()->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));

            admin_success('Success', 'Products imported successfully!');
        } catch (\Exception $e) {
            admin_error('Error', 'Failed to import products: ' . $e->getMessage());
        }

        return back();
    }


}
