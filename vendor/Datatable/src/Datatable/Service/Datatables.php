<?php

/*
 * @author Samier Sompura <>
 */

namespace Datatable\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;

function custom($dateObj)
{
	if($dateObj)
	{
            return  $dateObj->format('Y-m-d H:i:s');
	}
	return '';
}

function checkImage($id,$image)
{
	if(file_exists(getcwd().'/public/upload/userImage/crop_'.$image))
            return '<a href="/addressbook/contactdetails/'.$id.'"><img src="/upload/userImage/crop_'.$image.'" height="40" width="40" class="img-rounded img-link" name="userImage"></a>';
        else
            return '<a href="/addressbook/contactdetails/'.$id.'"><img src="/upload/userImage/crop_user_default.png" height="40" width="40" class="img-rounded img-link" name="userImage"></a>';
}

function changeformat($dateObj)
{
	if($dateObj)
	{
		return  $dateObj->format('d-M-Y');
	}
	return '';
}

function getCompanyLink($companyName)
{
    return '<a href="/company/profile/'.str_replace(' ','-',$companyName).'" target="_new">'.$companyName.'</a>';
}

function lastLogin($dateString)
{
		
	if($dateString)
	{	
		$last_login = '';
		$date = $dateString->format('Y-m-d H:i:s');
		
		$lastDate = new \DateTime($date);
		//$lastDate = $lastDate->format('Y-m-d H:i:s');
		
		$currentDate = new \DateTime('now');
		//$currentDate = $currentDate->format('Y-m-d H:i:s');
		
		$interval = date_diff($lastDate,$currentDate);
		if($interval->format('%y') != 0 )
			$last_login = ' '.$interval->format('%y year');
		if($interval->format('%m') != 0)
			$last_login .= ' '.$interval->format('%m month');
		if($interval->format('%d') != 0)
			$last_login .= ' '.$interval->format('%d day');
		if($interval->format('%H') != 0)
			$last_login .= ' '.$interval->format('%H hour');
		if($interval->format('%i') != 0)
			$last_login .= ' '.$interval->format('%i minute');
			
		return $last_login;
	}
	return '';
}

/**
  * phone number convert json string to string
  *
 */
 
function convertPhoneNo($jsonphone)
{
    $phone_string = '';
    
    if (!empty($jsonphone))
    {
        if(strpos($jsonphone,'":"') == true)
        {
            $phone_array = (array)json_decode($jsonphone);
            foreach($phone_array as $key => $value)
            {
                $phone_string .=  $value."<br>";	
            }
        }
        else
            $phone_string = $jsonphone;
    }
    return $phone_string;

}
  /**
	* imageDisplay function used in dataTable of campaings List.
	*
	*/
function imageDisplay($email,$sms,$twitter,$facebook,$campId)
{
	if($email == 1)
		$emaildata = '<a href="#campaign_setting" title="Mail" onclick="getprofileDataFromCampaigns('.$campId.')" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/email-icon.jpg" class="EMAIL1" width="20" height="20" alt="email" /></a> ';
	else
		$emaildata = ' ';
	if($sms == 1)
		$smsdata = '<a href="#campaign_setting" title="SMS" onclick="getprofileDataFromCampaigns('.$campId.')" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/sms.jpg" class="SMS1" width="20" height="20" alt="SMS" /></a> ';
	else
		$smsdata = ' ';
	if($twitter == 1)
		$twitterdata = '<a href="#campaign_setting" title="Twitter" onclick="getprofileDataFromCampaigns('.$campId.')" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/webicon-twitter-s.png" class="TWITTER1" width="20" height="20"'
					 . ' alt="twitter" /></a> ';
	else
		$twitterdata = ' ';
	if($facebook == 1)
		$facebookdata = '<a href="#campaign_setting" title="Facebook" onclick="getprofileDataFromCampaigns('.$campId.')" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/webicon-facebook-s.png" class="FACEBOOK1" width="20" height="20"'
					  . '  alt="twitter" /></a> ';
	else
		$facebookdata = ' ';
	
	return $emaildata.$smsdata.$twitterdata.$facebookdata;
}

  /**
	* prospectStatus function used in dataTable of prospect List.
	*
	*/
function campaignStatus($status,$campId)
{
	if($status == 'Active')
		return '<a class="btn btn-flat btn-success fullround actpd" onclick="changeCampStatus('.$campId.',1)"'
				. ' href="javascript:void(0)" title="Active"><i class="icon-ok"></i></a>';
	else
		return '<a class="btn btn-flat btn-danger fullround actpd" onclick="changeCampStatus('.$campId.',0)"'
				. ' href="javascript:void(0)" title="Pause"><i class="icon-minus"></i></a>';
}
  
  /**
	* prospectStatus function used in dataTable of prospect List.
	*
	*/
function prospectStatus($status,$prosId)
{
	if($status == 'Active')
		return '<a class="btn btn-flat btn-success fullround actpd" onclick="changeProsStatus('.$prosId.',1)"'
				. ' href="javascript:void(0)" title="Active"><i class="icon-ok"></i></a>';
	else
		return '<a class="btn btn-flat btn-danger fullround actpd" onclick="changeProsStatus('.$prosId.',0)"'
				. ' href="javascript:void(0)" title="Pause"><i class="icon-minus"></i></a>';
}

  /**
	* Display remaining time in dataTable of messages List.
	*
	*/
function remainingTime($date)
{
	$newDate1 = $date;//explode(' ',$date);
	$newDate2 = date('Y-m-d H:i:s');
	$start_ts = strtotime($newDate1);
  	$end_ts = strtotime($newDate2);
  	$diff = $start_ts - $end_ts;
	
	$DAYS = round($diff / 86400);
	
	if($DAYS > 0 && $DAYS == 1)
			return $DAYS.' Day';
	else if($DAYS > 0)
			return $DAYS.' Days';
	else if($DAYS < 0 && $DAYS == -1) 
			return abs($DAYS).' Day Ago';
	else if($DAYS < 0)
		 	return abs($DAYS).' Days Ago';
	else if($DAYS == 0)
		 {
			$HOURS = round($diff / 3600);
		 	if($HOURS > 0)
				return $HOURS.' Hours';
			else if($HOURS < 0)
				return abs($HOURS).' Hours Ago';
			else if($HOURS == 0)
				 {
					$MINUTES = round($diff / 60);
					if($MINUTES > 0)
						return $MINUTES.' Minutes';
					else if($MINUTES < 0)
						return abs($MINUTES).' Minutes Ago';
					else if($MINUTES == 0)
				 			return 'immediately'; 
				 }
		 }
}
  
  /**
	* Date convert into other format used in dataTable of messages List.
	*
	*/
function dateConvert($userDate,$timeZone)
{
	$date = new \DateTime($userDate);
	$date->setTimeZone(new \DateTimeZone($timeZone));
	$StringDate = $date->format('Y-m-d H:i:s');
	
	$date = date('D, M j, Y @ H:i', strtotime($StringDate));
	return $date;//
}

  /**
	* Only scheduled message image Display used in dataTable of messages List.
	*
	*/
function scheduledMsgImgDisplay($email,$sms,$twitter,$facebook,$alertSMS)
{
	if ($email !== NULL && $email !== '')
		$emaildata = '<a href="#campaign_setting" title="Mail" onclick="getprofileDataFromMessages()" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/email-icon.jpg" class="EMAIL1" width="20" height="20" alt="email" /></a> ';
	else
		$emaildata = ' ';
	if ($sms !== NULL && $sms !== '')
		$smsdata = '<a href="#campaign_setting" title="SMS" onclick="getprofileDataFromMessages()" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/sms.jpg" class="SMS1" width="20" height="20" alt="SMS" /></a> ';
	else
		$smsdata = ' ';
	if ($twitter !== NULL && $twitter !== '')
		$twitterdata = '<a href="#campaign_setting" title="Twitter" onclick="getprofileDataFromMessages()" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/webicon-twitter-s.png" class="TWITTER1" width="20" height="20"'
					 . ' alt="twitter" /></a> ';
	else
		$twitterdata = ' ';
	if ($facebook !== NULL && $facebook !== '')
		$facebookdata = '<a href="#campaign_setting" title="Facebook" onclick="getprofileDataFromMessages()" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/webicon-facebook-s.png" class="FACEBOOK1" width="20" height="20"'
					  . '  alt="facebook" /></a> ';
	else
		$facebookdata = ' ';
	if ($alertSMS !== NULL && $alertSMS !== '')
		$alertSMSData = '<a href="#campaign_setting" title="AlertSMS" onclick="getprofileDataFromMessages()" data-strict-close="true" data-toggle="modal"><img src="/public/images/webicons/sms-alert.png" class="FACEBOOK1" width="20" height="20"'
					  . ' alt="alertSMS" /></a> ';
	else
		$alertSMSData = ' ';
	
	return $emaildata.$smsdata.$twitterdata.$facebookdata.$alertSMSData;
}

function UserDealType($dealType)
{
    if (!empty($dealType))
    {
        $responce = '';
        $dealTypeArray = explode(',',str_replace('"','',$dealType));
        if(count($dealTypeArray) > 0)
        {
            foreach ($dealTypeArray as $key => $dealValue)
            {
                if(!empty($dealValue))
                   $responce .= $dealValue.'<br/>';  
            }    
        }
        else
           $responce = 'Not Found';  
    }
    else
        $responce = 'Not Found';
    
    return $responce;
}

class Datatables extends AbstractActionController implements ServiceManagerAwareInterface
{
	/**
	* Global container variables for chained argument results
	*
	*/
	private $ci;
	private $table;
	private $distinct;
	private $group_by;
	private $select         = array();
	private $joins          = array();
	private $columns        = array();
	private $where          = array();
	private $filter         = array();
	private $add_columns    = array();
	private $edit_columns   = array();
	private $unset_columns  = array();
	static $cmpId;
	
 /**
	* @var Query Builder Object
	*/
	protected $queryBuilder;
	
 /**
	* @var Entity Name
	*/
	protected $entity_name;
	
 /**
	* @var Entity Alias
	*/
	protected $entity_alias;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager;
	
	/**             
	 * @var Doctrine\ORM\EntityManager
 	 */                
	protected $entityManager;
	
	/**
	 * @param ServiceManager $serviceManager
	 * @return Form
	 */
	public function setServiceManager(ServiceManager $serviceManager)
	{
			$this->serviceManager = $serviceManager;
			$this->entityManager  = $serviceManager->get('doctrine.entitymanager.orm_default');
			$this->queryBuilder   = $this->entityManager->createQueryBuilder();
			return $this;
	}
	
 /**
	* If you establish multiple databases in config/dat abase.php this will allow you to
	* set the database (other than $active_group) - more info: http://ellislab.com/forums/viewthread/145901/#712942
	*/
	public function set_database($db_name)
	{
		$db_data = $this->ci->load->database($db_name, TRUE);
		$this->ci->db = $db_data;
	}

	/**
	 * set entity using from
	 * 
	 * @param type $entity_name
	 * @param type $entity_alias
	 * 
	 * @return Datatable 
	 */
	public function from($entity_name, $entity_alias)
	{
			$this->entity_name  = $entity_name;
			$this->entity_alias = $entity_alias;
			$this->queryBuilder->from($entity_name, $entity_alias);
			return $this;
	}

	/**
	* Generates the SELECT portion of the query
	*
	* @param string $columns
	* @param bool $backtick_protect
	* @return mixed
	*/
	public function select($columns, $backtick_protect = TRUE)
	{
		foreach($this->explode(',', $columns) as $val)
		{
			$column = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$2', $val));
			$this->columns[] =  $column;
			$this->select[$column] =  trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$1', $val));
		}

		$this->queryBuilder->select($columns);
		return $this;
	}

	/**
	* Generates the DISTINCT portion of the query
	*
	* @param string $column
	* @return mixed
	*/
	public function distinct($column)
	{
		$this->distinct = $column;
		$this->ci->db->distinct($column);
		return $this;
	}

	/**
	* Generates the GROUP_BY portion of the query
	*
	* @param string $column
	* @return mixed
	*/
	public function groupBy($column)
	{
		$this->queryBuilder->groupBy($column);
		return $this;
	}
	
	/**
	* Generates the ORDER_BY portion of the query
	*
	* @param string $column
	* @return mixed
	*/
	public function orderBy($column,$type)
	{
		$this->queryBuilder->orderBy($column,$type);
		return $this;
	}

	/**
	* Generates the JOIN portion of the query
	*
	* @param string $table
	* @param string $fk
	* @param string $type
	* @return mixed
	*/
	public function join($entity,$alias,$type,$fk)
	{
		$this->queryBuilder->innerJoin($entity,$alias,$type,$fk);
		return $this;
	}
	
	/**
	* Generates the LEFT JOIN portion of the query
	*
	* @param string $table
	* @param string $fk
	* @param string $type
	* @return mixed
	*/
	public function leftjoin($entity,$alias,$type,$fk)
	{
		$this->queryBuilder->leftJoin($entity,$alias,$type,$fk);
		return $this;
	}

	/**
	* Generates the WHERE portion of the query
	*
	* @param mixed $key_condition
	* @param string $val
	* @return mixed
	*/
	public function where($key_condition)
	{
		$this->queryBuilder->andwhere($key_condition);
		return $this;
	}

	/**
	* Generates the WHERE portion of the query
	*
	* @param mixed $key_condition
	* @param string $val
	* @return mixed
	*/
	public function orwhere($key_condition)
	{
		$this->queryBuilder->orwhere($key_condition);
		return $this;
	}

	/**
	* Generates the WHERE portion of the query
	*
	* @param mixed $key_condition
	* @param string $val
	* @param bool $backtick_protect
	* @return mixed
	*/
	public function filter($key_condition, $val = NULL, $backtick_protect = TRUE)
	{
		$this->filter[] = array($key_condition, $val, $backtick_protect);
		return $this;
	}

 /**
	* Generates an AND %LIKE% portion of the query
	*
	* @param mixed $key_condition
	* @param string $val
	* @return mixed
	*/
	public function like($key,$val)
	{
		$this->queryBuilder->where($this->queryBuilder->expr()->like($key, $qb->expr()->literal('%' . $val . '%')));
		return $this;
	}

 /**
	* Generates a OR %LIKE% portion of the query
	*
	* @param mixed $key_condition
	* @param string $val
	* @return mixed
	*/
	public function orlike($key,$val)
	{
		$this->queryBuilder->orwhere($this->queryBuilder->expr()->like($key, $qb->expr()->literal('%' . $val . '%')));
		return $this;
	}

	/**
	* Sets additional column variables for adding custom columns
	*
	* @param string $column
	* @param string $content
	* @param string $match_replacement
	* @return mixed
	*/
	public function add_column($column, $content, $match_replacement = NULL)
	{
		$this->add_columns[$column] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
		return $this;
	}

	/**
	* Sets additional column variables for editing columns
	*
	* @param string $column
	* @param string $content
	* @param string $match_replacement
	* @return mixed
	*/
	public function edit_column($column, $content, $match_replacement)
	{
		$this->edit_columns[$column][] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
		//print_r($this);exit ('this is in replacement');
		return $this;
	}

	/**
	* Unset column
	*
	* @param string $column
	* @return mixed
	*/
	public function unset_column($column)
	{
		$this->unset_columns[] = $column;
		return $this;
	}

	/**
	* Builds all the necessary query segments and performs the main query based on results set from chained statements
	*
	* @param string charset
	* @return string
	*/
	public function generate($charset = 'UTF-8')
	{
		$this->get_paging();
		$this->get_ordering();
		$this->get_filtering();
		return $this->produce_output($charset);
	}

	/**
	* Generates the LIMIT portion of the query
	*
	* @return mixed
	*/
	private function get_paging()
	{
		$iStart  = isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : '';
		$iLength = isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : '';;
		$this->queryBuilder->setFirstResult(($iStart) ? $iStart : 0);
    $this->queryBuilder->setMaxResults(($iLength != '' && $iLength != '-1') ? $iLength : 100);
	}

	/**
	* Generates the ORDER BY portion of the query
	*
	* @return mixed
	*/
	private function get_ordering()
	{
		if($this->check_mDataprop())
			$mColArray = $this->get_mDataprop();
		elseif(isset($_REQUEST['sColumns']) and is_array($_REQUEST['sColumns']) )
			$mColArray = explode(',', $_REQUEST['sColumns']);
		else
			$mColArray = $this->columns;

		$mColArray = array_values(array_diff($mColArray, $this->unset_columns));
		$columns = array_values(array_diff($this->columns, $this->unset_columns));

		if (isset($_REQUEST['iSortingCols']))
		for($i = 0; $i < intval($_REQUEST['iSortingCols']); $i++)
			if(isset($mColArray[intval($_REQUEST['iSortCol_' . $i])]) && in_array($mColArray[intval($_REQUEST['iSortCol_' . $i])], $columns) && $_REQUEST['bSortable_'.intval($_REQUEST['iSortCol_' . $i])] == 'true')
			  $this->queryBuilder->add(
				'orderBy',
				$mColArray[intval($_REQUEST['iSortCol_' . $i])] . ' ' . $_REQUEST['sSortDir_' . $i]);
			//	$this->ci->db->order_by($mColArray[intval($_REQUEST['iSortCol_' . $i])], $_REQUEST['sSortDir_' . $i]);
	}

	/**
	* Generates a %LIKE% portion of the query
	*
	* @return mixed
	*/
	private function get_filtering()
	{
		if($this->check_mDataprop())
			$mColArray = $this->get_mDataprop();
		elseif(isset($_REQUEST['sColumns']) and is_array($_REQUEST['sColumns']))
			$mColArray = explode(',', $_REQUEST['sColumns']);
		else
			$mColArray = $this->columns;

		$sWhere    = '';
		$sSearch   = addslashes (isset($_REQUEST['sSearch'])? $_REQUEST['sSearch'] : '');
		$mColArray = array_values(array_diff($mColArray, $this->unset_columns));
		$columns   = array_values(array_diff($this->columns, $this->unset_columns));

		// Search Filter
		if($sSearch != '')
		{
                        $orCondition = false;
			$cnt = count($mColArray);
			for($i = 0; $i < $cnt; $i++)
				if(isset($_REQUEST['bSearchable_' . $i]) && $_REQUEST['bSearchable_' . $i] == 'true' && in_array($mColArray[$i], $columns))
				{
                                    if($orCondition == false)
                                    {    
                                        $this->queryBuilder->andwhere(
							$this->queryBuilder->expr()->lower($this->select[$mColArray[$i]]) 
							. ' like LOWER(' . $this->queryBuilder->expr()->literal('%' . $sSearch . '%').') '
						);
                                        $orCondition = true;
                                    }
                                    else
                                        $this->queryBuilder->orwhere(
							$this->queryBuilder->expr()->lower($this->select[$mColArray[$i]]) 
							. ' like LOWER(' . $this->queryBuilder->expr()->literal('%' . $sSearch . '%').') '
						);
				}		
		} // End Search Filter
						
		if(isset($_REQUEST['iColumns']))
		for($i = 0; $i < intval($_REQUEST['iColumns']); $i++)
		{
			if(isset($_REQUEST['sSearch_' . $i]) && $_REQUEST['sSearch_' . $i] != '' && in_array($mColArray[$i], $columns))
			{
				$miSearch = explode(',', $_REQUEST['sSearch_' . $i]);

				foreach($miSearch as $val)
				{
					if(preg_match("/(<=|>=|=|<|>)(\s*)(.+)/i", trim($val), $matches))
						$this->queryBuilder->andwhere(
							$this->select[$mColArray[$i]] 
							. ' ' . $matches[1] . '=' . $matches[3]);
					else
						$this->queryBuilder->andwhere(
							$this->select[$mColArray[$i]] 
							. ' LIKE LOWER(' . $qb->expr()->literal('%'. $val . '%').')'
						)	;
				}
			}
		}

		foreach($this->filter as $val)
			$this->queryBuilder->andwhere (
				$this->entity_alias . '.' . $val[0] . '=' . $val[1]
			);
	}


	/**
	* Compiles the select statement based on the other functions called and runs the query
	*
	* @return mixed
	*/
	private function get_display_result()
	{
		$q = $this->queryBuilder->getQuery();
		//echo $q->getSql();
		return $q->getResult();
	}

	/**
	* Builds a JSON encoded string data
	*
	* @param string charset
	* @return string
	*/
	private function produce_output($charset)
	{
		$aaData = array();
		$rResult = $this->get_display_result();
		$iTotal = $this->get_total_results();
		$iFilteredTotal = $this->get_total_results(TRUE);

		foreach($rResult as $row_key => $row_val)
		{
			$aaData[$row_key] = ($this->check_mDataprop())? $row_val : array_values($row_val);

			foreach($this->add_columns as $field => $val)
				if($this->check_mDataprop())
					$aaData[$row_key][$field] = $this->exec_replace($val, $aaData[$row_key]);
				else
					$aaData[$row_key][] = $this->exec_replace($val, $aaData[$row_key]);

			foreach($this->edit_columns as $modkey => $modval)
				foreach($modval as $val)
					$aaData[$row_key][($this->check_mDataprop())? $modkey : array_search($modkey, $this->columns)] = $this->exec_replace($val, $aaData[$row_key]);

			$aaData[$row_key] = array_diff_key($aaData[$row_key], ($this->check_mDataprop())? $this->unset_columns : array_intersect($this->columns, $this->unset_columns));

			if(!$this->check_mDataprop())
				$aaData[$row_key] = array_values($aaData[$row_key]);
		}

		$sColumns = array_diff($this->columns, $this->unset_columns);
		$sColumns = array_merge_recursive($sColumns, array_keys($this->add_columns));

		$sOutput = array
		(
			'sEcho'                => intval(isset($_REQUEST['sEcho']) ? $_REQUEST['sEcho'] : ''),
			'iTotalRecords'        => $iTotal,
			'iTotalDisplayRecords' => $iFilteredTotal,
			'aaData'               => $aaData,
			'sColumns'             => implode(',', $sColumns)
		);

		if(strtolower($charset) == 'utf-8')
			return json_encode($sOutput);
		else
			return $this->jsonify($sOutput);
	}

	/**
	* Get result count
	*
	* @return integer
	*/
	private function get_total_results($filtering = FALSE)
	{
		// Add Count to select
		$this->queryBuilder->select('count(' . $this->entity_alias . ') as total');		
			
		if($filtering)
			$this->get_filtering();

		// Reset Max Result	
		$this->queryBuilder->setFirstResult(NULL);
    $this->queryBuilder->setMaxResults(NULL);
		
		$this->queryBuilder->resetDQLPart('groupBy');
			
		$result = $this->queryBuilder->getQuery()->getSingleResult();
		return $result['total'];
	}

	/**
	* Runs callback functions and makes replacements
	*
	* @param mixed $custom_val
	* @param mixed $row_data
	* @return string $custom_val['content']
	*/
	private function exec_replace($custom_val, $row_data)
	{
		$replace_string = '';

		if(isset($custom_val['replacement']) && is_array($custom_val['replacement']))
		{
			foreach($custom_val['replacement'] as $key => $val)
			{
				
				$sval = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($val));


				if(preg_match('/(.*)\((.*)\)/i', $val, $matches) && function_exists($matches[1]))
				{
					$func = $matches[1];
					$args = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[,]+/", $matches[2], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

					foreach($args as $args_key => $args_val)
					{
						$args_val = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($args_val));
						$args[$args_key] = (in_array($args_val, $this->columns))? ($row_data[($this->check_mDataprop())? $args_val : array_search($args_val, $this->columns)]) : $args_val;
					}

					$replace_string = call_user_func_array($func, $args);
				}
				elseif(in_array($sval, $this->columns))
					$replace_string = $row_data[($this->check_mDataprop())? $sval : array_search($sval, $this->columns)];
				else
					$replace_string = $sval;

				$custom_val['content'] = str_ireplace('$' . ($key + 1), $replace_string, $custom_val['content']);
			}
		}

		return $custom_val['content'];
	}

	/**
	* Check mDataprop
	*
	* @return bool
	*/
	private function check_mDataprop()
	{
		if(isset($_REQUEST['mDataProp_0']) and !$_REQUEST['mDataProp_0'])
			return FALSE;
			
		if(isset($_REQUEST['iColumns'])) 
		for($i = 0; $i < intval($_REQUEST['iColumns']); $i++)
			if(isset($_REQUEST['mDataProp_' . $i]) and !is_numeric($_REQUEST['mDataProp_' . $i]))
				return TRUE;

		return FALSE;
	}

	/**
	* Get mDataprop order
	*
	* @return mixed
	*/
	private function get_mDataprop()
	{
		$mDataProp = array();

		for($i = 0; $i < intval($_REQUEST['iColumns']); $i++)
			$mDataProp[] = $_REQUEST['mDataProp_' . $i];

		return $mDataProp;
	}

	/**
	* Return the difference of open and close characters
	*
	* @param string $str
	* @param string $open
	* @param string $close
	* @return string $retval
	*/
	private function balanceChars($str, $open, $close)
	{
		$openCount = substr_count($str, $open);
		$closeCount = substr_count($str, $close);
		$retval = $openCount - $closeCount;
		return $retval;
	}

	/**
	* Explode, but ignore delimiter until closing characters are found
	*
	* @param string $delimiter
	* @param string $str
	* @param string $open
	* @param string $close
	* @return mixed $retval
	*/
	private function explode($delimiter, $str, $open = '(', $close=')')
	{
		$retval = array();
		$hold = array();
		$balance = 0;
		$parts = explode($delimiter, $str);

		foreach($parts as $part)
		{
			$hold[] = $part;
			$balance += $this->balanceChars($part, $open, $close);

			if($balance < 1)
			{
				$retval[] = implode($delimiter, $hold);
				$hold = array();
				$balance = 0;
			}
		}

		if(count($hold) > 0)
			$retval[] = implode($delimiter, $hold);

		return $retval;
	}

	/**
	* Workaround for json_encode's UTF-8 encoding if a different charset needs to be used
	*
	* @param mixed result
	* @return string
	*/
	private function jsonify($result = FALSE)
	{
		if(is_null($result))
			return 'null';

		if($result === FALSE)
			return 'false';

		if($result === TRUE)
			return 'true';

		if(is_scalar($result))
		{
			if(is_float($result))
				return floatval(str_replace(',', '.', strval($result)));

			if(is_string($result))
			{
				static $jsonReplaces = array(array('\\', '/', '\n', '\t', '\r', '\b', '\f', '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $result) . '"';
			}
			else
				return $result;
		}

		$isList = TRUE;

		for($i = 0, reset($result); $i < count($result); $i++, next($result))
		{
			if(key($result) !== $i)
			{
				$isList = FALSE;
				break;
			}
		}

		$json = array();

		if($isList)
		{
			foreach($result as $value)
				$json[] = $this->jsonify($value);

			return '[' . join(',', $json) . ']';
		}
		else
		{
			foreach($result as $key => $value)
				$json[] = $this->jsonify($key) . ':' . $this->jsonify($value);

			return '{' . join(',', $json) . '}';
		}
	}
}
