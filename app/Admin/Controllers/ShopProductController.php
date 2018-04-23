<?php
	
	namespace App\Admin\Controllers;
	
	use Admin;
	use App\Http\Controllers\Controller;
	use App\ShopCategory;
	use App\ShopProduct;
	use Encore\Admin\Controllers\ModelForm;
	use Encore\Admin\Form;
	use Encore\Admin\Grid;
	use Encore\Admin\Layout\Content;
	
	class ShopProductController extends Controller
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
				
				$content->header('Products');
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
				
				$content->header('Products');
				$content->description('Add a new product');
				
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
			return Admin::grid(ShopProduct::class, function (Grid $grid) {
				
				$grid->id('ID')->sortable();
				$grid->column('image')->image();
				$grid->column('name')->editable();
				$grid->column('shopCategory.name', 'Category');
				$grid->column('price')->editable();
				$grid->column('description');
				
				//$grid->created_at();
				//$grid->updated_at();
				
				$grid->filter(function (Grid\Filter $filter) {
					
					// Remove the default id filter
					$filter->disableIdFilter();
					
					// Add a column filter
					$filter->like('name', 'name');
					
				});
				
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
			return Admin::form(ShopProduct::class, function (Form $form) {
				
				$form->display('id', 'ID');
				
				$form->select('shop_category_id', 'Category')
					->options(ShopCategory::all()->pluck('name', 'id'))->rules('required');
				$form->text('name');
				$form->image('image')->rules('required');
				$form->currency('price')->symbol('KSH')->rules('required');
				$form->textarea('description')->rows(6)->rules('required');
				$form->display('created_at', 'Created At');
				$form->display('updated_at', 'Updated At');
			});
		}
	}
