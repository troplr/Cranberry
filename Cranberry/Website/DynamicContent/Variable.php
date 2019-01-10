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
		$fqn = self::tagOpen . preg_quote($this->getTagName()) . self::tagClose;

		$text = preg_replace('/(?<!\\\)(' . $fqn .')/', $this->action->__invoke(), $text);
		$text = preg_replace('/(?<!\\\)(\\\){1}(' . $fqn . ')/', $fqn, $text);

		return $text;
	}
}
