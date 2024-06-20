<?php

namespace App\Orchid\Screens\Banner;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use App\Rules\NameValidationRule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

use App\Models\Banner;
use App\Models\Promotion;

class BannerEditScreen extends Screen {
  public $banner;
  public $promotions;

  public function query(Banner $banner): iterable {
    return [
      'banner' => $banner,
      'promotions' => Promotion::all(),
    ];
  }

  public function name(): ?string {
    return $this->banner->exists ? 'Edit banner' : 'Creating a new banner';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create banner')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->banner->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->banner->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->banner->exists)
        ->confirm('Are you sure you want to delete this banner ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Select::make('banner.promotion')
          ->title(__('Promotion:'))
          ->required(!$this->banner->exists)
          ->placeholder('Select promotion')
          ->disabled(!$this->promotions->count())
          ->fromModel(Promotion::class, 'name', 'name')
          ->empty($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.')
          ->placeholder($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.'),

        Input::make('banner.image')
          ->required(!$this->banner->exists)
          ->type('file')
          ->title(__('Image:')),
      ]),

    ];
  }

  private function deleteSingleImage($image) {
    $image = str_replace(asset('storage/'), '', $image);
    Storage::disk('public')->delete($image);
  }

  public function create(Request $request) {
    $request->validate([
      'banner.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'banner.promotion' => [new NameValidationRule, 'unique:banners,promotion']
    ]);

    $bannerData['promotion'] = $request->input('banner.promotion');

    if ($request->hasFile('banner.image')) {
      $path = $request->file('banner.image')->store('', 'public');
      if ($path !== false) {
        $bannerData['image'] = asset('storage/' . $path);
      }
    }

    $this->banner->fill($bannerData)->save();
    Alert::info('You have successfully created a banner.');
    return redirect()->route('platform.banner.list');
  }

  public function update(Request $request) {

    $request->validate([
      'banner.image' => 'image|mimes:jpeg,png,jpg|max:2048',
      'banner.promotion' => [new NameValidationRule, Rule::unique('banners', 'promotion')->ignore($this->banner->id)],
    ]);

    $bannerData['promotion'] = $request->input('banner.promotion');

    if ($request->hasFile('banner.image')) {
      $this->deleteSingleImage($this->banner->image);
      $path = $request->file('banner.image')->store('', 'public');
      if ($path !== false) {
        $bannerData['image'] = asset('storage/' . $path);
      }
    }

    $this->banner->fill($bannerData)->save();
    Alert::info('You have successfully updated the banner.');
    return redirect()->route('platform.banner.list');
  }

  public function remove(Banner $banner) {
    $this->deleteSingleImage($this->banner->image);

    $banner->delete();
    Alert::info('You have successfully deleted the banner.');
    return redirect()->route('platform.banner.list');
  }
}
