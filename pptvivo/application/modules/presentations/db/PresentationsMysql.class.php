<?php

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilMysql.class.php';

class PresentationsMysql extends UtilMysql {
	
	public static function getPresentations($begin, $count, $filters, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from presentation
					where userid = '. $userId . ' 
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
					where userid = '. $userId . ' 
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
	
	public static function deletePresentation($presentationId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete
					from presentation
					where id = ' . $presentationId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function deleteExposition($presentationId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete
					from exposition
					where presentationid = ' . $presentationId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function deleteExpositionQuestions($filters){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete
					from expositionquestion
					where 1';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function deleteExpositionNotes($filters){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete
					from expositionnote
					where 1 ';
		
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
					where presentation.id = '. $presentationId . ' 
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function insertPresentation($fieldsData){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'insert into
					presentation
					(
						title, 
						description, 
						filename, 
						userid,
						creationdate
					)
					values
					(
						\''.$fieldsData['control_title'].'\',
						\''.$fieldsData['control_description'].'\',
						\''.$fieldsData['control_filename'].'\',
						'.$fieldsData['control_userId'].',
						\''.date("Y-m-d").'\'
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function deleteExpositionAttendants($filters){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete
					from expositionattendant
					where 1 ';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}	
	
	public static function getPresentationsAttended($begin, $count, $filters, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					distinct presentation.id, presentation.*
						from expositionattendant attendant
						inner join exposition
						on attendant.expositionid = exposition.id
						inner join presentation
						on exposition.presentationid = presentation.id
						where attendant.userid = '. $userId . ' 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '			
					order by presentation.title ASC
					LIMIT ' . $begin . ',' . $count . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getPresentationByName($name, $userId) {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = 'SELECT
						id, 
						filename
					FROM presentation
					WHERE filename = \''.$name.'\'
					AND userid = '.$userId.'
			';
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	}
	
	public static function getPresentationsAttendedCount($filters, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select count(distinct presentation.id) numrows
					from expositionattendant attendant
					inner join exposition
					on attendant.expositionid = exposition.id
					inner join presentation
					on exposition.presentationid = presentation.id
					where attendant.userid = '. $userId . ' 
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
	
	public static function getAttendances($userId, $presentationId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					exposition.id expositionid,
					exposition.exposuredate
						from expositionattendant attendant
						inner join exposition
						on attendant.expositionid = exposition.id
						inner join presentation
						on exposition.presentationid = presentation.id
						where attendant.userid = '. $userId . ' and presentation.id =  ' . $presentationId . '
					order by exposition.exposuredate DESC
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getAttendanceComments($expositionId, $userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					exposition.exposuredate,
					notes.note,
					notes.slide
						from exposition
						left join expositionnote notes
						on notes.expositionid = exposition.id and notes.userid = ' . $userId . '
						where exposition.id = ' . $expositionId . '
					order by notes.slide
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}

	public static function getPresentationsExposures($begin, $count, $filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT DISTINCT 
							exposition.id, 
							exposition.exposuredate,
 							presentation.id AS presentationId,
							exposition.qrcode,
							exposition.shorturl
					FROM exposition
					INNER JOIN presentation ON exposition.presentationid = presentation.id
					WHERE 1 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '			
					order by exposition.exposuredate DESC
					LIMIT ' . $begin . ',' . $count . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getPresentationsExposuresCount($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select
					count(distinct exposition.id) numrows
					from exposition
					inner join presentation
					on exposition.presentationid = presentation.id
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
	
	public static function getExpositionAttendants($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					systemuser.*
						from systemuser
						inner join expositionattendant attendant
						on attendant.userid = systemuser.id
						where 1 
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '
					order by systemuser.username
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function insertExposition($presentationId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = 'insert into
					exposition
					(
						presentationid, 
						exposuredate
					)
					values
					(
						'.$presentationId.',
						\''.date("Y-m-d").'\'
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}

	public static function updateExposition($expositionId, $shortUrl, $qrCode){
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = 'UPDATE exposition
					SET shorturl = \''.$shortUrl.'\', 
						qrcode = \''.$qrCode.'\'
					WHERE id = ' . $expositionId
				;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	
	}
	
	public function cancelExposition($expositionId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'update
					exposition
					set active = 0
					where id = ' . $expositionId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}

	public static function getExpositionQuestions($expositionId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
				$query = 'select 
					questions.question,
					questions.slide,
					systemuser.userlogin,
					systemuser.username,
					systemuser.usersurname
					from expositionquestion questions
					inner join systemuser
					on questions.userid = systemuser.id
					where
						questions.expositionid = ' . $expositionId . '
					order by
						questions.slide, questions.questiondate
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}

	public static function updateExpositionSlide($expositionId, $slideId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'update
					expositionslide
					set slideid = ' . $slideId . '
					where expositionid = ' . $expositionId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function insertExpositionSlide($expositionId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'insert into
					expositionslide
					(
						expositionid,
						slideid
					)
					values
					(
						' . $expositionId . ',
						1
					)
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function deleteExpositionSlide($expositionId){
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'delete from
					expositionslide
					where expositionid = ' . $expositionId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
}