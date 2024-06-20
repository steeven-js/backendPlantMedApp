<?php

namespace App\Orchid\Screens\Review;

use Orchid\Screen\Screen;

use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

use App\Models\Review;

class ReviewDetailScreen extends Screen {

  public function query(Review $review): iterable {
    return ['review' => $review];
  }

  public function name(): ?string {
    return 'Review Detail';
  }

  public function commandBar(): iterable {
    return [];
  }

  public function layout(): iterable {
    return [
      Layout::legend('review', [
        Sight::make('rating', 'Rating:')->render(function (Review $review) {
          return $review->rating;
        }),
        Sight::make('name', 'Name:')->render(function (Review $review) {
          return ucfirst($review->name);
        }),
        Sight::make('plant', 'Plant:')->render(function (Review $review) {
          return $review->plant;
        }),
        Sight::make('comment', 'Comment:')->render(function (Review $review) {
          return $review->comment;
        }),
        Sight::make('created_at', 'Created At:')->render(function (Review $review) {
          return $review->created_at;
        }),
      ])
    ];
  }
}
