<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyncDocuware extends Model
{
	public $timestamps = true;
	//protected $dateFormat = 'Y-m-d\TH:i:s.u';

	// protected $table = 'sync_docuwares';

	//
	protected $guarded = ['id'];

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class, 'comment_id', 'id');
	}

	public function assigned_categories()
	{
		return $this->belongsToMany('App\Models\DocumentCategory', 'document_document_categories', 'sync_docuware_id', 'document_category_id')->where('parent_id', '<>', 0);
	}

}
