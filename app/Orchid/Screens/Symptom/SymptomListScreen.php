<?php

namespace App\Orchid\Screens\Symptom;

use Orchid\Screen\TD;
use App\Models\Symptom;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;
use Illuminate\Support\Facades\Storage;

class SymptomListScreen extends Screen
{
    public $symptom;

    public function query(Symptom $symptom): iterable
    {
        return [
            'symptom' => $symptom,
            'symptoms' => Symptom::filters()->defaultSort('updated_at', 'desc')->paginate(10)
        ];
    }

    public function name(): ?string
    {
        return 'symptoms';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('bs.plus-circle')
                ->route('platform.symptom.edit')
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
            Layout::table('symptoms', [
                TD::make('image', 'Image')
                    ->cantHide()
                    ->render(function (Symptom $symptom) {
                        return '<img src="' . $symptom->image . '" width="50" height="62.50" style="object-fit: cover; object-position: center; border-radius: 7%;">';
                    }),

                TD::make('name', 'Name')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Symptom $symptom) {
                        return Link::make(Str::ucfirst($symptom->name))->route('platform.symptom.edit', ['symptom' => $symptom]);
                    }),

                TD::make('updated_at', __('Last edit'))
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Symptom $symptom) {
                        return $symptom->updated_at->format('M j, Y');
                    }),

                TD::make(__('Actions'))
                    ->cantHide()
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Symptom $symptom) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.symptom.edit', ['symptom' => $symptom])
                                ->icon('bs.pencil'),
                            Button::make('Delete')
                                ->icon('bs.trash3')
                                ->confirm('Are you sure you want to delete this symptom ?')
                                ->method('remove')
                                ->parameters([
                                    'symptom' => $symptom->id,
                                ]),
                        ])),
            ]),
        ];
    }

    public function remove(Symptom $symptom)
    {
        $this->deleteSingleImage($symptom->image);
        $this->deleteMultipleImages(json_decode($symptom->images));

        $symptom->delete();
        Alert::info('You have successfully deleted the symptom.');
    }
}
