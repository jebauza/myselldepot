<?php

namespace App\Http\Controllers\CMS\Api;

use App\User;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserStoreUpdateRequest;

class UserCmsApiController extends Controller
{
    protected $path;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::email($request->email)->userName($request->username)->name($request->name)
                    ->state($request->state)->with('profileImage','permissions','roles')->orderBy('username')
                    ->paginate();

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreUpdateRequest $request)
    {
        $path = null;
        try {
            DB::beginTransaction();

            $file = null;
            if($request->file('image')) {
                $image = $request->file('image');
                $image_name = Str::random(10).'_'.$image->getClientOriginalName();
                $path = Storage::putFileAs('public/users', $image, $image_name);
                $file = File::create([
                    'path' => $path,
                    'filename' => $image_name,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }

            $new_user = new User($request->all());
            $new_user->secondname = $request->secondname ?? null;
            $new_user->password = Hash::make($request->password);
            $new_user->file_id = $file ? $file->id : null;
            $new_user->created_by = 1;
            $new_user->updated_by = 1;
            $new_user->save();
            $new_user->syncRoles($request->roles);
            $new_user->syncPermissions($request->permissions);

            DB::commit();
            return response()->json(['msg'=>__('Save successfully'), 'user'=>$new_user->refresh()], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            if($path && Storage::exists($path)){
                Storage::delete($path);
            }
            return response()->json(['msg_error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($user = User::with('profileImage')->find($id)) {
            return $user;
        }

        return response()->json(['msg_error' => __('Not found')], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreUpdateRequest $request, $id)
    {
        $path = null;
        if(!$user = User::find($id)){
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        try {
            DB::beginTransaction();

            $file = $user->profileImage;
            if($request->file('image')) {
                $image = $request->file('image');
                $image_name = Str::random(10).'_'.$image->getClientOriginalName();
                $path = Storage::putFileAs('public/users', $image, $image_name);
                if($file) {
                    if(Storage::exists($file->path)) {
                        Storage::delete($file->path);
                    }
                    $file->fill(['path' => $path])->save();
                }else {
                    $file = File::create([
                        'path' => $path,
                        'filename' => $image_name,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                }
            }
            $user->firstname = $request->firstname;
            $user->secondname = $request->secondname ?? null;
            $user->lastname = $request->lastname;
            $user->username = $request->username;
            $user->email = $request->email;
            if($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->file_id = $file ? $file->id : null;
            $user->save();
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            DB::commit();
            return response()->json(['msg'=>__('Save successfully'), 'user'=>$user->refresh()], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            if($path && Storage::exists($path)){
                Storage::delete($path);
            }
            return response()->json(['msg_error' => $e->getMessage()], 500);
        }
    }

    public function setState(Request $request, $id)
    {
        $request->validate([
            'state' => 'required|in:A,I'
        ]);

        if($user = User::find($id)) {
            $user->state = $request->state;
            $user->save();
            return response()->json([
                'msg'=>__('User :state successfully', ['state'=>__($user->state == 'A' ? 'activated' : 'deactivated')]),
                'user'=>$user
            ], 200);
        }else {
            return response()->json(['msg_error' => __('No encontrado')], 404);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
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
