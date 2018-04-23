<?php
	
	namespace App\Admin\Controllers;
	
	use Admin;
	use App\Http\Controllers\Controller;
	use App\ServiceRequest;
	use Encore\Admin\Controllers\ModelForm;
	use Encore\Admin\Form;
	use Encore\Admin\Grid;
	use Encore\Admin\Layout\Content;
	
	class ServiceRequestController extends Controller
	{
		use ModelForm;
		
		/**
		 * Index interface.
		 *
		 * @return Content
		 */
		public function index()
		{
			return Admin::content(function (Content $content) {
				
				$content->header('header');
				$content->description('description');
				
				$content->body($this->grid());
			});
		}
		
		/**
		 * Edit interface.
		 *
		 * @param $id
		 * @return Content
		 */
		public function edit($id)
		{
			return Admin::content(function (Content $content) use ($id) {
				
				$content->header('header');
				$content->description('description');
				
				$content->body($this->form()->edit($id));
			});
		}
		
		/**
		 * Create interface.
		 *
		 * @return Content
		 */
		public function create()
		{
			return Admin::content(function (Content $content) {
				
				$content->header('header');
				$content->description('description');
				
				$content->body($this->form());
			});
		}
		
		/**
		 * Make a grid builder.
		 *
		 * @return Grid
		 */
		protected function grid()
		{
			return Admin::grid(ServiceRequest::class, function (Grid $grid) {
				
				$grid->id('ID')->sortable();
				$grid->column('type');
				$grid->column('status');
				$grid->column('details');
				$grid->column('note');
				$grid->column('schedule_date');
				$grid->column('schedule_time');
				$grid->created_at();
				//$grid->updated_at();
				$grid->disableActions();
			});
		}
		
		/**
		 * Make a form builder.
		 *
		 * @return Form
		 */
		protected function form()
		{
			return Admin::form(ServiceRequest::class, function (Form $form) {
				
				$form->display('id', 'ID');
				
				$form->display('created_at', 'Created At');
				$form->display('updated_at', 'Updated At');
			});
		}
	}
