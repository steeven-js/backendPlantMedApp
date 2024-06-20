<?php

namespace App\Orchid\Screens\Plant;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;
use Illuminate\Support\Facades\Storage;

use App\Models\Plant;

class PlantListScreen extends Screen
{
    public $plant;

    public function query(Plant $plant): iterable
    {
        return [
            'plant' => $plant,
            'plants' => Plant::filters()->defaultSort('updated_at', 'desc')->paginate(10)
        ];
    }

    public function name(): ?string
    {
        return 'Plants';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('bs.plus-circle')
                ->route('platform.plant.edit')
        ];
    }

    private function deleteSingleImage($image)
    {
        $image = str_replace(asset('storage/'), '', $image);
        Storage::disk('public')->delete($image);
    }

    private function deleteMultipleImages($images)
    {
        foreach ($images as $image) {
            $image = str_replace(asset('storage/'), '', $image);
            Storage::disk('public')->delete($image);
        }
    }

    public function layout(): iterable
    {
        return [
            Layout::table('plants', [
                TD::make('image', 'Image')
                    ->cantHide()
                    ->render(function (Plant $plant) {
                        return '<img src="' . $plant->image . '" width="50" height="62.50" style="object-fit: cover; object-position: center; border-radius: 7%;">';
                    }),

                TD::make('name', 'Name')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Plant $plant) {
                        return Link::make(Str::ucfirst($plant->name))->route('platform.plant.edit', ['plant' => $plant]);
                    }),

                TD::make('price', 'Price')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Plant $plant) {
                        return '$' . $plant->price;
                    }),

                TD::make('old_price', 'Old Price')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Plant $plant) {
                        return $plant->old_price ? '<del>$' . $plant->old_price . '</del>' : '-';
                    }),

                TD::make('updated_at', __('Last edit'))
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Plant $plant) {
                        return $plant->updated_at->format('M j, Y');
                    }),

                TD::make('rating', 'Rating')
                    ->sort()
                    ->cantHide()
                    ->align(TD::ALIGN_CENTER)
                    ->filter(Input::make())
                    ->render(function (Plant $plant) {
                        return number_format($plant->rating, 2); // Округляем до 2 знаков после запятой
                    }),


                TD::make(__('Actions'))
                    ->cantHide()
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Plant $plant) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.plant.edit', ['plant' => $plant])
                                ->icon('bs.pencil'),
                            Button::make('Delete')
                                ->icon('bs.trash3')
                                ->confirm('Are you sure you want to delete this plant ?')
                                ->method('remove')
                                ->parameters([
                                    'plant' => $plant->id,
                                ]),
                        ])),
            ]),
        ];
    }

    public function remove(Plant $plant)
    {
        $this->deleteSingleImage($plant->image);
        $this->deleteMultipleImages(json_decode($plant->images));

        $plant->delete();
        Alert::info('You have successfully deleted the plant.');
    }
}
