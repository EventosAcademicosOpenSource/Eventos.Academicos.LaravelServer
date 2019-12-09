<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Event;
use Edujugon\PushNotification\PushNotification;
use Session;
use App\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {   //autentica para mexer no controller de eventos
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $event = Event::find($id);
        if ($event != null) {
            $notifications = $event->notifications()->orderBy('updated_at', 'desc')->paginate(15);
            return view('admin.events.notifications.index', compact('event','notifications'));
        }
        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\NotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        $event = Event::find($request->eventId);
        if ($event != null) {
            $notification = new Notification();

            $notification->title = $request->title;
            $notification->message = $request->message;
            $event->notifications()->save($notification);

            $this->sendNotification($notification, $event);
            
            Session::flash('alert-success', 'Notificação cadastrada!!');
            return redirect()->route('admin.notification.index', $request->eventId);
        }

        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }
    private function sendNotification(Notification $notification, Event $event)
    {
        $users_mobile_notification = $event->users()->where('token_notification', '!=', '')->get();
        if($users_mobile_notification->count() > 0)
        {
            $tokens = $users_mobile_notification->pluck('token_notification')->toArray();
            
            $push = new PushNotification('fcm');
            $response = $push->setMessage([
                'notification' => [
                    'title' => "{$event->name} - {$notification->title}",
                    'body' => $notification->message,
                    'sound' => 'default'
                ],
                'data' => [
                    'eventid' => $event->id
                ]
            ])
                ->setApiKey(env('FCM_SERVER_KEY'))
                ->setDevicesToken($tokens)
                ->send()
                ->getFeedback();
        }
    }
}
