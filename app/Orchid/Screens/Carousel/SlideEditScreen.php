<?php

namespace App\Orchid\Screens\Carousel;

use Orchid\Screen\Screen;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

use App\Models\Slide;
use App\Models\Promotion;

use App\Rules\NameValidationRule;

class SlideEditScreen extends Screen {
  public $slide;
  public $promotions;

  public function query(Slide $slide): iterable {
    return [
      'slide' => $slide,
      'promotions' => Promotion::all(),
    ];
  }

  public function name(): ?string {
    return $this->slide->exists ? 'Edit slide' : 'Creating a new slide';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create slide')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->slide->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->slide->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->slide->exists)
        ->confirm('Are you sure you want to delete this slide ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('slide.title_line_1')
          ->title(__('Title Line 1:'))
          ->required()
          ->placeholder('Enter title line 1'),

        Input::make('slide.title_line_2')
          ->title(__('Title Line 2:'))
          ->required()
          ->placeholder('Enter title line 2'),

        Select::make('slide.promotion')
          ->title(__('Promotion:'))
          ->placeholder('Select promotion')
          ->disabled(!$this->promotions->count())
          ->fromModel(Promotion::class, 'name', 'name')
          ->empty($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.')
          ->placeholder($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.'),

        Input::make('slide.image')
          ->required(!$this->slide->exists)
          ->type('file')
          ->title('Image'),

      ]),
    ];
  }

  private function deleteSingleImage($image) {
    $image = str_replace(asset('storage/'), '', $image);
    Storage::disk('public')->delete($image);
  }

  public function create(Request $request) {
    $request->validate([
      'slide.image'        => 'image|mimes:jpeg,png,jpg|max:2048',
      'slide.title_line_1' => [new NameValidationRule],
      'slide.title_line_2' => [new NameValidationRule],
      'slide.promotion'    => [new NameValidationRule],
    ]);

    $slideData = $request->input('slide');

    if ($request->hasFile('slide.image')) {
      $path = $request->file('slide.image')->store('', 'public');
      if ($path !== false) {
        $slideData['image'] = asset('storage/' . $path);
      }
    }

    $slideData['title_line_1'] = ucwords($slideData['title_line_1']);
    $slideData['title_line_2'] = ucwords($slideData['title_line_2']);

    $this->slide->fill($slideData)->save();
    Alert::info('You have successfully created a slide.');
    return redirect()->route('platform.slide.list');
  }

  public function update(Request $request) {
    $request->validate([
      'slide.image'        => 'image|mimes:jpeg,png,jpg|max:2048',
      'slide.title_line_1' => [new NameValidationRule],
      'slide.title_line_2' => [new NameValidationRule],
      'slide.promotion'    => [new NameValidationRule],
    ]);

    $slideData = $request->input('slide');

    if ($request->hasFile('slide.image')) {
      $this->deleteSingleImage($this->slide->image);
      $path = $request->file('slide.image')->store('', 'public');
      if ($path !== false) {
        $slideData['image'] = asset('storage/' . $path);
      }
    }

    $slideData['title_line_1'] = ucwords($slideData['title_line_1']);
    $slideData['title_line_2'] = ucwords($slideData['title_line_2']);

    $this->slide->fill($slideData)->save();
    Alert::info('You have successfully updated the slide.');
    return redirect()->route('platform.slide.list');
  }

  public function remove(Slide $slide) {
    $this->deleteSingleImage($slide->image);

    $slide->delete();
    Alert::info('You have successfully deleted the slide.');
    return redirect()->route('platform.slide.list');
  }
}
