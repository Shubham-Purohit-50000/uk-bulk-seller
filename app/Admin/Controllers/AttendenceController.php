<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Attendence;

class AttendenceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Attendence';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Attendence());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('date', __('Date'));
        $grid->column('check_in', __('Check in'));
        $grid->column('check_out', __('Check out'));
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
        $show = new Show(Attendence::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('date', __('Date'));
        $show->field('check_in', __('Check in'));
        $show->field('check_out', __('Check out'));
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
        $form = new Form(new Attendence());

        $form->number('user_id', __('User id'));
        $form->date('date', __('Date'))->default(date('Y-m-d'));
        $form->datetime('check_in', __('Check in'))->default(date('Y-m-d H:i:s'));
        $form->datetime('check_out', __('Check out'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
