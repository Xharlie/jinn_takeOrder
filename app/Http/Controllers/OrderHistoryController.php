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
                            ->join('Transaction_Info','OrderInfo.TRN_ID','=','Transaction_Info.TRN_ID')
                            ->join('Hotel_Info', function ($join) use ($HTL_ID) {
                                $join->where('OrderInfo.HTL_ID', '=', $HTL_ID)
                                     ->on('Hotel_Info.HTL_ID', '=', 'OrderInfo.HTL_ID');
                            })
                            ->leftJoin('Combo_Info','Combo_Info.CMB_ID','=','OrderInfo.CMB_ID')
                            ->whereRaw("OrderInfo.ORDR_TSTMP between '" . $ST_TM . "' and '". $END_TM."'")
                            ->select('Combo_Info.CMB_NM as CMB_NM','Combo_Info.CMB_PRC as CMB_PRC',
                                'Combo_Info.CMB_TRANS_PRC as CMB_TRANS_PRC','OrderInfo.ORDR_ID as ORDR_ID',
                                'OrderInfo.TRN_ID as TRN_ID','OrderInfo.AMNT as AMNT','OrderInfo.ORDR_TSTMP as ORDR_TSTMP',
                                'OrderInfo.RMRK as RMRK','OrderInfo.RCVR_NM as RCVR_NM','OrderInfo.RCVR_PHN as RCVR_PHN',
                                'OrderInfo.RCVR_ADDRSS as RCVR_ADDRSS','OrderInfo.HTL_ID as HTL_ID',
                                'OrderInfo.RM_ID as RM_ID','OrderInfo.TKT_ID as TKT_ID','Hotel_Info.HTL_NM as HTL_NM',
                                'OrderInfo.STATUS as STATUS','OrderInfo.ORDR_TAKEN_TSTMP as ORDR_TAKEN_TSTMP',
                                'Transaction_Info.PYMNT_MTHD as PYMNT_MTHD')
                            ->get();
        return response()->json($GoodsHistory);
    }
 /**
     * change order status
     *
     * @return Response
     */
    public function updateStatus(Request $request)
    {
        $ORDR_ID = $request->input('ORDR_ID');
        $STATUS = $request->input('STATUS');
        try {
            DB::beginTransaction();   //////  Important !! TRANSACTION Begin!!!
            if($STATUS == '已下单'){
                DB::update('update OrderInfo set STATUS = ?, ORDR_TAKEN_TSTMP = ? where ORDR_ID = ?',
                    array($STATUS, date('Y-m-d H:i:s'), $ORDR_ID ) );
            }else{
                DB::update('update OrderInfo set STATUS = ? where ORDR_ID = ?',
                    array($STATUS, $ORDR_ID ) );
            }

        }catch (Exception $e){
            DB::rollback();
            $message=($e->getLine())."&&".$e->getMessage();
//            throw new Exception($message);
            return response()->json('数据库错误'+$message);
        }finally{
            DB::commit();
            return response()->json('成功');
        }
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
