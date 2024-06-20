<?php

namespace App\Orchid\Screens\AppUser;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;

use App\Models\AppUser;

class AppUserListScreen extends Screen {

  public function query(): iterable {
    return [
      'appUsers' => AppUser::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'App Users';
  }

  public function commandBar(): iterable {
    return [];
  }

  public function layout(): iterable {
    return [
      Layout::table('appUsers', [

        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (AppUser $appUser) {
            return ucwords($appUser->name);
          }),

        TD::make('email', 'Email')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (AppUser $appUser) {

            if ($appUser->email_verified) {
              $hiddenEmail = substr($appUser->email, 0, 3) . '****' . substr($appUser->email, strpos($appUser->email, '@'));
              return $hiddenEmail;
            }

            if (!$appUser->email_verified) {
              return '-';
            }
          }),

        TD::make('phone_number', 'Phone')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (AppUser $appUser) {
            if ($appUser->phone_number) {
              $hiddenPhone = substr($appUser->phone_number, 0, 3) . '****' . substr($appUser->phone_number, -4);
              return $hiddenPhone;
            } else {
              return '-';
            }
          }),

        TD::make('location', 'Location')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (AppUser $appUser) {
            if ($appUser->location) {
              $shortenedLocation = substr($appUser->location, 0, 10) . '...';
              return $shortenedLocation;
            } else {
              return '-';
            }
          }),

        TD::make('created_at', __('Created'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (AppUser $appUser) {
            return $appUser->created_at->format('M j, Y');
          }),
      ])
    ];
  }
}
