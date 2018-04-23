<?php
	
	namespace App\Admin\Controllers;
	
	use Admin;
	use App\Http\Controllers\Controller;
	use App\ShopCategory;
	use Encore\Admin\Controllers\ModelForm;
	use Encore\Admin\Form;
	use Encore\Admin\Grid;
	use Encore\Admin\Layout\Content;
	
	class ShopCategoryController extends Controller
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
				
				$content->header('Categories');
				$content->description('List');
				
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
				
				/** @var ShopCategory $category */
				$category = ShopCategory::findOrFail($id);
				
				$content->header('Categories');
				$content->description('Edit ' . $category->name);
				
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
				
				$content->header('Categories');
				$content->description('Create a new category');
				
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
			return Admin::grid(ShopCategory::class, function (Grid $grid) {
				
				$grid->id('ID')->sortable();
				$grid->column('name')->editable();
				$grid->column('order')->editable();
				$grid->created_at();
				$grid->updated_at();
				
				//$grid->disableActions();
				
			});
			
			
		}
		
		/**
		 * Make a form builder.
		 *
		 * @return Form
		 */
		protected function form()
		{
			return Admin::form(ShopCategory::class, function (Form $form) {
				
				$form->display('id', 'ID');
				$form->text('name')->rules('required');
				$form->number('order')->rules('numeric|max:99|min:1')->default(0);
				$form->display('created_at', 'Created At');
				$form->display('updated_at', 'Updated At');
			});
		}
	}
