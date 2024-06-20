<?php

namespace App\Orchid\Screens\PotType;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Plant;
use App\Models\PotType;

class PotTypeListScreen extends Screen {
  public function query(): iterable {
    return [
      'types' => PotType::filters()->defaultSort('updated_at', 'desc')->paginate(10),
    ];
  }

  public function name(): ?string {
    return 'Types of pots';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create new')
        ->icon('bs.plus-circle')
        ->route('platform.pot.type.edit'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('types', [
        TD::make('name', 'Name')
          ->sort()
          ->filter(Input::make())
          ->cantHide()
          ->render(function (PotType $type) {
            return Link::make($type->name)
              ->route('platform.pot.type.edit', ['type' => $type]);
          }),

        TD::make('updated_at', __('Last edit'))
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->render(function (PotType $type) {
            return $type->updated_at->format('M j, Y');
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (PotType $type) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.pot.type.edit', ['type' => $type])
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this type ?')
                ->method('remove')
                ->parameters([
                  'type' => $type->id,
                ]),
            ])),
      ]),
    ];
  }

  public function remove(PotType $type) {
    $type->delete();
    Alert::info('You have successfully deleted a type.');
    return redirect()->route('platform.pot.type.list');
  }
}
