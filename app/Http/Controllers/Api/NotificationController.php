<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Event;

class NotificationController extends Controller
{
    public function setTokenUser(Request $request, $token)
    {
        $user = $request->user();
        if ($user == null) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
        $user_bd = User::find($user->id);

        if ($user_bd != null) {
            $user_bd->token_notification = $token != 'null' ? $token : NULL;
            $user_bd->save();
            return response()->json([
                'success' => 'Alteracao feita com sucesso',
            ], 200);
        }
        return response()->json([
            'error' => 'User not found',
        ], 404);
    }
    public function setEventNotification(Request $request,Event $event)
    {
        $user = $request->user();
        if ($user == null) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
        $user->events()->attach($event->id);

        return response()->json([
            'success' => 'Notificação ativa com sucesso',
        ], 200);
    }
    public function unsetEventNotification(Request $request,Event $event)
    {
        $user = $request->user();
        if ($user == null) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
        $user->events()->detach($event->id);
        
        return response()->json([
            'success' => 'Notificação removida com sucesso',
        ], 200);
    }
}
