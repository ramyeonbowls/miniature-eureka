<?php

namespace App\Services\Web;

use App\Repositories\Web\WebMenuRepository;

class WebMenuService 
{
	protected $webMenuRepo;

	public function __construct(WebMenuRepository $webMenuRepo)
	{
		$this->webMenuRepo = $webMenuRepo;
	}

	public function getAccessControlList($username)
	{
		return $this->webMenuRepo->getAccessControlList($username)
			->map(function ($value) use ($username) {
				return $this->formatNavbar($username, $value);
			});
	}

	public function formatNavbar($username, $value)
	{
		$childs = $this->webMenuRepo->getAccessControlList($username, $value->id)
			->map(function ($value) use ($username) {
				return $this->formatNavbar($username, $value);
			})->toArray();

		/* return [
			'previd' => $value->previd,
			'menu_fn' => $value->menu_fn,
			'menu_link' => $value->menu_link,
			'menu_label' => $value->menu_label,
			'menu_desc' => $value->menu_desc,
			'menu_icon' => $value->menu_icon,
			'isTitle' => $value->menu_link === 'T' ? true : false,
			'childs' => $childs,
		]; */

		$menuItem = [
			'name' => $value->menu_label, // Assuming 'menu_label' is the name of the menu item
			'icon' => $value->menu_icon,   // Assuming 'menu_icon' is the icon class
		];
	
		// Conditionally add URL if present
		if (!empty($value->menu_fn)) {
			$menuItem['url'] = $value->menu_fn;
		}
	
		// Add 'isTitle' if the menu item is a title
		if ($value->menu_link === 'T') {
			$menuItem['isTitle'] = true;
		}
	
		// Add 'submenu' if there are child items
		if (!empty($childs)) {
			$menuItem['submenu'] = $childs;
		}
	
		return $menuItem;
	}
}