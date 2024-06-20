<?php

namespace App\Orchid\Screens\Color;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Color;

class ColorListScreen extends Screen {

  public function query(): iterable {
    return [
      'colors' => Color::filters()->defaultSort('updated_at', 'desc')->paginate(10),
    ];
  }

  public function name(): ?string {
    return 'Colors';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create new')
        ->icon('bs.plus-circle')
        ->route('platform.color.edit'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('colors', [
        TD::make('name', 'Name')
          ->sort()
          ->filter(Input::make())
          ->cantHide()
          ->render(function (Color $color) {
            return
              '<div class="d-flex align-items-center">'
              . '<div class="mr-2" style="border-radius: 3px; margin-right: 6px; width: 14px; height: 14px; background-color: ' . $color->code . '"></div>'
              . '<div>' . Link::make($color->name)->route('platform.color.edit', $color) . '</div>'
              . '</div>';
          }),

        TD::make('updated_at', __('Last edit'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Color $color) {
            return $color->updated_at->format('M j, Y');
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Color $color) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.color.edit', $color->id)
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this color ?')
                ->method('remove')
                ->parameters([
                  'color' => $color->id,
                ]),
            ])),
      ]),
    ];
  }

  public function remove(Color $color) {
    $color->delete();
    Alert::info('You have successfully deleted a color.');
    return redirect()->route('platform.color.list');
  }
}
