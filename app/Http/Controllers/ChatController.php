<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Events\NewMessageChat;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function newMessage(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === UserRole::CUSTOMER_SERVICE_STAFF) {
            $roomId = ChatRoom::query()->where('name', 'chat.' . $request->input('room_user_id'))->value('id');
        } else {
            $roomId = ChatRoom::query()->where('name', 'chat.' . $user->id)->value('id');
            $isFirstMessage = $user->role == UserRole::NORMAL_USER && !$roomId;
    
            if ($isFirstMessage) {
                $room = ChatRoom::create(['name' => 'chat.' . $user->id]);
                $roomId = $room->id;
            }
        }

        $chat = Chat::create([
            'user_id' => $user->id,
            'chat_room_id' => $roomId,
            'message' => $request->input('message')
        ]);

        $data = [
            'user_id' => $chat->user_id,
            'message' => $chat->message,
            'avatar' => strtoupper($user->name[0])
        ];

        NewMessageChat::dispatch($data);

        return response()->json(['status' => 'success']);
    }

    public function getByUserId($userId)
    {
        $roomId = ChatRoom::query()->where('name', 'chat.' . $userId)->value('id');

        $chats = Chat::with('user:id,name')->where('chat_room_id', $roomId)
            ->get()
            ->transform(function ($chat) {
                return [
                    'user_id' => $chat->user_id,
                    'message' => $chat->message,
                    'avatar' => strtoupper($chat->user->name[0])
                ];
            });

        return response()->json(['status' => 'success', 'chats' => $chats]);
    }

    public function customerService()
    {
        $userIds = ChatRoom::all()
            ->transform(function ($room) {
                return explode('.', $room->name)[1];
            });

        $users = User::query()->select(['id', 'name'])->whereIn('id', $userIds)
            ->get()
            ->transform(function ($user) {
                $user->avatar = strtoupper($user->name[0]);
                return $user;
            });

        return view('customer-service', compact('users'));
    }
}
