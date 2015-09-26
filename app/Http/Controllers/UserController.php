<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller{

    private $chanceMax;

    function __construct()
    {
        $this->chanceMax = 3;
    }

    public function logonPost(Request $request){
        if(Auth::check()){
            Auth::logout();
        }

        $userdata = array(
            'username' => $request->input('usr'),
            'password' => $request->input('pwd')
        );
        /* Try to authenticate the credentials */
        if(Auth::attempt($userdata))
        {
            $userInfo = $this->loadUserInfo(Auth::id(),$request);
            $this->chanceManagement(true,$request);
//            return Redirect::intended('/')->with($userInfo);

            return redirect('/')->with("flashUserInfo", $userInfo);
        }
        else
        {
            return redirect('/logon')->with(
                "err",
                $this->chanceManagement(false,$request)
            );
        }
    }


    public function loadUserInfo($id,$request){
        /*****************************     get employee info     ******************************/

        $emp = DB::table('UserAccess')
            ->join('Hotel_Info','UserAccess.HTL_ID','=','Hotel_Info.HTL_ID')
            ->where('id', '=', $id)
            ->first(array('UserAccess.id as id', 'UserAccess.EMP_NM as EMP_NM',
                'UserAccess.username as username','UserAccess.EMP_SYS_LVL as EMP_SYS_LVL',
                'UserAccess.HTL_ID as HTL_ID','Hotel_Info.HTL_NM as HTL_NM','Hotel_Info.CRP_ID as CRP_ID'));
        if($emp == null) return null;
        // add condition
        $userInfo = array(
            'EMP_ID'=>$emp->id,
            'CRP_ID'=>$emp->CRP_ID,
            'HTL_ID'=>$emp->HTL_ID,
            'HTL_NM'=>$emp->HTL_NM,
            'username' => $emp->username,
            'id' => $emp->id,
            'EMP_NM' => $emp->EMP_NM,
            'EMP_SYS_LVL' => $emp->EMP_SYS_LVL,
//            'ST_TM' => (new DateTime()) ->format('Y-m-d H:i:s')  // start time of this username
            'ST_TM' => date('Y-m-d H:i:s')  // start time of this username
        );
        /*****************************     one user has one session     ******************************/
        DB::update("update UserAccess set SESSION_ID = ? where id = ?",
            array($request->session()->getId(), $id) );

        session(['userInfo' => $userInfo]);
        session(['LAST_ACTIVITY' => time()]);

//        return $userInfo;
        return $request->session()->all();
    }

//    public function putLogonRecord($userInfo){
//        /*****************************   LogonRecord recording      ******************************/
//        $LGN_ID = DB::table('LogonRecord')->insertGetId(
//            array(
//                'EMP_ID' => $userInfo['id'],
//                'HTL_ID' => $userInfo['HTL_ID'],
//                'SHFT_ID' => $userInfo['SHFT_ID'],
//                'LGN_TM' => $userInfo['ST_TM']
//            )
//        );
//        return $LGN_ID;
//    }



    public function chanceManagement($success,$request){
        if($success){
            $request->session()->put('trialsRemain',$this->chanceMax);
        }else{
            $request->session()->put('trialsRemain',$request->session()->get('trialsRemain')-1);
            $message = "用户名或密码错误,还有".(string)($request->session()->get("trialsRemain"))."次机会";
            if ($request->session()->get("trialsRemain")<=0){
                $message="各级店长注意,已触发警报";
            }
            return $message;
        }
    }

    public function getUserInfo(Request $request){
        $userInfo = $request->session()->get("userInfo");
        return $userInfo;
    }

//    public function getShiftOptions($HTL_ID){
//        $shifts = DB::table('ShiftDefinition')
//            ->where('HTL_ID', '=', $HTL_ID)
//            ->select('SHFT_ID','SHFT_NM')
//            ->get();
//        return Response::json($shifts);
//    }

//    public function putShiftChosen(){
//        $shift = Input::get('shift');
//        Session::put('userInfo.SHFT_NM',$shift['SHFT_NM']);
//        Session::put('userInfo.SHFT_ID',$shift['SHFT_ID']);
//        /***************** fill the logonRecord table after all info gotten, and put the logon id  ******************/
////        Session::put('LGN_ID',$this->putLogonRecord(Session::get('userInfo')));
//
//        return Response::json(Session::get('userInfo'));
//    }
}
