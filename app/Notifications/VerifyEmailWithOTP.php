<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailWithOTP extends Notification {
  use Queueable;

  public $otp;

  public function __construct($otp) {
    $this->otp = $otp;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    return (new MailMessage)
      ->greeting('Verify your email')
      ->subject('Verify your email')
      ->line('Your OTP code is: ' . $this->otp)
      ->line('Please enter this code in the app to verify your email.')
      ->salutation('Thank you for using our application!');
  }
}
