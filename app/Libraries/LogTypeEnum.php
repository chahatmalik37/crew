<?php namespace App\Libraries;




final class LogTypeEnum{
	
	const LOGIN		=	1;
	
	const LOGOUT		=	3;
	
	const BREAK	=	2;
	
	const RESTART	=	4;
	const LEAVE	=	5;
	public static function getValues(){
		$reflection=new ReflectionClass('LogTypeEnum');
		return $reflection->getConstants();
	}	
}