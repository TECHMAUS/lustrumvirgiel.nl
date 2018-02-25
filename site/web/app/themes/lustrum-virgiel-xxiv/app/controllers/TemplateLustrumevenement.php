<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLustrumevenement extends Controller
{
	public static function days_until() {
		$today = date('m/d/Y');
		$today = strtotime($today);
		$finish = get_field('quick_facts_date_start');
		$finish = strtotime($finish);
		//difference
		$diff = $finish - $today;

		$daysleft=floor($diff/(60*60*24));
		return "$daysleft";
	}
}
