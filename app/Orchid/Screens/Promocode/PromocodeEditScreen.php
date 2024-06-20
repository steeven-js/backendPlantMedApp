<?php

namespace App\Orchid\Screens\Promocode;

use Orchid\Screen\Screen;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\DateTimer;

use App\Models\Promocode;
use App\Rules\NameValidationRule;

class PromocodeEditScreen extends Screen {
  public $promocode;

  public function query(Promocode $promocode): iterable {
    return [
      'promocode' => $promocode,
    ];
  }

  public function name(): ?string {
    return $this->promocode->exists ? 'Edit promocode' : 'Creating a new promocode';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create promocode')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->promocode->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->promocode->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->promocode->exists)
        ->confirm('Are you sure you want to delete this promocode ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('promocode.code')
          ->type('text')
          ->title('Code')
          ->required(!$this->promocode->exists)
          ->placeholder('Enter code'),

        Input::make('promocode.discount')
          ->type('number')
          ->title('Discount')
          ->required(!$this->promocode->exists)
          ->placeholder('Enter discount in %'),

        DateTimer::make('promocode.expires_at')
          ->title('Expires at')
          ->required(!$this->promocode->exists)
          ->enableTime(false)
          ->format('M d, Y'),
      ])
    ];
  }

  public function create(Request $request) {
    $request->validate([
      'promocode.code'  => [new NameValidationRule, 'unique:promocodes,code'],
      'promocode.discount' => 'required|numeric|min:1|max:100',
      'promocode.expires_at' => 'required|after_or_equal:now',
    ]);

    $promocodeData = $request->get('promocode');
    $promocodeData['expires_at'] = date('Y-m-d H:i:s', strtotime($promocodeData['expires_at']));

    $this->promocode->fill($promocodeData)->save();
    Alert::info('Promocode created');
    return redirect()->route('platform.promocode.list');
  }

  public function update(Promocode $promocode, Request $request) {

    $request->validate([
      'promocode.code' => [new NameValidationRule, Rule::unique('promocodes', 'code')->ignore($promocode->id)],
      'promocode.discount' => 'required|numeric|min:1|max:100',
      'promocode.expires_at' => 'required|after_or_equal:now',
    ]);

    $promocodeData = $request->get('promocode');
    $promocodeData['expires_at'] = date('Y-m-d H:i:s', strtotime($promocodeData['expires_at']));

    $promocode->fill($promocodeData)->save();

    Alert::info('Promocode updated');
    return redirect()->route('platform.promocode.list');
  }

  public function remove(Promocode $promocode) {
    $promocode->delete();

    Alert::info('Promocode deleted');
    return redirect()->route('platform.promocode.list');
  }
}
