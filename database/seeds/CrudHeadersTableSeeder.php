<?php
	
	use App\Category;
	use App\Client;
	use App\CrudHeader;
	use App\Department;
	use App\Order;
	use App\OrderItem;
	use App\Product;
	use App\Role;
	use App\Supplier;
	use App\TopUp;
	use App\User;
	use Illuminate\Database\Seeder;
	
	class CrudHeadersTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//region Headers for App\Client
			CrudHeader::create([
				'model'     => Client::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model' => Client::class,
				'text'  => 'Name',
				'value' => 'name',
				'type'  => 'text',
			]);
			CrudHeader::create([
				'model' => Client::class,
				'text'  => 'Email',
				'value' => 'email',
				'type'  => 'email',
			]);
			CrudHeader::create([
				'model' => Client::class,
				'text'  => 'Phone',
				'value' => 'phone',
				'type'  => 'text',
				'mask'  => '##########',
			]);
			CrudHeader::create([
				'model'   => Client::class,
				'text'    => 'Account Type',
				'value'   => 'accountType',
				'type'    => 'SELECT',
				'options' => 'PRE_PAID,POST_PAID',
			]);
			CrudHeader::create([
				'model' => Client::class,
				'text'  => 'Limit',
				'value' => 'limit',
				'type'  => 'text',
				'mask'  => '######',
			]);
			CrudHeader::create([
				'model'     => Client::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'creatable' => false,
				'editable'  => false,
				'browsable' => false,
			]);
			CrudHeader::create([
				'model'     => Client::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'creatable' => false,
				'editable'  => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\User
			CrudHeader::create([
				'model'     => User::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => User::class,
				'text'      => 'Client',
				'value'     => 'clientId',
				'type'      => 'select_remote',
				'options'   => 'clients/search',
				'edit_hint' => 'Leave empty to keep user on with current client',
			]);
			CrudHeader::create([
				'model'     => User::class,
				'text'      => 'Role',
				'value'     => 'roleId',
				'type'      => 'select_remote',
				'options'   => 'roles/search',
				'edit_hint' => 'Leave empty to keep user with the same role',
			]);
			CrudHeader::create([
				'model' => User::class,
				'text'  => 'Name',
				'value' => 'name',
				'type'  => 'text',
			]);
			CrudHeader::create([
				'model' => User::class,
				'text'  => 'Email',
				'value' => 'email',
				'type'  => 'email',
			]);
			CrudHeader::create([
				'model'         => User::class,
				'text'          => 'Password',
				'value'         => 'password',
				'type'          => 'email',
				'edit_hint'     => 'Leave empty to keep the same password',
				'create_hint'   => 'Password will be sent to the user phone number',
				'browsable'     => false,
				'viewable'      => false,
				'edit_required' => false,
			]);
			CrudHeader::create([
				'model'       => User::class,
				'text'        => 'Phone',
				'value'       => 'phone',
				'type'        => 'text',
				'mask'        => '##########',
				'create_hint' => 'User password will be sent to this phone number',
				'browsable'   => false,
			]);
			CrudHeader::create([
				'model'     => User::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			CrudHeader::create([
				'model'     => User::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'creatable' => false,
				'editable'  => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\TopUp
			CrudHeader::create([
				'model'     => TopUp::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'    => TopUp::class,
				'text'     => 'Client',
				'value'    => 'clientId',
				'type'     => 'select_remote',
				'options'  => 'clients/search',
				'editable' => false,
			]);
			CrudHeader::create([
				'model' => TopUp::class,
				'text'  => 'Amount',
				'value' => 'amount',
				'type'  => 'text',
				'mask'  => '######',
			]);
			CrudHeader::create([
				'model'     => TopUp::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => TopUp::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\Role
			CrudHeader::create([
				'model'     => Role::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			
			CrudHeader::create([
				'model'     => Role::class,
				'text'      => 'Name',
				'value'     => 'name',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			
			CrudHeader::create([
				'model' => Role::class,
				'text'  => 'Display Name',
				'value' => 'displayName',
				'type'  => 'text',
			]);
			
			CrudHeader::create([
				'model'     => Role::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			CrudHeader::create([
				'model'     => Role::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\Department
			CrudHeader::create([
				'model'     => Department::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model' => Department::class,
				'text'  => 'Name',
				'value' => 'name',
				'type'  => 'text',
			]);
			CrudHeader::create([
				'model'     => Department::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Department::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\ShopProduct
			CrudHeader::create([
				'model'     => Product::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Product::class,
				'text'      => 'Supplier',
				'value'     => 'supplierId',
				'type'      => 'select_remote',
				'options'   => 'suppliers/search',
				'edit_hint' => 'Leave empty to keep same supplier',
			]);
			CrudHeader::create([
				'model' => Product::class,
				'text'  => 'Name',
				'value' => 'name',
			]);
			CrudHeader::create([
				'model' => Product::class,
				'text'  => 'Price',
				'value' => 'price',
				'type'  => 'text',
				'mask'  => '#####',
			]);
			CrudHeader::create([
				'model'           => Product::class,
				'text'            => 'Description',
				'value'           => 'description',
				'type'            => 'textarea',
				'edit_required'   => false,
				'create_required' => false,
				'browsable'       => false,
			]);
			CrudHeader::create([
				'model'     => Product::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			CrudHeader::create([
				'model'     => Product::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
			]);
			//endregion
			
			//region Headers for App\Order
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
				'viewable'  => false,
			
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Items',
				'value'     => 'itemCount',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Amount',
				'value'     => 'amount',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Status',
				'value'     => 'status',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'RejectedBy',
				'value'     => 'rejectedBy',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			CrudHeader::create([
				'model'     => Order::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			//endregion
			
			//region Headers for App\OrderItem
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Product',
				'value'     => 'product',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Supplier',
				'value'     => 'supplier',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Quantity',
				'value'     => 'quantity',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Price at Purchase',
				'value'     => 'priceAtPurchase',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Amount',
				'value'     => 'amount',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Status',
				'value'     => 'status',
				'type'      => 'text',
				'editable'  => false,
				'creatable' => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			CrudHeader::create([
				'model'     => OrderItem::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			//endregion
			
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Id',
				'value'     => 'id',
				'type'      => 'number',
				'editable'  => false,
				'creatable' => false,
			
			]);
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Name',
				'value'     => 'name',
				'type'      => 'text',
			]);
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Order',
				'value'     => 'order',
				'type'      => 'number',
			]);
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Items',
				'value'     => 'itemCount',
				'type'      => 'number',
			]);
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Created At',
				'value'     => 'createdAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			CrudHeader::create([
				'model'     => Category::class,
				'text'      => 'Updated At',
				'value'     => 'updatedAt',
				'type'      => 'date',
				'editable'  => false,
				'creatable' => false,
				'browsable' => false,
				'viewable'  => false,
			]);
			
		}
	}
