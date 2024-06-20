<?php

namespace App\Orchid\Screens\Carousel;

use Orchid\Screen\Screen;

use Orchid\Screen\TD;
use App\Models\Slide;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;
use Illuminate\Support\Facades\Storage;

class SlideListScreen extends Screen {
  public $slides;

  public function query(): iterable {
    return [
      'slides' => Slide::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Slides';
  }

  public function description(): ?string {
    return 'You can create maximum 3 slides.';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.slide.edit')
        ->canSee($this->slides->count() < 3),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('slides', [

        TD::make('id', 'Slide')
          ->cantHide()
          ->render(function (Slide $slide) {
            return '<img src="' . $slide->image . '" width="75" height="100" style="object-fit: cover; object-position: center;">';
          }),


        TD::make('title_line_1', 'Title line 1')
          ->cantHide()
          ->filter()
          ->sort()
          ->render(function (Slide $slide) {
            $string = Str::limit($slide->title_line_1, 20);

            return Link::make(Str::ucfirst($string))
              ->route('platform.slide.edit', ['slide' => $slide->id]);
          }),

        TD::make('title_line_2', 'Title line 2')
          ->cantHide()
          ->filter()
          ->sort()
          ->render(function (Slide $slide) {
            $string = Str::limit($slide->title_line_1, 25);
            return Link::make(Str::ucfirst($string))
              ->route('platform.slide.edit', ['slide' => $slide->id]);
          }),

        TD::make('promotion', 'Promotion')
          ->cantHide()
          ->filter()
          ->sort()
          ->render(function (Slide $slide) {

            return Link::make(Str::limit(ucfirst($slide->promotion), 20))
              ->route('platform.slide.edit', $slide->id);
          }),



        TD::make('updated_at', __('Last edit'))
          ->cantHide()
          ->sort()
          ->filter()
          ->render(function (Slide $slide) {
            return $slide->updated_at->format('M j, Y');
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Slide $slide) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.slide.edit', ['slide' => $slide])
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this slide ?')
                ->method('remove')
                ->parameters([
                  'slide' => $slide->id,
                ]),
            ])),
      ]),
    ];
  }

  private function deleteSingleImage($image) {
    $image = str_replace(asset('storage/'), '', $image);
    Storage::disk('public')->delete($image);
  }

  public function remove(Slide $slide) {
    $this->deleteSingleImage($slide->image);

    $slide->delete();
    Alert::info('You have successfully deleted the slide.');
    return redirect()->route('platform.slide.list');
  }
}
