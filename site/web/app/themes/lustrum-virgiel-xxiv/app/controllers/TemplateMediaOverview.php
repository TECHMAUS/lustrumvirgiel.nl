<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateMediaOverview extends Controller
{
	/**
	 * Return media subject title from Advanced Custom Fields
	 *
	 * @return string
	 */
	public static function subjectTitle()
	{
		return get_sub_field('title');
	}

	/**
	 * Return embed link from Advanced Custom Fields
	 *
	 * @return array
	 */
	public static function oEmbed()
	{
		return get_sub_field('embed_link', false);
	}

	/**
	 * Return page object from Advanced Custom Fields
	 *
	 * @return array
	 */
	public static function pageObject()
	{
		return get_sub_field('page_link');
	}
}
