<?php
ini_set("display_errors", 1);	
require('./inc/inc.php');
 	
$cal_cfg = array('path' => str_replace('\\', '/', dirname(__FILE__)));

include("inc/config/config.calendar.php");
include("themes/default/calendar-box.htm");
	
	class WingedCalendar {
		var $templates;
		var $months;
		var $sunday_endweek;
		var $datapath;
		var $htpath;
		var $timezone;
		var $charset;
		var $html;
		var $hour12;
		var $days;
		
				

		function WingedCalendar() {
			global $cal_cfg;
			$this->templates = $cal_cfg['template'];
			$this->sunday_endweek = $cal_cfg['sunday_endweek'];
			$this->months = $cal_cfg['month'];
			$this->timezone = $cal_cfg['timezone'];
			$this->charset = $cal_cfg['charset'];
			$this->html = $cal_cfg['html'];
			$this->hour12 = $cal_cfg['12_hour'];
			$this->datapath = $GLOBALS['userfolder']. '/_infos/' . 'events.ucf'; touch($this->datapath);	
			$docroot = $cal_cfg['document_root']? $cal_cfg['document_root'] : $_SERVER['DOCUMENT_ROOT'];
			$this->htpath = str_replace($docroot, '', $cal_cfg['path']);
			for ($i=0, $n=count($cal_cfg['day']); $i<$n; $i++) {
				$this->days[]['day'] = $cal_cfg['day'][$i];
			}
		}
			
		function getDate($time=0) {
			if (!$time) $time = time();
			return getdate($time + $this->timezone*3600-intval(date('Z')));
		}
	
		function getNumberOfDays($month, $year) {
			if ($month==4 || $month==6 || $month==9 || $month==11) {
				return 30;
			} else if ($month==2) {
				return ($year%4!=0 || ($year%100==0 && $year%400!=0))? 28 : 29;
			}
			return 31;
		}
	
		function getMonthDetails($month, $year) {
			$details = array();
			$details['mon'] = $month;
			$details['year'] = $year;
			$details['days'] = $this->getNumberOfDays($month, $year);
			$details['month'] = $this->months[$month];
			$tmp = $this->getDate(gmmktime(12, 0, 0, $month, 1, $year));
			$details['first'] = $this->sunday_endweek?
				($tmp['wday']==0? 6 : $tmp['wday']-1) : $tmp['wday'];
			$details['last']['mon'] = $month-1;
			$details['last']['year'] = $year;
			$details['next']['mon'] = $month+1;
			$details['next']['year'] = $year;
			if ($month==1) {
				$details['last']['mon'] = 12;
				$details['last']['year']--;
			} else if ($month==12) {
				$details['next']['mon'] = 1;
				$details['next']['year']++;
			}
			$details['last']['days'] = $this->getNumberOfDays($details['last']['mon'], $details['last']['year']);
			return $details;
		}
	
		function getEvent($id) {
			$events = array();
			$lines = file($this->datapath);
			for ($i=0, $n=count($lines); $i<$n; $i++) {
				if (trim($lines[$i])=='<event>') {
					if (trim($lines[++$i])==$id) {
						$events['id'] = $id;
						list($events['day'], $events['month'], $events['year']) = explode('-', trim($lines[$i+1]));
						list($events['hr'], $events['min']) = explode(':', trim($lines[$i+2]));
						$message = '';
						for ($i+=3;; $i++) {
							if (trim($lines[$i])=='</event>') break;
							$message .= $lines[$i];
						}
						$events['message'] = $this->html? stripslashes($message) : htmlspecialchars(stripslashes($message), ENT_QUOTES);
						break;
					}
				}
			}
			return $events;
		}
	
		function getMonthEvents($month, $year) {
			$events = array();
			$lines = file($this->datapath);
			$k = 0;
			$sorts = array();
			for ($i=0, $n=count($lines); $i<$n; $i++) {
				if (trim($lines[$i])=='<event>') {
					list($d, $m, $y) = explode('-', trim($lines[$i+2]));
					if (($m==$month || $m==0) && ($y==$year || $y==0)) {
						$sorts[$k] = trim($lines[$i+3]);
						list($h, $min) = explode(':', $sorts[$k]);
						$events[$k]['id'] = trim($lines[$i+1]);
						$events[$k]['day'] = $d;
						$events[$k]['month'] = $m;
						$events[$k]['year'] = $y;
						$events[$k]['hr'] = ($this->hour12 && $h>12)? $h-12 : $h;
						$events[$k]['min'] = ($min<10? '0' : '') . $min . ($this->hour12? ($h<12? ' am' : ' pm') : '');
						$message = '';
						for ($i+=4;; $i++) {
							if (trim($lines[$i])=='</event>') break;
							$message .= $lines[$i];
						}
						$events[$k]['message'] = $this->html? stripslashes($message) : htmlspecialchars(stripslashes($message), ENT_QUOTES);
						$k++;
					}
				}
			}
			$day_events = array();
			array_multisort($sorts, SORT_ASC, SORT_NUMERIC, $events);
			for ($i=0; $i<$k; $i++) {
				$day_events[$events[$i]['day']][] = $events[$i];
			}
			return $day_events;
		}
	
		function displayMonth($dates) {
			$keys = array(
						'LAST_MON' => $dates['last']['mon'],
						'LAST_YEAR' => $dates['last']['year'],
						'NEXT_MON' => $dates['next']['mon'],
						'NEXT_YEAR' => $dates['next']['year'],
						'MONTH' => $dates['month'],
						'YEAR' => $dates['year'],
						'MON' => $dates['mon']
						);
			$events = $this->getMonthEvents($dates['mon'], $dates['year']);
			$days = array();
			$filled = 0;
			$count = 0;
			for ($i=$dates['last']['days']-$dates['first']+1; $filled<$dates['first']; $i++, $filled++) {
				$days[$count]['DAY_' . $filled] = $i;
				$days[$count]['WHICH_' . $filled] = 'lastMonth';
				$days[$count]['EVENT_' . $filled] = '';
				$days[$count]['ID_' . $filled] = 'c' . $i . '-' . $dates['last']['mon'] . '-' . $dates['last']['year'];
			}
	
			$todays = $this->getDate();
			for ($i=1; $i<=$dates['days']; $i++, $filled++) {
				if ($filled==7) {
					$count++;
					$filled = 0;
				}
				$days[$count]['DAY_' . $filled] = $i;
				$days[$count]['WHICH_' . $filled] = '';
				$days[$count]['EVENT_' . $filled] = '';
				$days[$count]['ID_' . $filled] = 'd' . $i . '-' . $dates['mon'] . '-' . $dates['year'];
				if ($filled==6 || ($this->sunday_endweek && $filled==5) || (!$this->sunday_endweek && $filled==0)) {
					$days[$count]['WHICH_' . $filled] .= ' weekend ';
				}
				if ($todays['mon']==$dates['mon'] && $todays['mday']==$i && $todays['year']==$dates['year']) {
					$days[$count]['WHICH_' . $filled] .= ' today ';
				}
				if (array_key_exists($i, $events)) {
					$ids['DAY'] = $days[$count]['DAY_' . $filled];
					$ids['MONTH'] = $dates['mon'];
					$ids['YEAR'] = $dates['year'];
					$days[$count]['WHICH_' . $filled] .= ' event ';
					$days[$count]['EVENT_' . $filled] = $this->parseRecTemplate($this->parseTemplate($this->templates['event'], $ids), '<!-- BEGIN -->', '<!-- END -->', $events[$i]);
				}
			}
			for ($i=1; $filled<7; $i++, $filled++) {
				$days[$count]['DAY_' . $filled] = $i;
				$days[$count]['WHICH_' . $filled] = 'nextMonth';
				$days[$count]['EVENT_' . $filled] = '';
				$days[$count]['ID_' . $filled] = 'c' . $i . '-' . $dates['next']['mon'] . '-' . $dates['next']['year'];
			}
			print $this->parseRecTemplate(
					$this->parseRecTemplate(
						$this->parseTemplate(
							$this->templates['body'],
							$keys),
						'<!-- BEGIN1 -->', '<!-- END1 -->',
						$this->days),
					'<!-- BEGIN -->', '<!-- END -->',
					$days);
		}
	
		function getForm($do, $id, $day, $month, $year, $hr, $min, $message, $add, $edit) {
			$keys = array(
						'ID' => $id,
						'DO' => $do,
						'MESSAGE' => $message,
						'ADD' => $add,
						'EDIT' => $edit,
						'YEAR' => ''
						);
			$times = array(
						'search' => array(
									"<option value=\"da{$day}\">",
									"<option value=\"mo{$month}\">",
									"<option value=\"hr{$hr}\">",
									"<option value=\"mi{$min}\">"
									),
						'replace' => array(
									"<option value=\"da{$day}\" selected >",
									"<option value=\"mo{$month}\" selected >",
									"<option value=\"hr{$hr}\" selected >",
									"<option value=\"mi{$min}\" selected >"
									)
						);
			$tmp = $this->getDate();
			$year0 = $year>0? $year : $tmp['year'];
			$limit = 5;
			for ($i=$year0-$limit, $n=$year0+$limit; $i<=$n; $i++) {
				if ($i==$year) {
					$keys['YEAR'] .= '<option value="' . $i . '" selected >' . $i . '</option>';
				} else {
					$keys['YEAR'] .= '<option value="' . $i . '">' . $i . '</option>';
				}
			}
			return $this->parseTemplate(
							str_replace($times['search'], $times['replace'], $this->templates['form']),
							$keys);
		}
	
		function addEvent($day, $month, $year, $hr, $min, $message, $input_id=null) {
			$id = $input_id==null? time() : $input_id;
			$handle = fopen($this->datapath, 'a') or exit('error1');
			if (get_magic_quotes_gpc()==0) {
				$message = addslashes($message);
			}
			$content = "\n<event>\n" . $id . "\n" . $day . '-' . $month . '-' . $year . "\n" . $hr . ':' . $min . "\n" . $message . "\n</event>";
			if (fwrite($handle, $content)===false) {
				fclose($handle);
				exit('error2');
			}
			fclose($handle);
		}
	
		function delEvent($id) {
			$content = '';
			$lines = file($this->datapath);
			for ($i=0, $n=count($lines); $i<$n; $i++) {
				if (trim($lines[$i])=='<event>') {
					if (trim($lines[$i+1])==$id) {
						for ($i++;; $i++) {
							if (trim($lines[$i])=='</event>') break;
						}
					} else {
						for (;; $i++) {
							$content .= $lines[$i];
							if (trim($lines[$i])=='</event>') break;
						}
					}
				}
			}
			$handle = fopen($this->datapath, 'w') or exit('error1');
			if (fwrite($handle, $content)===false) {
				fclose($handle);
				exit('error2');
			}
			fclose($handle);
		}
		
		
		
		
	
		function show_calendar($last=0, $next=0) {
			print '<div id="calendar">';
			$today = $this->getDate();
			for ($i=$last; $i>0; $i--) {
				$month = $today['mon']-$i;
				$year = $today['year'];
				if ($month<1) {
					$month = 12+$month;
					$year--;
				}
				if (checkdate($month, 1, $year)) {
					$this->show_month($month, $year);
				}
			}
			for ($i=0; $i<=$next; $i++) {
				$month = $today['mon']+$i;
				$year = $today['year'];
				if ($month>12) {
					$month = $month-12;
					$year++;
				}
				if (checkdate($month, 1, $year)) {
					$this->show_month($month, $year);
				}
			}
			print '</div>';
			print $this->parseTemplate($this->templates['js'], array('htpath'=>$this->htpath));
		}
	
		function show_month($month, $year) {
			$dates = $this->getMonthDetails($month, $year);
			$this->displayMonth($dates);
		}
	
		function parseTemplate($tpl, $keys) {
			$vars = array();
			foreach($keys as $key => $val) {
				$vars[] = '{' . strtoupper($key) . '}';
			}
			return str_replace($vars, $keys, $tpl);
		}
	
		function parseRecTemplate($tpl, $begin, $end, $keys) {
			$content = '';
			$begin_pos = strpos($tpl, $begin) + strlen($begin);
			$end_pos = strpos($tpl, $end);
			$length = $end_pos - $begin_pos;
			$subtpl = substr($tpl, $begin_pos, $length);
			$vars = array();
			if (!empty($keys)) {
				foreach($keys[0] as $key => $val) {
					$vars[] = '{' . strtoupper($key) . '}';
				}
			}
			for ($i=0, $n=count($keys); $i<$n; $i++) {
				$content .= str_replace($vars, $keys[$i], $subtpl);
			}
			return substr_replace($tpl, $content, $begin_pos, $length);
		}
	}
	
	
	


?>
