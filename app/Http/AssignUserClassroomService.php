<?php

namespace App\Http;

use App\Mail\ClassroomInvitationMail;
use App\Models\Classroom\Classroom;
use App\Models\ClassRoomRequest\ClassroomEmailRequest;
use App\Models\User\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssignUserClassroomService
{
    public string $receiverEmail;
public function execute(Classroom $classroom,array $data)
{
    try {
        $this->receiverEmail=$data['email']??"";
        $senderId=auth()->id();
        $user=User::where('email',$this->receiverEmail)->first();
        if (!isset($user)){
            ClassroomEmailRequest::create([
                'userID' =>$senderId ,
                'receiver_email' => $this->receiverEmail,
                'classroomId' => $classroom->id,
            ]);
            $this->sendMailNif($classroom,$senderId);
        }else{
            $classroom->addUser($user->id);
        }
        Log::info("Success assing user to classroom wi with sender {$senderId}, receiver {$this->receiverEmail}");

        return response()->json("success");
    }catch (\Exception $exception){
        Log::error("Error assing user to classroom with message {$exception->getMessage()}, with sender {$senderId}, receiver {$this->receiverEmail}");
        return response()->json(["error"=>$exception->getMessage()],400);
    }

}


        private function sendMailNif(Classroom $classroom, int $senderId): void
        {
        $sender = User::find($senderId);
        $link = "https://dash.bibla.al/app";

        Mail::to($this->receiverEmail)->send(new ClassroomInvitationMail(
            $sender->name,
            $sender->email,
            $classroom->name,
            $link
        ));
    }
}
