<?php

namespace App\Helpers;

use App\Models\Notification;
use Carbon\Carbon;
class NotificationHelper
{

public static function createNotification($receiver_id,$sender_id,$module, $module_id, $message)
   {
        $notification = new Notification();
        $notification->receiver_id = $receiver_id;
        $notification->sender_id = $sender_id;
        $notification->module = $module;
        $notification->module_id = $module_id ?? NULl;
        $notification->message = $message;
        $notification->is_read=0;
        $notification->created_at=Carbon::now();
        $notification->save();
          return $notification;
     }


}