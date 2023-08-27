<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\NewRoom;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function newMessage(Request $request)
    {
        $user = $request->user();
        
        if (!($roomId = $request->input('room_id'))) {
            $room = ChatRoom::create(['name' => 'chat.' . $user->id]);
            $roomId = $room->id;
            User::query()->whereKey($user->id)->update(['room_id' => $roomId]);
            NewRoom::dispatch([
                'user_id' => $user->id,
                'room_id' => $roomId,
                'user_name' => $user->name,
                'avatar' =>strtoupper($user->name[0])
            ]);
        }

        $chat = Chat::create([
            'user_id' => $user->id,
            'chat_room_id' => $roomId,
            'message' => $request->input('message')
        ]);

        $data = [
            'chat_room_id' => $chat->chat_room_id,
            'user_id' => $chat->user_id,
            'message' => $chat->message,
            'avatar' => strtoupper($user->name[0])
        ];

        NewMessage::dispatch($data);

        return response()->json(['status' => 'success']);
    }

    public function getByRoomId($roomId)
    {
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
        $users = User::query()->select(['id', 'name', 'room_id'])->whereNotNull('room_id')
            ->get()
            ->transform(function ($user) {
                $user->avatar = strtoupper($user->name[0]);
                return $user;
            });

        return view('customer-service', compact('users'));
    }

    public function getAllChatRooms()
    {
        return response()->json(['status' => 'success', 'chat_rooms' => ChatRoom::all()]);
    }
}
