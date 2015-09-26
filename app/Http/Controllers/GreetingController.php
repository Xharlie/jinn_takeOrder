<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 9/23/15
 * Time: 12:29 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Session, Validator, Input, Redirect, DB;


class GreetingController extends Controller
{
    /**
     * get Menu info
     *
     * @return Response
     */
    public function postGreetings(Request $request)
    {
        $guestInfo= $request->input('guestInfo');
        $HTL_NM= $request->input('HTL_NM');
        $HTL_ID= $request->input('HTL_ID');
        $mapURL="http://182.92.189.254/Sites/jinn/greetingMap/index.php?ID=".$HTL_ID;
        $appURL='http://182.92.189.254:3000';

        return Yunpian::sendGreetings($HTL_NM,$mapURL,$appURL,$guestInfo);
    }
}