<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;
use \App\Models\Level;
use \App\Models\Product;

class BusinessCustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Stores';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->whereHas('roles', function ($query) {
            $query->where('name', 'business'); // Change role as per requirement
        });

        $grid->column('id', __('ID'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone no.'));
        $grid->column('rm', __('Relation Mnager'))->display(function ($rm) {
            return $rm ? $rm['name'] : 'Admin';
        });
        $grid->column('level.name', __('Level'));
        $grid->column('latitude', __('Latitude'));
        $grid->column('longitude', __('Longitude'));
        $grid->column('address', __('Address'))->limit(50);

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone no.'));
        $show->field('rm', __('Relation Mnager'))->as(function ($rm) {
            return $rm ? $rm['name'] : 'Admin';
        });
        $show->field('level.name', __('Level'));
        $show->field('latitude', __('Latitude'));
        $show->field('longitude', __('Longitude'));
        $show->field('address', __('Address'));

        $show->tieUpProducts('Tie Up Products', function ($tieUpProducts) {
            $tieUpProducts->resource('/admin/tie-up-products');
            $tieUpProducts->column('id', __('ID'));
            $tieUpProducts->column('product.name', __('Product'));
            $tieUpProducts->column('price', __('Price'));
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
        $form = new Form(new User());

        $grid = new Grid(new User());

        $grid->model()->whereHas('roles', function ($query) {
            $query->where('name', 'business'); // Change role as per requirement
        });

        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->phonenumber('phone', __('Phone no.'))->options(['mask' => '999 999 9999'])->required();
        $form->password('password', __('Password'))->required();
        // Fetch users who have the "relational-manager" role
        $relationalManagers = User::whereHas('roles', function ($query) {
            $query->where('name', 'relational-manager');
        })->pluck('name', 'id');
        $form->select('added_by', __('Relational Manager'))
            ->options($relationalManagers)
            ->help('leave blank if you want added by Admin')->required();
        $form->select('level_id', __('Select Level'))
            ->options(Level::all()->pluck('name', 'id'))->required();
        $form->decimal('latitude','Latitude')->required();
        $form->decimal('longitude','Longitude')->required();
        $form->textarea('address', __('Address'))->required();

        $form->hasMany('tieUpProducts', 'Tie Up Products', function (Form\NestedForm $form) {
            $form->select('product_id', __('Product'))
                ->options(Product::all()->pluck('name', 'id'))
                ->rules('required');
            $form->decimal('price', __('Price'))->rules('required|min:0');
        });

        $form->saving(function (Form $form) {
            $form->model()->assignRole('business');
        });

        return $form;
    }
}