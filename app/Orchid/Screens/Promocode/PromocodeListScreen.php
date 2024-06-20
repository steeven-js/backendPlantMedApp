<?php

namespace App\Orchid\Screens\Promocode;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Promocode;

class PromocodeListScreen extends Screen {

  public function query(): iterable {
    return [
      'promocodes' => Promocode::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Promocodes';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.promocode.edit')
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('promocodes', [
        TD::make('code', 'Code')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promocode $promocode) {
            return Link::make(Str::ucfirst($promocode->code))
              ->route('platform.promocode.edit', $promocode->id);
          }),

        TD::make('discount', 'Discount')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promocode $promocode) {
            return $promocode->discount . '%';
          }),

        TD::make('expires_at', 'Expires at')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promocode $promocode) {
            return $promocode->expires_at;
          }),

        TD::make('updated_at', __('Last edit'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promocode $promocode) {
            return $promocode->updated_at->format('M j, Y');
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Promocode $promocode) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.promocode.edit', ['promocode' => $promocode])
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this promocode ?')
                ->method('remove')
                ->parameters([
                  'promocode' => $promocode->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Promocode $promocode) {
    $promocode->delete();
    Alert::info(__('Promocode was removed.'));
  }
}
