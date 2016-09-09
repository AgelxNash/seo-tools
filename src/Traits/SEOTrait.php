<?php namespace AgelxNash\SEOTools\Traits;

/**
 * @property mixed $seo
 */
trait SEOTrait{
	/**
	 * @param array $fields
	 * @return array
	 */
	public function getDefaultSeoFields(array $fields = array()){
        $out = property_exists($this, 'defaultSeoFields') ? array_merge($this->defaultSeoFields, $fields) : $fields;
        if($this->exists){
            $out = array_merge($out, $this->seo->toArray());
        }
        return $out;
	}

	/**
	 * @param array $val
	 */
	public function setSeoAttribute(array $val){
        $isNew = !$this->exists;
		if ( $isNew ) {
			$this->save();
		}
		if ($this->getKey()) {
			$val['priority'] = str_replace(",", ".", array_get($val, 'priority', ''));
			$keywords = array_get($val, 'keywords', array());
			unset($val['keywords']);
			$this->seo()->exists() ? $this->seo()->update($val) : $this->seo = $this->seo()->create($val);
			$seo = $this->seo()->first();
			$seo->keywords = $keywords;
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function seo()
	{
		return $this->morphOne('\AgelxNash\SEOTools\Models\Seo', 'seoble', 'document_type', 'document_id');
	}

	/**
	 * @param string $key
	 * @return array|mixed
	 */
	protected function getSeoProperty($key){
		if($this->seo && !empty($this->seo->$key)) {
			$out = $this->seo->$key;
		}else{
			$out = $this->getDefaultSeoFields();
			$out = array_get($out, $key, null);
		}
		return $out;
	}

	/**
	 * @return mixed
	 */
	public function getSeoStateAttribute(){
		return $this->getSeoProperty('state');
	}

	/**
	 * @return mixed
	 */
	public function getSeoPriorityAttribute(){
		return $this->getSeoProperty('priority');
	}

	/**
	 * @return mixed
	 */
	public function getSeoFrequencyAttribute(){
		return $this->getSeoProperty('frequency');
	}

	/**
	 * @return mixed
	 */
	public function getSeoRobotsAttribute(){
		return $this->getSeoProperty('robots');
	}

	/**
	 * @return array
	 */
	public function getSitemapData(){
		return [
			'location' => $this->url(),
			'last_modified' => $this->updated_at->format('Y-m-d\TH:i:sP'),
			'change_frequency' => $this->seo_frequency,
			'priority' => $this->seo_priority
		];
	}
}
