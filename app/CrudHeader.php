<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\CrudHeader
 *
 * @property int                 $id
 * @property string              $model
 * @property string              $name
 * @property string              $value
 * @property string              $type
 * @property int                 $viewable
 * @property int                 $editable
 * @property int                 $browsable
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereBrowsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereViewable($value)
 * @mixin \Eloquent
 * @property string|null         $options Comma separated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereOptions($value)
 * @property string              $text
 * @property string              $align
 * @property string|null         $mask
 * @property int                 $priority
 * @property string|null         $edit_hint
 * @property string|null         $create_hint
 * @property bool                $edit_required
 * @property bool                $create_required
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereAlign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereCreateHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereCreateRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereEditHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereEditRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereMask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereText($value)
 * @property bool $creatable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CrudHeader whereCreatable($value)
 */
	class CrudHeader extends Model
	{
		//
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $casts = [
			'viewable'        => 'bool',
			'browsable'       => 'bool',
			'editable'        => 'bool',
			'creatable'       => 'bool',
			'create_required' => 'bool',
			'edit_required'   => 'bool',
		];
		protected $hidden = ['model', 'created_at', 'updated_at'];
	}
