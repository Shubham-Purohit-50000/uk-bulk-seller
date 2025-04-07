<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Category;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('Id'));
        $grid->column('image', __('Image'))->display(function ($image) {
            $output = '';
            if($image != null){
                $output = "<img src='" . asset('storage/' . $image) . "' alt='Image' style='width: 100px; height: auto;'/>";
            }
            else{
                $output = "<img src='placeholder.png' alt='Image' style='width: 100px; height: auto;'/>";
            }
            return $output;
        });
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('category.name', __('Parent Category'));
        $grid->column('created_at', __('Created at'))->display(function ($createdAt) {
            return formatDateTime($createdAt);
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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('parent_id', __('Parent id'));
        $show->field('image', __('Image'));
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
        $form = new Form(new Category());

        $form->text('name', __('Name'))
            ->rules('required|string|max:255', [
                'required' => 'The name field is required.',
                'string' => 'The name must be a string.',
                'max' => 'The name may not be greater than 255 characters.'
            ])
            ->required();

        $form->select('parent_id', __('Parent Category'))
            ->options(Category::all()->pluck('name', 'id'));

        $form->image('image', __('Image'))
            ->rules(['mimes:webp', 'max:1024'], [
                'mimes' => 'Only WebP images are allowed.',
                'max' => 'The image size must not exceed 1 MB.'
            ])
            ->required();

        return $form;
    }


}
