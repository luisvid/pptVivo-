<?php

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilMysql.class.php';

class PresentationsMysql extends UtilMysql {
	
	public static function getPresentations($begin, $count, $filters, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from presentation
					where userid = ' . $userId . ' 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '			
					order by creationdate DESC, title ASC
					LIMIT ' . $begin . ',' . $count . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getPresentationsCount($filters, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select count(*) numrows
					from presentation
					where userid = ' . $userId . ' 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function getPresentationById($presentationId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					presentation.*,
					exposition.id expositionid,
					exposition.exposuredate,
					note.note,
					note.slide slidenote,
					question.question,
					question.slide slidequestion
						from presentation
						left join exposition
						on exposition.presentationid = presentation.id
						left join expositionnote note
						on note.expositionid = exposition.id
						left join expositionquestion question
						on question.expositionid = exposition.id
					where presentation.id = ' . $presentationId . ' 
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getExpositionSlide($expositionId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select
					slideid
					from expositionslide 
					where expositionid = ' . $expositionId . ' 
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function insertExpositionNote($fieldsData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'insert into
					expositionnote
					(
						expositionid,
						note,
						slide,
						userid
					)
					values
					(
					' . $fieldsData ['expositionId'] . ',
					\'' . $fieldsData ['note'] . '\',
					' . $fieldsData ['slide'] . ',
					' . $fieldsData ['userId'] . '
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function insertExpositionAttendance($fieldsData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'insert into
					expositionattendant
					(
						expositionid,
						userid
					)
					values
					(
					' . $fieldsData ['expositionId'] . ',
					' . $fieldsData ['userId'] . '
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function checkExpositionAttendance($fieldsData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from expositionattendant
					where expositionid = ' . $fieldsData ['expositionId'] . '
					and userid = ' . $fieldsData ['userId'] . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function insertExpositionQuestion($fieldsData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'insert into
					expositionquestion
					(
						expositionid,
						question,
						slide,
						userid,
						questiondate
					)
					values
					(
					' . $fieldsData ['expositionId'] . ',
					\'' . $fieldsData ['question'] . '\',
					' . $fieldsData ['slide'] . ',
					' . $fieldsData ['userId'] . ',
					\'' . date("Y-m-d H:i:s") . '\'
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function getExposures($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					*
					from exposition
					where 1 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}

}