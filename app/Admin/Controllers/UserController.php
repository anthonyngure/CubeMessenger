<?php
	
	namespace App\Admin\Controllers;
	
	use Admin;
	use App\Client;
	use App\Http\Controllers\Controller;
	use App\Role;
	use App\Traits\Messages;
	use App\User;
	use Encore\Admin\Controllers\ModelForm;
	use Encore\Admin\Form;
	use Encore\Admin\Grid;
	use Encore\Admin\Layout\Content;
	use Hash;
	
	class UserController extends Controller
	{
		use ModelForm, Messages;
		
		/**
		 * Index interface.
		 *
		 * @return Content
		 */
		public function index()
		{
			return Admin::content(function (Content $content) {
				
				$content->header('Users');
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
				
				/** @var User $user */
				$user = User::findOrFail($id);
				$content->header('Users');
				$content->description('Edit ' . $user->name);
				
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
				
				$content->header('Users');
				$content->description('Add a new user');
				
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
			return Admin::grid(User::class, function (Grid $grid) {
				
				$grid->id('ID')->sortable();
				//$grid->column('avatar')->image();
				$grid->column('client.name', 'Client');
				$grid->column('department.name', 'Department');
				$grid->column('role.name', 'Role');
				$grid->column('email');
				$grid->column('phone');
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
			return Admin::form(User::class, function (Form $form) {
				
				$form->display('id', 'ID');
				$form->select('client_id', 'Client')->options(function ($id) {
					$client = Client::find($id);
					if ($client) {
						return [$client->id => $client->name];
					}
				})->rules('required')->ajax('/admin/api/clients');
				$form->text('password')->rules('required');
				$form->select('role_id', 'Role')->options(Role::all()->pluck('name', 'id'))
					->rules('required');
				$form->text('name')->rules('required');
				$form->mobile('phone')->options(['mask' => '0799999999'])
					->help('Password will be sent to this phone number')
					->rules(function (Form $form) {
						if (!$form->model()->id) {
							return 'required|unique:users,phone';
						} else {
							return 'required';
						}
					});
				$form->email('email')->rules(function (Form $form) {
					if (!$form->model()->id) {
						return 'required|unique:users,email';
					} else {
						return 'required';
					}
				});
				$form->image('avatar')->rules('nullable');
				$form->display('created_at', 'Created At');
				$form->display('updated_at', 'Updated At');
				$form->saving(function (Form $form){
					
					$smsText = 'Hi ' . $form->name . ', your Cube Messenger password is ' . $form->password;
					$this->sendSMS($smsText, $form->phone);
					
					$form->password = Hash::make($form->password);
					//dd($form->password);
				});
			});
		}
	}
