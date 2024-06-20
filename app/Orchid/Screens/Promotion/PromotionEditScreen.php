<?php

namespace App\Orchid\Screens\Promotion;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Validation\Rule;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use App\Rules\NameValidationRule;
use Orchid\Support\Facades\Layout;

use App\Models\Plant;
use App\Models\Banner;
use App\Models\Promotion;

class PromotionEditScreen extends Screen {
  public $promotion;

  public function query(Promotion $promotion): iterable {
    return [
      'promotion' => $promotion
    ];
  }

  public function name(): ?string {
    return $this->promotion->exists ? 'Edit promotion' : 'Creating a new promotion';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create promotion')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->promotion->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->promotion->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->promotion->exists)
        ->confirm('Are you sure you want to delete this promotion ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('promotion.name')
          ->title(__('Name:'))
          ->required(!$this->promotion->exists)
          ->placeholder('Enter the name of the promotion')
      ])
    ];
  }

  public function create(Request $request) {
    $request->validate([
      'promotion.name' => [new NameValidationRule, 'unique:promotions,name'],
    ]);

    $promotionData = $request->input('promotion');
    $promotionData['name'] = ucwords($promotionData['name']);

    $this->promotion->fill($promotionData)->save();
    Alert::info('You have successfully created a promotion.');
    return redirect()->route('platform.promotion.list');
  }

  public function update(Request $request) {
    $request->validate([
      'promotion.name' => [new NameValidationRule, Rule::unique('promotions', 'name')->ignore($this->promotion->id)],
    ]);

    $promotionData = $request->input('promotion');
    $promotionData['name'] = ucwords($promotionData['name']);

    $this->promotion->fill($promotionData)->save();
    Alert::info('You have successfully updated a promotion.');
    return redirect()->route('platform.promotion.list');
  }

  public function remove(Promotion $promotion) {
    $promotion->delete();
    Alert::info('You have successfully deleted the promotion.');
    return redirect()->route('platform.promotion.list');
  }
}
