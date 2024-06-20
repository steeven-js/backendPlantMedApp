<?php

namespace App\Orchid\Screens\PlantMed;

use App\Models\Symptom;
use App\Models\PlantMed;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Rules\NameValidationRule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

class PlantMedEditScreen extends Screen
{

    public $plantmed;
    public $symptoms;

    public function query(PlantMed $plantmed): iterable
    {

        return [
            'plantmed' => $plantmed,
            'plantmeds' => PlantMed::all(),
            'symptoms' => Symptom::all(),
        ];
    }

    public function name(): ?string
    {
        return $this->plantmed->exists ? 'Edit plantmed' : 'Creating a new plantmed';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Create plantmed')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->plantmed->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->plantmed->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->plantmed->exists)
                ->confirm('Are you sure you want to delete this plantmed ?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('plantmed.name')
                    ->required(!$this->plantmed->exists)
                    ->placeholder('Plant name')
                    ->title(__('Name:')),

                TextArea::make('plantmed.description')
                    ->rows(5)
                    ->title(__('Description:'))
                    ->required(!$this->plantmed->exists)
                    ->placeholder('Enter short description'),

                Select::make('plantmed.symptoms')
                    ->multiple()
                    ->title(__('Symptoms:'))
                    ->required(!$this->plantmed->exists)
                    ->disabled(!$this->symptoms->count())
                    ->fromModel(Symptom::class, 'name', 'name')
                    ->placeholder($this->symptoms->count() ? 'Select symptoms' : 'Please create symptoms first in the "Categories" section.'),

                Input::make('plantmed.image')
                    ->required(!$this->plantmed->exists)
                    ->type('file')
                    ->title(__('Image:')),

                Input::make('plantmed.images')
                    ->required(!$this->plantmed->exists)
                    ->type('file')
                    ->title(__('Images:'))
                    ->multiple(),
            ]),

            Layout::rows([
                CheckBox::make('plant.is_featured')
                    ->value(0)
                    ->sendTrueOrFalse()
                    ->placeholder(__('Featured')),

                CheckBox::make('plant.is_best_seller')
                    ->value(0)
                    ->sendTrueOrFalse()
                    ->placeholder(__('Best seller')),
            ]),

            Layout::rows([
                Switcher::make('plantmed.is_available')
                    ->value(1)
                    ->sendTrueOrFalse()
                    ->placeholder('Available & Unavailable'),
            ])

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

    public function create(Request $request)
    {
        $request->validate([
            'plantmed.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'plantmed.name' => [new NameValidationRule, 'unique:plants,name'],
            'plantmed.description' => 'required|min:3|max:900',
            'plantmed.symptoms' => 'required',
            'plant.is_featured' => 'nullable',
            'plant.is_best_seller' => 'nullable',
        ]);

        $plantData = $request->input('plantmed');

        if ($request->hasFile('plantmed.image')) {
            $path = $request->file('plantmed.image')->store('', 'public');
            if ($path !== false) {
                $plantData['image'] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('plantmed.images')) {
            $images = [];
            foreach ($request->file('plantmed.images') as $certificate) {
                $path = $certificate->store('', 'public');
                if ($path !== false) {
                    $images[] = asset('storage/' . $path);
                }
            }
            $plantData['images'] = json_encode($images);
        }

        $plantData['name'] = ucwords($plantData['name']);

        $this->plantmed->fill($plantData)->save();
        Alert::info('You have successfully created a plantmed.');
        return redirect()->route('platform.plantmed.list');
    }

    public function update(Request $request)
    {
        $request->validate([
            'plantmed.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'plantmed.name' => [new NameValidationRule, 'unique:plants,name'],
            'plantmed.description' => 'required|min:3|max:900',
            'plantmed.symptoms' => 'required',
            'plant.is_featured' => 'nullable',
            'plant.is_best_seller' => 'nullable',
        ]);

        $plantData = $request->input('plantmed');

        if ($request->hasFile('plantmed.image')) {
            $this->deleteSingleImage($this->plantmed->image);
            $path = $request->file('plantmed.image')->store('', 'public');
            if ($path !== false) {
                $plantData['image'] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('plantmed.images')) {
            $this->deleteMultipleImages(json_decode($this->plantmed->images));
            $images = [];
            foreach ($request->file('plantmed.images') as $certificate) {
                $path = $certificate->store('', 'public');
                if ($path !== false) {
                    $images[] = asset('storage/' . $path);
                }
            }
            $plantData['images'] = json_encode($images);
        }

        $plantData['name'] = ucwords($plantData['name']);

        $this->plantmed->fill($plantData)->save();
        Alert::info('You have successfully updated the plantmed.');
        return redirect()->route('platform.plantmed.list');
    }

    public function remove(Plant $plantmed)
    {
        $this->deleteSingleImage($plantmed->image);
        $this->deleteMultipleImages(json_decode($plantmed->images));

        $plantmed->delete();
        Alert::info('You have successfully deleted a plantmed.');
        return redirect()->route('platform.plantmed.list');
    }
}
