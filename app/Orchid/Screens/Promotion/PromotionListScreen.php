<?php

namespace App\Orchid\Screens\Promotion;


use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Plant;
use App\Models\Banner;
use App\Models\Promotion;

class PromotionListScreen extends Screen {
  public function query(): iterable {
    return [
      'promotions' => Promotion::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Promotions';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.promotion.edit')
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('promotions', [
        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promotion $promotion) {
            return Link::make(Str::ucfirst($promotion->name))
              ->route('platform.promotion.edit', ['promotion' => $promotion]);
          }),

        TD::make('updated_at', __('Last edit'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Promotion $promotion) {
            return $promotion->updated_at->format('M j, Y');
          }),


        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Promotion $promotion) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.promotion.edit', ['promotion' => $promotion])
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this promotion ?')
                ->method('remove')
                ->parameters([
                  'promotion' => $promotion->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Promotion $promotion) {
    $promotion->delete();
    Alert::info('You have successfully deleted the promotion.');
    return redirect()->route('platform.promotion.list');
  }
}
