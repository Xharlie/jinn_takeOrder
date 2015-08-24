<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB,View;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderHistoryController extends Controller
{
    /**
     * get Order History
     *
     * @return Response
     */
    public function getOrderHistory($HTL_ID,$ST_TM,$END_TM)
    {
        //
        $GoodsHistory = DB::table('OrderInfo')
                            ->join('Hotel_Info', function ($join) use ($HTL_ID) {
                                $join->where('OrderInfo.HTL_ID', '=', $HTL_ID)
                                     ->on('Hotel_Info.HTL_ID', '=', 'OrderInfo.HTL_ID');
                            })
                            ->leftJoin('Combo_Info','Combo_Info.CMB_ID','=','OrderInfo.CMB_ID')
                            ->whereRaw("OrderInfo.ORDR_TSTMP between '" . $ST_TM . "' and '". $END_TM."'")
                            ->select('Combo_Info.CMB_NM as CMB_NM','OrderInfo.ORDR_ID as ORDR_ID','OrderInfo.TRN_ID as TRN_ID','OrderInfo.AMNT as AMNT','OrderInfo.ORDR_TSTMP as ORDR_TSTMP',
                                'OrderInfo.RMRK as RMRK','OrderInfo.RCVR_NM as RCVR_NM','OrderInfo.RCVR_PHN as RCVR_PHN','OrderInfo.RCVR_ADDRSS as RCVR_ADDRSS','OrderInfo.HTL_ID as HTL_ID',
                                'OrderInfo.RM_ID as RM_ID','OrderInfo.TKT_ID as TKT_ID','Hotel_Info.HTL_NM as HTL_NM')
                            ->get();
        return response()->json($GoodsHistory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
