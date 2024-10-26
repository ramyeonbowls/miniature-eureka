<?php

namespace App\Services\Web;

use App\Repositories\Web\VisitorsRepository;

class VisitorsService 
{
	protected $VisitorsRepo;

	public function __construct(VisitorsRepository $VisitorsRepo)
	{
		$this->VisitorsRepo = $VisitorsRepo;
	}

	public function createVisitor($data)
	{
		return $this->VisitorsRepo->createVisitor($data);
	}

	public function ReadFitur($data)
	{
		return $this->VisitorsRepo->ReadFitur($data);
	}
}