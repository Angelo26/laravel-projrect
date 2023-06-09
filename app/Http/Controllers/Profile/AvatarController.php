<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        if($currentAvatar = request()->user()->avatar){
            if(!Str::contains($currentAvatar, 'avatars/default-user.jpg')){
                Storage::disk('public')->delete($currentAvatar);
            }
        }

        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        request()->user()->update(['avatar' => $path]);
        return redirect(route('profile.edit'));
    }
}
