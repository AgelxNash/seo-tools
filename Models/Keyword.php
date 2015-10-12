<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Keyword
 * @package App\Models
 * @property string $name Ключевое слово
 * @property int $seo_id Связь с \App\Models\Seo
 * @property \Carbon\Carbon $created_at Дата создания ключа
 * @property \Carbon\Carbon $updated_at Дата обновления ключа
 */
class Keyword extends Model {
	protected $table = 'keywords';
	protected $fillable = array(
		'name',
		'created_at',
		'updated_at'
	);

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function seo()
	{
		return $this->belongsToMany('\App\Models\Seo')->withTimestamps();
	}
}