<?php

namespace CB\Website\DynamicContent;

class Variable extends DynamicObject {
	/*** @var callable $action ***/
	private $action;

	public function __construct($variableName, $action){
		parent::__construct($variableName);

		if(is_callable($action)){
			$this->action = $action;
		}
		else{
			throw new \Exception('CB: DynContent Variable mus have callable action!');
		}
	}

	public function Filter($text){
		return preg_replace('/(?<!\\\)(' . self::tagOpen . preg_quote($this->getTagName()) . self::tagClose .')/', $this->action->__invoke(), $text);
	}
}
