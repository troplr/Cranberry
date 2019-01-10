<?php

namespace CB\Website\DynamicContent;

abstract class DynamicObject{
	protected const tagOpen = '{{';
	protected const tagClose = '}}';
	private $tagName;

	public function getTagName(){
		return $this->tagName;
	}

	public function __construct($tagName){
		if(!empty($tagName)){
			$this->tagName = $tagName;
		}
		else{
			throw new \Exception('CB: DynamicObject constructor must have a tag name!');
		}
	}

	public abstract function Filter($text);
}
