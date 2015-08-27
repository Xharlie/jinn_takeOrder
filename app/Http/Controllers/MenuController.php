<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Session, Validator, Input, Redirect, DB;


class MenuController extends Controller
{
    /**
     * get Menu info
     *
     * @return Response
     */
    public function getMenu($HTL_ID)
    {
        $comboInfo = DB::table('Hotel_Info')
                        ->join('Hotel_Combo_Mapping', function ($join) use ($HTL_ID) {
                            $join->on('Hotel_Combo_Mapping.HTL_ID', '=', 'Hotel_Info.HTL_ID')
                                ->where('Hotel_Info.HTL_ID', '=', $HTL_ID);
                        })
                        ->join('Combo_Info','Combo_Info.CMB_ID','=','Hotel_Combo_Mapping.CMB_ID')
                        ->join('Merchant_Combo_Mapping','Merchant_Combo_Mapping.CMB_ID','=','Combo_Info.CMB_ID')
                        ->join('Merchant_Info','Merchant_Info.MRCHNT_ID','=','Merchant_Combo_Mapping.MRCHNT_ID')
                        ->select('Combo_Info.CMB_ID as CMB_ID','Combo_Info.CMB_NM as CMB_NM',
                            'Combo_Info.CMB_THMBNL as CMB_THMBNL','Combo_Info.CMB_DSCRPT as CMB_DSCRPT',
                            'Combo_Info.CMB_PRC as CMB_PRC','Combo_Info.CMB_ORGN_PRC as CMB_ORGN_PRC',
                            'Combo_Info.CMB_TRANS_PRC as CMB_TRANS_PRC','Combo_Info.CMB_DTL as CMB_DTL',
                            'Combo_Info.SRVC_TP_ID as SRVC_TP_ID','Combo_Info.CMB_PIC as CMB_PIC',
                            'Merchant_Info.MRCHNT_ID as MRCHNT_ID','Merchant_Info.MRCHNT_NM as MRCHNT_NM',
                            'Combo_Info.CMB_PAY_MTHD as CMB_PAY_MTHD','Combo_Info.CMB_PRVD_MTHD as CMB_PRVD_MTHD',
                            'Combo_Info.CMB_STL_CLSS as CMB_STL_CLSS'
                        )
                        ->get();
        return response()->json($comboInfo);
    }

    /**
     * get serviceType info
     *
     * @return Response
     */
    public function getServiceTypes()
    {
        $ServiceTypes = DB::table('Service_Type_Info')
            ->get();
        return response()->json($ServiceTypes);
    }

    /**
     * get payMent info
     *
     * @return Response
     */
    public function getPayMethods()
    {
        $PayMethods = DB::table('PayMethod')
            ->get();
        return response()->json($PayMethods);
    }

   /**
     * post order
     *
     *
     */
    public function postOrder(Request $request)
    {
        $order = $request->input('order');
        $transaction = $request->input('transaction');
        $yunpianInfo = $request->input('yunpianInfo');
        try {
            DB::beginTransaction();   //////  Important !! TRANSACTION Begin!!!
            $TRN_ID = DB::table('Transaction_Info')->insertGetId($transaction);
            $order['TRN_ID'] = $TRN_ID;
            $ORDR_ID = DB::table('OrderInfo')->insertGetId($order);

        }catch (Exception $e){
            DB::rollback();
            $message=($e->getLine())."&&".$e->getMessage();
//            throw new Exception($message);
            return response()->json('数据库错误'+$message);
        }finally{
            DB::commit();
            Yunpian::notifyFrontDeskOrder($ORDR_ID,$yunpianInfo['HTL_NM'],$order['HTL_ID'],$transaction['RM_ID'],
                $order['ORDR_TSTMP'],$order['CMB_ID'],$yunpianInfo['CMB_NM'],$order['AMNT']);
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
