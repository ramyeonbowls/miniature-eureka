<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\VisitorsService;

class VisitorsController extends Controller
{
    protected $VisitorsService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(VisitorsService $VisitorsService)
    {
        $this->VisitorsService = $VisitorsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $results['status'] = 200;
        $results['success'] = false;
        $results['message'] = '';
        try {
            $Visitors = $this->VisitorsService->createVisitor($request);

            if($Visitors) {
                $results['status'] = 201;
                $results['success'] = true;
                $results['message'] = 'Ok';
            }
        } catch (\Throwable $th) {
            $results['status'] = 500;
            $results['message'] = $th->getMessage();
        }

        return response()->json($results, $results['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
