<?php namespace AgelxNash\SEOTools\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seo
 * @package AgelxNash\SEOTools\Models
 *
 * @property string $title SEO title
 * @property string $description META описание страницы
 * @property int $document_id ID объекта с которым связаны SEO параметры
 * @property string $document_type Класс объекта с которым связаны SEO параметры
 * @property \Carbon\Carbon $created_at Дата создания SEO параметров
 * @property \Carbon\Carbon $updated_at Дата обновления SEO параметров
 * @property double $priority Приоритет для карты сайта
 * @property string $frequency Переодичность обновления страницы
 * @property string $robots Правила индексации страницы
 * @property string $state Тип страницы (сатичная, динамичная)
 * @property string $h1 Специфичный H1 заголовок для страницы
 */
class Seo extends Model {
	protected $table = 'seo';

	protected $fillable = array(
		'title',
		'description',
		'document_id',
		'document_type',
		'created_at',
		'updated_at',
		'priority',
		'frequency',
		'robots',
		'state',
		'h1',

		'keywords'
	);

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function seoble(){
		return $this->morphTo();
	}

	/**************
	 * Keywords
	 *************/
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function keywords()
	{
		return $this->belongsToMany('\AgelxNash\SEOTools\Models\Keyword');
	}

	/**
	 * @param $data
	 * @return bool|void
	 */
	public function attachKeywords($data)
	{
		if (!$this->keywords()->get()->contains($data)) {
			return $this->keywords()->attach($data);
		}

		return true;
	}

	/**
	 * @param $data
	 * @return int
	 */
	public function detachKeywords($data)
	{
		return $this->keywords()->detach($data);
	}

	/**
	 * @return int
	 */
	public function detachAllKeywords()
	{
		return $this->keywords()->detach();
	}

	/**
	 * @param $query
	 * @param $data
	 * @return mixed
	 */
	public function scopeKeywords($query, $data)
	{
		return $query->whereHas('seo_keywords', function ($query) use ($data) {
			$query->where('name', $data);
		});
	}

	/**
	 * @param $data
	 */
	public function setKeywordsAttribute($data)
	{
		if ( ! $this->exists) $this->save();
		( ! $data) ? $this->detachAllKeywords() : $this->keywords()->sync($data);
	}
}