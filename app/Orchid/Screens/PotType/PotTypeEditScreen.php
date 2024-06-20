<?php

namespace App\Orchid\Screens\PotType;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Validation\Rule;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use App\Rules\NameValidationRule;

use App\Models\PotType;

class PotTypeEditScreen extends Screen {
  public $type;

  public function query(PotType $type): iterable {
    return ['type' => $type];
  }

  public function name(): ?string {
    return $this->type->exists ? 'Edit pot type' : 'Create pot type';
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
          ->placeholder('Enter pot type name'),
      ]),
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'type.name' => [new NameValidationRule, 'unique:pot_types,name'],
    ]);

    $potTypeData = $request->input('type');
    $potTypeData['name'] = ucwords($potTypeData['name']);

    $this->type->fill($potTypeData)->save();
    Alert::info('You have successfully created a type.');
    return redirect()->route('platform.pot.type.list');
  }

  public function update(Request $request) {
    $request->validate([
      'type.name' => [new NameValidationRule, Rule::unique('pot_types', 'name')->ignore($this->type->id)],
    ]);

    $potTypeData = $request->input('type');
    $potTypeData['name'] = ucwords($potTypeData['name']);

    $this->type->fill($potTypeData)->save();
    Alert::info('You have successfully updated a type.');
    return redirect()->route('platform.pot.type.list');
  }

  public function remove(PotType $type) {
    $type->delete();
    Alert::info('You have successfully deleted a type.');
    return redirect()->route('platform.pot.type.list');
  }
}
