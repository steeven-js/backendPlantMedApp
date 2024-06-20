<?php

namespace App\Orchid\Screens\Review;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Review;

class ReviewListScreen extends Screen {

  public function query(): iterable {
    return [
      'reviews' => Review::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Reviews';
  }

  public function commandBar(): iterable {
    return [];
  }

  public function layout(): iterable {
    return [
      Layout::table('reviews', [

        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Review $review) {
            return Link::make(Str::ucfirst(Str::limit($review->name, 25)))
              ->route('platform.review.detail', ['review' => $review]);
          }),

        TD::make('plant', 'Plant')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->render(function (Review $review) {
            return Str::limit($review->plant, 25);
          }),

        TD::make('comment', 'Comment')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->render(function (Review $review) {
            return Str::limit($review->comment, 50);
          }),

        TD::make('rating', 'Rating')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->align(TD::ALIGN_CENTER)
          ->render(function (Review $review) {
            return $review->rating;
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Review $review) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Detail'))
                ->route('platform.review.detail', ['review' => $review])
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this review ?')
                ->method('remove')
                ->parameters([
                  'review' => $review->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Review $review) {
    $review->delete();
    Alert::info('You have successfully deleted a review.');
  }
}
