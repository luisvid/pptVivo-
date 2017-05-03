<?php

class searchFilters {
	
	/**
	 * Control types
	 */
	const TEXT = 'text';
	const NUMBER = 'number';
	const DATE_RANGE = 'date_range';
	const SELECT_MULTIPLE = 'select_multiple';
	const SELECT = 'select';
	const TREE = 'tree';
	const SELECTION_LIST = 'selection_list';
	
	/**
	 * Filter combo types
	 */	
	//Text
	const CONTAINS = 'contains';
	const BEGINSSWITH = 'beginswith';
	const ENDSWITH = 'endswith';
	const EQUALS = 'equals';
	const CONTAINSINFO = 'containsinfo';
	const NOTCONTAINSINFO = 'notcontainsinfo';
	
	//Number
	const LOWERTHAN = 'lowerthan';
	const LOWEREQUALSTHAN = 'lowerequalsthan';
	const GREATERTHAN = 'greaterthan';
	const GREATEREQUALSTHAN = 'greaterequalsthan';
	const DISTINCT = 'distinct';

}


class Constants{
	
	const INSERTTRANSACTION = 'insert';
	const UPDATETRANSACTION = 'update';
	const DELETETRANSACTION = 'delete';
	
}

class pptvivoConstants {
	
	const LOGIN_TYPE_NATIVE = 1;
	const LOGIN_TYPE_FACEBOOK = 2;
	const LOGIN_TYPE_TWITTER = 3;
	
	const PLAN_BASIC = 1;
	const PLAN_SILVER = 2;
	const PLAN_GOLD = 3;
	
	const USERTYPE_ADMIN = 1;
	const USERTYPE_USER = 2;
	
}