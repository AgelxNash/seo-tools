<?php namespace AgelxNash\SEOTools\Interfaces;

interface SeoInterface{
	public function getDefaultSeoFields(array $fields = array());

	public function url($mode = null);

	public function setSeoAttribute(array $val);
	public function seo();

	public function getSitemapData();
}