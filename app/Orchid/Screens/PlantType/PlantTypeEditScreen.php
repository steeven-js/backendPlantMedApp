<?php

namespace App\Orchid\Screens\PlantType;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Validation\Rule;
use Orchid\Support\Facades\Alert;
use App\Rules\NameValidationRule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;

use App\Models\PlantType;

class PlantTypeEditScreen extends Screen {
  public $type;

  public function query(PlantType $type): iterable {
    return ['type' => $type];
  }

  public function name(): ?string {
    return $this->type->exists ? 'Edit plant type' : 'Create plant type';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create type')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->type->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->type->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->type->exists)
        ->confirm('Are you sure you want to delete this type ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('type.name')
          ->title('Name')
          ->required(!$this->type->exists)
          ->placeholder('Enter plant type name'),
      ]),
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'type.name' => [new NameValidationRule, 'unique:plant_types,name'],
    ]);

    $plantTypeData = $request->input('type');
    $plantTypeData['name'] = ucwords($plantTypeData['name']);

    $this->type->fill($plantTypeData)->save();
    Alert::info('You have successfully created a type.');
    return redirect()->route('platform.plant.type.list');
  }

  public function update(Request $request) {

    $request->validate([
      'type.name' => [new NameValidationRule, Rule::unique('plant_types', 'name')->ignore($this->type->id)],
    ]);

    $plantTypeData = $request->input('type');
    $plantTypeData['name'] = ucwords($plantTypeData['name']);

    $this->type->fill($plantTypeData)->save();
    Alert::info('You have successfully updated a type.');
    return redirect()->route('platform.plant.type.list');
  }

  public function remove(PlantType $type) {
    $type->delete();
    Alert::info('You have successfully deleted a type.');
    return redirect()->route('platform.plant.type.list');
  }
}
