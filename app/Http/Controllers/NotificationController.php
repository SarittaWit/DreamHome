<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GenericNotification;

class NotificationController extends Controller
{
    public function index()
    {
        // إذا كان المستخدم Admin نعرض جميع التنبيهات
        if (auth()->user()->role === 'admin') {
            $notifications = \DB::table('notifications')->latest()->paginate(10);
        } else {
            // المستخدم العادي يشوف فقط ديالو
            $notifications = auth()->user()->notifications()->latest()->paginate(10);
        }

        return view('notifications.index', compact('notifications'));

    }


    public function destroy($id)
    {
        auth()->user()->notifications()->where('id', $id)->delete();
        return back()->with('success', 'Notification supprimée.');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = [
            'title' => $request->title,
            'message' => $request->message,
            'action' => 'Notification personnalisée',
            'user_name' => auth()->user()->name,
            'timestamp' => now()->toDateTimeString(),
        ];


        if ($request->user_id) {
            $user = User::find($request->user_id);
            $user->notify(new GenericNotification($data));
        } else {
            Notification::send(User::all(), new GenericNotification($data));
        }

        return redirect()->route('notifications.index')->with('success', 'Notification envoyée avec succès.');
    }

    public function deleteAll()
    {
        auth()->user()->notifications()->delete();
        return back()->with('success', 'Toutes les notifications ont été supprimées.');
    }
}
