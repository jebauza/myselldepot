<?php

namespace App\Http\Controllers\CMS\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LoginCmsApiController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'msg' => __('Successfully authenticated'),
                'authUser' => Auth::user()
            ], 200);
        } else{
            return response()->json(['errors' => ['email' => [__('auth.failed')]]], 422);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([__('Logged out successfully')], 204);
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
