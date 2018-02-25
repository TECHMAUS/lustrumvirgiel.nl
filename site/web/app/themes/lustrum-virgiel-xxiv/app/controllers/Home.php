<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Home extends Controller
{
	/**
	 * Return categories that are labeled as news filter tags
	 *
	 * @return array
	 */
	public function newsFilters()
	{
		return get_field('news_filter_cats', 258);
	}
}
