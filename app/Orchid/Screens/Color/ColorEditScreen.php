<?php

namespace App\Orchid\Screens\Color;


use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

use App\Models\Plant;
use App\Models\Color;

use App\Rules\NameValidationRule;

class ColorEditScreen extends Screen {
  public $color;

  public function query(Color $color): iterable {
    return ['color' => $color];
  }

  public function name(): ?string {
    return $this->color->exists ? 'Edit color' : 'Create color';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create color')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->color->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->color->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->color->exists)
        ->confirm('Are you sure you want to delete this color ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('color.name')
          ->title('Name')
          ->placeholder('Enter color name')
          ->required(!$this->color->exists),

        Input::make('color.code')
          ->type('color')
          ->title('Color')
          ->value('#563d7c')
          ->required(!$this->color->exists),
      ]),
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'color.name'  => [new NameValidationRule, 'unique:colors,name'],
      'color.code' => [new NameValidationRule, 'unique:colors,code']
    ]);

    $colorData = $request->input('color');

    $this->color->fill($colorData)->save();
    Alert::info('You have successfully created a color.');
    return redirect()->route('platform.color.list');
  }

  public function update(Request $request) {
    $colorData = $request->input('color');

    $request->validate([
      'color.name'  => [new NameValidationRule, Rule::unique('colors', 'name')->ignore($this->color->id)],
      'color.code' => [new NameValidationRule, Rule::unique('colors', 'code')->ignore($this->color->id)]
    ]);

    $this->color->fill($colorData)->save();
    Alert::info('You have successfully updated a color.');
    return redirect()->route('platform.color.list');
  }

  public function remove(Color $color) {
    $color->delete();
    Alert::info('You have successfully deleted a color.');
    return redirect()->route('platform.color.list');
  }
}
