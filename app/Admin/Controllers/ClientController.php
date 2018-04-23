<?php
	
	namespace App\Admin\Controllers;
	
	use Admin;
	use App\Client;
	use App\Http\Controllers\Controller;
	use Encore\Admin\Controllers\ModelForm;
	use Encore\Admin\Form;
	use Encore\Admin\Grid;
	use Encore\Admin\Layout\Content;
	
	class ClientController extends Controller
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
				
				$content->header('Clients');
				//$content->description('description');
				
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
				
				$content->header('Clients');
				$content->description('Add a new client');
				
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
			return Admin::grid(Client::class, function (Grid $grid) {
				
				$grid->id('ID')->sortable();
				$grid->column('logo')->image();
				$grid->column('name')->editable();
				$grid->column('email');
				$grid->column('phone');
				$grid->column('account_type');
				$grid->column('limit')->editable();
				//$grid->created_at();
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
			return Admin::form(Client::class, function (Form $form) {
				
				$form->display('id', 'ID');
				$form->text('name')->rules('required');
				$form->mobile('phone')->options(['mask' => '0799999999'])->rules('required|unique:users,phone');
				$form->email('email')->rules('required|unique:users,email');
				$form->select('account_type')->options(['POST_PAID' => 'POST_PAID', 'PRE_PAID' => 'PRE_PAID'])
					->rules('required|in:POST_PAID,PRE_PAID');
				$form->currency('limit')->symbol('KSH')->rules('numeric');
				$form->image('logo')->removable();
				$form->display('created_at', 'Created At');
				$form->display('updated_at', 'Updated At');
			});
		}
	}
