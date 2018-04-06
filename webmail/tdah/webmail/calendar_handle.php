<?php
include('class.calendar.php');

class CalendarHandler extends WingedCalendar {


function isAuthorised() {return
 isset($GLOBALS['sess']['user']);

}

	function printAddForm($day, $month, $year) {
		print $this->getForm('add', '', $day, $month, $year, 0, 0, '', 'submit', 'hidden');
	}

	function printEditForm($id) {
		$events = $this->getEvent($id);
		if (!empty($events)) {
			print $this->getForm('edit', $id, $events['day'], $events['month'], $events['year'], $events['hr'], $events['min'], $events['message'], 'hidden', 'submit');
		}
	}

	function checkInput($day, $month, $year, $hr, $min, $message) {
		return (
			(checkdate($month, $day, $year) ||
			($month==0 && checkdate(2, $day, $year)) ||
			($year==0 && checkdate($month, $day, 2005)) ||
			($year==0 && $month==0 && checkdate(2, $day, 2005))) &&
			strpos($message, '</event>')===false && strpos($message, '<event>')===false &&
			!empty($message) &&
			$hr>=0 && $hr<24 && $min>=0 && $min<60
		);
	}

	function printOut($action) {
		global $cal_cfg;
		if ($action=='access') {
			print $this->parseTemplate($cal_cfg['popup']['js']['alert'], array('alert'=>$cal_cfg['popup']['notices']['access']));
		} else if ($action=='invalid') {
			print $this->parseTemplate($cal_cfg['popup']['js']['alert'], array('alert'=>$cal_cfg['popup']['notices']['invalid']));
		} else if ($action=='add') {
			print $this->parseTemplate($cal_cfg['popup']['js']['confirm'], array('confirm'=>$cal_cfg['popup']['notices']['add']));
		} else if ($action=='edit') {
			print $this->parseTemplate($cal_cfg['popup']['js']['confirm'], array('confirm'=>$cal_cfg['popup']['notices']['edit']));
		} else if ($action=='del') {
			print $this->parseTemplate($cal_cfg['popup']['js']['confirm'], array('confirm'=>$cal_cfg['popup']['notices']['del']));
		} else if ($action=='header') {
			print $this->parseTemplate($cal_cfg['popup']['header'], array('charset'=>$this->charset));
		} else if ($action=='footer') {
			print $cal_cfg['popup']['footer'];
		}
	}
}


$cal = new CalendarHandler();

if (isset($_GET['date'])) {
	list($month, $year) = explode('-', $_GET['date']);
	if (checkdate(intval($month), 1, intval($year))) {
		header('Content-Type: text/html; charset=' . $cal->charset);
		$cal->show_month($month, $year);
	}
} else if (isset($_GET['add'])) {
	list($day, $month, $year) = explode('-', $_GET['add']);
	if (checkdate(intval($month), intval($day), intval($year))) {
		$cal->printOut('header');
		$cal->printAddForm($day, $month, $year);
		$cal->printOut('footer');
	}
} else if (isset($_GET['edit'])) {
	$cal->printOut('header');
	$cal->printEditForm($_GET['edit']);
	$cal->printOut('footer');
} else if (isset($_POST['do'])) {
	$cal->printOut('header');
	if ($_POST['do']=='add') {
		if (!(isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) && isset($_POST['hr']) && isset($_POST['min']) && isset($_POST['message']))) {
			exit('error3');
		}
		if ($cal->isAuthorised()) {
			$post_day = intval(substr($_POST['day'], 2));
			$post_month = intval(substr($_POST['month'], 2));
			$post_year = intval($_POST['year']);
			$post_hr = intval(substr($_POST['hr'], 2));
			$post_min = intval(substr($_POST['min'], 2));
			$post_message = trim($_POST['message']);

			if ($cal->checkInput($post_day, $post_month, $post_year, $post_hr, $post_min, $post_message)) {
				$cal->addEvent($post_day, $post_month, $post_year, $post_hr, $post_min, $post_message);
				$cal->printOut('add');
			} else {
				$cal->printOut('invalid');
			}
		} else {
			$cal->printOut('access');
		}
	} else if ($_POST['do']=='edit') {
		if (!(isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) && isset($_POST['hr']) && isset($_POST['min']) && isset($_POST['message']) && isset($_POST['id']))) {
			exit('error3');
		}
		if ($cal->isAuthorised()) {
			if (isset($_POST['edit'])) {
				$post_day = intval(substr($_POST['day'], 2));
				$post_month = intval(substr($_POST['month'], 2));
				$post_year = intval($_POST['year']);
				$post_hr = intval(substr($_POST['hr'], 2));
				$post_min = intval(substr($_POST['min'], 2));
				$post_message = trim($_POST['message']);

				if ($cal->checkInput($post_day, $post_month, $post_year, $post_hr, $post_min, $post_message)) {
					$cal->delEvent($_POST['id']);
					$cal->addEvent($post_day, $post_month, $post_year, $post_hr, $post_min, $post_message, $_POST['id']);
					$cal->printOut('edit');
				} else {
					$cal->printOut('invalid');
				}
			} else if (isset($_POST['del'])) {
				$cal->delEvent($_POST['id']);
				$cal->printOut('del');
			}
		} else {
			$cal->printOut('access');
		}
	}
	$cal->printOut('footer');
}

?>
