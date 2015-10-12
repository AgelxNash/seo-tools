<?php namespace AgelxNash\SEOTools\Traits;

use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;

trait LocalizedDateTrait{
	use LocalizedEloquentTrait;

	public function takeCarbonAttributes($column, $toFormat, $fromFormat = 'Y-m-d H:i:s'){
		$out = null;
		if (isset($this->attributes[$column])){
			if($this->attributes[$column] instanceof LocalizedCarbon){
				$out = $this->attributes[$column];
			}else{
				$out = LocalizedCarbon::createFromFormat($fromFormat, $this->attributes[$column]);
			}
			$out =  $out->formatLocalized($toFormat);
		}
		return $out;
	}

	protected function getHumanTimestampAttribute($column, $fromFormat = 'Y-m-d H:i:s')
	{
		$out = null;
		if ($this->attributes[$column])
		{
			if($this->attributes[$column] instanceof LocalizedCarbon){
				$out = $this->attributes[$column];
			}else{
				$out = LocalizedCarbon::createFromFormat($fromFormat, $this->attributes[$column]);
			}
			$out = $out->diffForHumans();
		}

		return $out;
	}

	public function getTextDateCreatedAtAttribute()
	{
		return $this->takeCarbonAttributes("created_at", '%d %f %Y');
	}

	public function getTextDateUpdatedAtAttribute()
	{
		return $this->takeCarbonAttributes("updated_at", '%d %f %Y');
	}

	public function getTextDateDeletedAtAttribute()
	{
		return $this->takeCarbonAttributes("deleted_at", '%d %f %Y');
	}

	public function getTextDateTimeCreatedAtAttribute()
	{
		return $this->takeCarbonAttributes("created_at", '%d %f %Y, %H:%I:%S');
	}

	public function getTextDateTimeUpdatedAtAttribute()
	{
		return $this->takeCarbonAttributes("updated_at", '%d %f %Y, %H:%I:%S');
	}

	public function getTextDateTimeDeletedAtAttribute()
	{
		return $this->takeCarbonAttributes("deleted_at", '%d %f %Y, %H:%I:%S');
	}

	public function getHumanCreatedAtAttribute()
	{
		return $this->getHumanTimestampAttribute("created_at");
	}

	public function getHumanUpdatedAtAttribute()
	{
		return $this->getHumanTimestampAttribute("updated_at");
	}

	public function getHumanDeletedAtAttribute()
	{
		return $this->getHumanTimestampAttribute("deleted_at");
	}
}