<?php

namespace App\Orchid\Screens\PlantType;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\PlantType;

class PlantTypeListScreen extends Screen {
  public function query(): iterable {
    return [
      'types' => PlantType::filters()->defaultSort('updated_at', 'desc')->paginate(10),
    ];
  }

  public function name(): ?string {
    return 'Types of plants';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create new')
        ->icon('bs.plus-circle')
        ->route('platform.plant.type.edit'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('types', [
        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (PlantType $type) {
            return Link::make($type->name)
              ->route('platform.plant.type.edit', ['type' => $type]);
          }),

        TD::make('updated_at', __('Last edit'))
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->render(function (PlantType $type) {
            return $type->updated_at->format('M j, Y');
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (PlantType $type) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.plant.type.edit', ['type' => $type])
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

  public function remove(PlantType $type) {
    $type->delete();
    Alert::info('You have successfully deleted a type.');
    return redirect()->route('platform.plant.type.list');
  }
}
