<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('admin.auth.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => '请输入当前密码',
            'password.required' => '请输入新密码',
            'password.min' => '新密码至少6个字符',
            'password.confirmed' => '两次输入的密码不一致',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '当前密码错误']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', '密码修改成功');
    }
} 