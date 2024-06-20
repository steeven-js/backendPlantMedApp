<?php

namespace App\Orchid\Screens\PlantMed;

use Orchid\Screen\TD;
use App\Models\PlantMed;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;
use Illuminate\Support\Facades\Storage;

class PlantMedListScreen extends Screen
{
    public $plantmed;

    public function query(PlantMed $plantmed): iterable
    {
        return [
            'plantmed' => $plantmed,
            'plants' => PlantMed::filters()->defaultSort('updated_at', 'desc')->paginate(10)
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
                ->route('platform.plantmed.edit')
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
                    ->render(function (PlantMed $plantmed) {
                        return '<img src="' . $plantmed->image . '" width="50" height="62.50" style="object-fit: cover; object-position: center; border-radius: 7%;">';
                    }),

                TD::make('name', 'Name')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (PlantMed $plantmed) {
                        return Link::make(Str::ucfirst($plantmed->name))->route('platform.plantmed.edit', ['plantmed' => $plantmed]);
                    }),

                TD::make('updated_at', __('Last edit'))
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (PlantMed $plantmed) {
                        return $plantmed->updated_at->format('M j, Y');
                    }),

                TD::make(__('Actions'))
                    ->cantHide()
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (PlantMed $plantmed) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.plantmed.edit', ['plantmed' => $plantmed])
                                ->icon('bs.pencil'),
                            Button::make('Delete')
                                ->icon('bs.trash3')
                                ->confirm('Are you sure you want to delete this plantmed ?')
                                ->method('remove')
                                ->parameters([
                                    'plantmed' => $plantmed->id,
                                ]),
                        ])),
            ]),
        ];
    }

    public function remove(PlantMed $plantmed)
    {
        $this->deleteSingleImage($plantmed->image);
        $this->deleteMultipleImages(json_decode($plantmed->images));

        $plantmed->delete();
        Alert::info('You have successfully deleted the plantmed.');
    }
}
