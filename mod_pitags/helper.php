<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.utilities.string' );
jimport( 'joomla.database.database' );

abstract class modPitagsHelper
{
	/**
	 * Get tags data for tag cloud
	 * @param unknown_type $params module params
	 */
	public static function getTags($params)
	{
		//Initialize tags data
		$tagdata = modPitagsHelper::initialiseTagsData($params);

		//Get rows with tag data from database
		$rows = modPitagsHelper::getMessagesTags();

		//Prepare tag data
		$tagdata = modPitagsHelper::extractTagsData($tagdata, $rows);

		//Throw out tags from tag list that are below minimum tag count
		$threshold_count = $params->get('threshold_count', 1);
		$threshold_count = $threshold_count<1 ? 1 : $threshold_count;
		$tagdata->tagarray = modPitagsHelper::applyThresholdCount($tagdata->tagarray, $threshold_count);
		$tagdata->minWeight = $threshold_count;
		
		//Truncate tag array
		$items = $params->get('items', 20);
		$tagdata->tagarray = modPitagsHelper::truncateTagArray($tagdata->tagarray, $items);

		//Set output order
		$sort = $params->get('orderby', 0);
		$tagdata->tagarray = modPitagsHelper::setOutputOrderTagArray($tagdata->tagarray, $sort);

		//Calculate tag cloud data
		$tagdata = modPitagsHelper::calculateTagCloud($tagdata, $params);

		return $tagdata;
	}

	/**
	 * tag data object initialisation
	 * @param unknown_type $params module params
	 */
	private static function initialiseTagsData(&$params)
	{
		//result data
		$data = new stdClass();
		$data->count = 0; //different tags count
		$data->minWeight = 1073741823; //minimum weight
		$data->maxWeight = -1073741823; //maximum weight
		$data->minSize = $params->get('min', 8); //minimum size (output)
		$data->maxSize = $params->get('max', 24); //maximum size (output)
		$data->tagarray = array(); // tags data

		return $data;
	}

	/**
	 * Retrieves tags data from database
	 * @return array() object array with tag data strings
	 */
	private static function getMessagesTags()
	{
		$db= JFactory::getDBO();
		$nullDate = $db->getNullDate(); //since Joomla 1.5
		$now = gmdate ( 'Y-m-d H:i:s' ); //gmdate ( $db->getDateFormat() ); // since Joomla 1.7
		$language = JFactory::getLanguage()->getTag();
		$jversion = new JVersion();
		$version = substr($jversion->getShortVersion(), 0, 3);
		if ($version >= 3.2)
		{
			$query = "SELECT id FROM #__pistudies WHERE published = '1' AND (publish_up = '"
					.$nullDate."' OR publish_up <= '".$now."')"
					." AND (publish_down = '".$nullDate."'"
					."OR publish_down >= '".$now."') AND language IN (".$db->quote($language).",".$db->quote("*").")";
		}
		else {
			$query = "SELECT id, tags FROM #__pistudies WHERE published = '1' AND (publish_up = '"
					.$nullDate."' OR publish_up <= '".$now."')"
					." AND (publish_down = '".$nullDate."'"
					."OR publish_down >= '".$now."') AND language IN (".$db->quote($language).",".$db->quote("*").")";
		}

		$db->setQuery( $query );

		$rows = $db->loadObjectList();
		return $rows;
	}

	/**
	 * Get raw data for tag cloud.
	 * @param $data results object
	 * @param array() $rows objects in array must have member tags, a string with tags (comma separated).
	 * @return stdClass with raw data.
	 */
	private static function extractTagsData(&$data, &$rows)
	{
		$string = '';
		$tagarray = array();
		foreach ($rows as &$row)
		{
			$jversion = new JVersion();
			$version = substr($jversion->getShortVersion(), 0, 3);
			if ($version >= 3.2)
			{
				$tags = new JHelperTags;
				$tags->getItemTags('com_preachit.study' , $row->id);
				$taglist = $tags->itemTags; 
			}
			else {
				$string = $row->tags;
				//$string = $row->study_name;
				if (!$string || $string=='')
				continue;
				$taglist = explode(',', $string);
			}
			
			if (!is_array($taglist) || empty($taglist))
			{
				continue;
			}

			foreach ($taglist as &$tag)
			{
				//sanitise tag
				if ($version >= 3.2)
				{
					$t = JString::trim($tag->title);
				}
				else {$t = JString::trim($tag);}
				if ($t=='')
				{
					continue;
				}

				//save tag and count
				$tn = null;
				if (isset($tagarray[$t]))
				{
					$tn = $tagarray[$t];
				}
				else
				{
					//Create new tag data object
					$tn = new stdClass();
					$tn->name = $t;
					$tn->count = 0;
					if (isset($tag->id))
					{$tn->id = $tag->id;
					$tn->alias = $tag->alias;}

					$data->count += 1;
				}
				$tn->count += 1;
				$tagarray[$t] = $tn;

				//Determine min/max weight
				$data->minWeight = min($data->minWeight, $tn->count);
				$data->maxWeight = max($data->maxWeight, $tn->count);
			}
		}

		//sort array from most popular to least popular
		uasort($tagarray, array('self', 'cmpTagCountDesc'));
		$data->tagarray = $tagarray;
		return $data;
	}

	/**
	 * Delete tags with count less than threshold.
	 * @param array() $tagarray tag array
	 * @param int $threshold_count threshold for tag count. 
	 * @return tag array with tag count over threshold
	 */
	private static function applyThresholdCount(&$tagarray, $threshold_count)
	{
		if ($threshold_count == 1)
		{
			return $tagarray;
		}
		$newtagarray = array();
		foreach ($tagarray as &$tag)
		{
			if ($tag->count >= $threshold_count)
			{
				$newtagarray[] = $tag;
			}
		}
		return $newtagarray;
	}

	/**
	 * Truncate tag array
	 * @param array() $tagarray tag array
	 * @param int $items new size
	 * @return truncated array
	 */
	private static function truncateTagArray(&$tagarray, $items)
	{
		//cut array to the right size
		return array_slice($tagarray, 0, $items-1);
	}

	/**
	 * Sort tag array for output
	 * @param array() $tagarray array of tag objects
	 * @param int $sort sort type
	 * @return sorted array
	 */
	private static function setOutputOrderTagArray(&$tagarray, $sort)
	{
		//sort output tags according to sort param
		if ($sort == 0)
		{
			//Randomize
			shuffle($tagarray);
			$tags = $tagarray;
		}
		elseif ($sort == 1)
		{
			//Tag Count (High to Low)
			$tags = $tagarray;
		}
		elseif ($sort == 2)
		{
			//Tag Count (Low to High)
			$tags = array_reverse($tagarray);
		}
		elseif ($sort == 3)
		{
			//Alphabetical (descending)
			uasort($tagarray, array('self', 'cmpTagAlphabeticalAsc'));
			$tags = array_reverse($tagarray);
		}
		elseif ($sort == 4)
		{
			//Alphabetical (ascending)
			uasort($tagarray, array('self', 'cmpTagAlphabeticalAsc'));
			$tags = $tagarray;
		}
		else
		{
			//High to Low
			$tags = $tagarray;
		}
		return $tags;
	}

	/**
	 * Compare function for tag array. Sort criteria: tag count reverse
	 * @param stdClass $a tag object A
	 * @param stdClass $b tag object B
	 * @return -1, if lesser; 0, if equal; +1 if greater.
	 */
	private static function cmpTagCountDesc(&$a, &$b)
	{
		$va = $a->count;
		$vb = $b->count;
		if ($va == $vb)
		{
			return 0;
		}
		return ($va < $vb) ? +1 : -1;
	}

	/**
	 * Compare function for tag array. Sort criteria: tag name alphabetical ascending
	 * @param stdClass $a tag object A
	 * @param stdClass $b tag object B
	 * @return -1, if lesser; 0, if equal; +1 if greater.
	 */
	private static function cmpTagAlphabeticalAsc(&$a, &$b)
	{
		return JString::strcasecmp($a->name, $b->name);
	}

	/**
	 * Calculate tag cloud data.
	 * @param array() $data tags data
	 * @param unknown_type $params module params
	 */
	private static function calculateTagCloud(&$data, &$params)
	{
		$distribution = $params->get('distribution', 1);
		$buckets = $params->get('buckets', 10);
		if ($buckets==0)
		{
			if ($distribution==0)
			{
				$data = modPitagsHelper::getLinearTagCloud($data, $params);
			}
			else
			{
				$data = modPitagsHelper::getLogarithmicTagCloud($data, $params);
			}
		}
		else
		{
			$data = modPitagsHelper::getBucketsTagCloud($data, $buckets, $distribution);
		}
		return $data;
	}

	/**
	 * Generates a Bucket Tag Cloud
	 * @param array() $data tag data
	 * @param int $buckets bucket count
	 * @param int $type size distribution type
	 */
	private static function getBucketsTagCloud(&$data, $buckets, $type)
	{
		$deltaWeight = $data->maxWeight - $data->minWeight;
		$deltaSize = $data->maxSize - $data->minSize;

		//Prepare data for limited buckets
		$thresholds = array();
		if ($deltaWeight!=0 && $deltaSize!=0)
		{
			$stepWeight = $deltaWeight / $buckets;
			$stepSize = $deltaSize / $buckets;
			//Precalculate threshold weights and output sizes
			for ($i=1; $i < $buckets; $i++)
			{
				$td = new stdClass();
				$td->thresholdWeight = modPitagsHelper::calcWeight($data->minWeight + $stepWeight * $i, $type);
				$td->bucketSize = $data->minSize + $stepSize * ($i - 1);
				$thresholds[] = $td;
			}
		}
		$td = new stdClass();
		$td->thresholdWeight = modPitagsHelper::calcWeight($data->maxWeight, $type);
		$td->bucketSize = $data->maxSize;
		$thresholds[] = $td;

		foreach ($data->tagarray as &$tag)
		{
			$size = $data->minSize;
			//determine bucket
			foreach ($thresholds as &$threshold)
			{
				if (modPitagsHelper::calcWeight($tag->count, $type) <= $threshold->thresholdWeight)
				{
					$size = $threshold->bucketSize;
					break;
				}
			}
			$tag->size = $size;
		}

		return $data;
	}
	/**
	 * Weight calculating function 
	 * @param float $value value
	 * @param int $type distribution type
	 * @return float weight
	 */
	private static function calcWeight($value, $type=0)
	{
		if ($type==1) // Logarithmic Distribution
			return 100.0 * log(2.0 + $value);
		return $value; //Linear Distribution
	}
	
	/**
	 * Generates a linear Tag Cloud
	 * @param array() $data tag data
	 * @param unknown_type $params module params
	 */
	private static function getLinearTagCloud(&$data, &$params)
	{
		$deltaWeight = $data->maxWeight - $data->minWeight;
		$deltaSize = $data->maxSize - $data->minSize;

		$delta = 0;
		if ($deltaWeight!=0 && $deltaSize!=0)
		{
			$delta = $deltaSize / $deltaWeight;
		}

		foreach ($data->tagarray as &$tag)
		{
			if ($tag->count == $data->minWeight)
			{
				$size = $data->minSize;
			}
			elseif ($tag->count == $data->maxWeight)
			{
				$size = $data->maxSize;
			}
			else
			{
				$size = $data->minSize + $delta * $tag->count;
			}
			$tag->size = $size;
		}

		return $data;
	}

	/**
	 * Generates a Logarithmic Tag Cloud.
	 * http://dburke.info/blog/logarithmic-tag-clouds/
	 * http://stackoverflow.com/questions/604953/what-is-the-correct-algorthm-for-a-logarthmic-distribution-curve-between-two-poin
	 * @param array() $data tags data
	 * @param unknown_type $params module params
	 */
	private static function getLogarithmicTagCloud(&$data, &$params)
	{
		$deltaSize = $data->maxSize - $data->minSize;

		$constant = log($data->maxWeight - ($data->minWeight - 1)) / ($deltaSize==0 ? 1 : $deltaSize);
		foreach ($data->tagarray as &$tag)
		{
			$size = $data->minSize + log($tag->count - ($data->minWeight - 1)) / $constant;
			$tag->size = $size;
		}

		return $data;
	}
}