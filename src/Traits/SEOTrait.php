<?php namespace AgelxNash\SEOTools\Traits;

/**
 * @property mixed $seo
 */
trait SEOTrait{
	protected $defaultSeoFields = [
		'state' => 'dynamic',
		'priority' => '0.5',
		'frequency' => 'weekly',
		'robots' => 'index, follow'
	];

	/**
	 * @param array $val
	 */
	public function setSeoAttribute(array $val){
		$isNew = !$this->exists;
		if ( $isNew ) {
			$this->save();
		}
		if ($this->getKey()) {
			$val['priority'] = str_replace(",", ".", get_key($val, 'priority', array(), 'is_scalar'));
			$keywords = get_key($val, 'keywords', array(), 'is_array');
			unset($val['keywords']);
			$this->seo()->exists() ? $this->seo()->update($val) : $this->seo = $this->seo()->create($val);
			$this->seo()->keywords = $keywords;
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function seo()
	{
		return $this->morphOne('\AgelxNash\SEOTools\Models\Seo', 'seoble', 'document_type', 'document_id');
	}

	public function getState(){
		return $this->seo && !empty($this->seo->state) ? $this->seo->state : $this->defaultSeoFields['state'];
	}

	public function getPriority(){
		return (!$this->seo || empty($this->seo->priority) || $this->seo->priority == "0.0") ? $this->defaultSeoFields['priority'] : $this->seo->priority;
	}

	public function getFrequency(){
		return (!$this->seo || empty($this->seo->frequency)) ? $this->defaultSeoFields['frequency'] : $this->seo->frequency;
	}

	public function getRobots(){
		return (!$this->seo || empty($this->seo->robots)) ? $this->defaultSeoFields['robots'] : $this->seo->robots;
	}

	public function getSitemapData(){
		return [
			'location' => $this->url(),
			'last_modified' => $this->updated_at->format('Y-m-d\TH:i:sP'),
			'change_frequency' => $this->getFrequency(),
			'priority' => $this->getPriority()
		];
	}
}