<?php

namespace App\Orchid\Screens\Plant;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Switcher;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use App\Rules\NameValidationRule;
use Illuminate\Support\Facades\Storage;

use App\Models\Color;
use App\Models\Plant;
use App\Models\PotType;
use App\Models\Category;
use App\Models\PlantType;
use App\Models\Promotion;

class PlantEditScreen extends Screen
{

    public $plant;
    public $colors;
    public $pot_types;
    public $categories;
    public $promotions;
    public $plant_types;

    public function query(Plant $plant): iterable
    {

        return [
            'plant' => $plant,
            'plants' => Plant::all(),
            'colors' => Color::all(),
            'pot_types' => PotType::all(),
            'categories' => Category::all(),
            'promotions' => Promotion::all(),
            'plant_types' => PlantType::all(),
        ];
    }

    public function name(): ?string
    {
        return $this->plant->exists ? 'Edit plant' : 'Creating a new plant';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Create plant')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->plant->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->plant->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->plant->exists)
                ->confirm('Are you sure you want to delete this plant ?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('plant.name')
                    ->required(!$this->plant->exists)
                    ->placeholder('Plant name')
                    ->title(__('Name:')),

                TextArea::make('plant.description')
                    ->rows(5)
                    ->title(__('Description:'))
                    ->required(!$this->plant->exists)
                    ->placeholder('Enter short description'),

                Input::make('plant.price')
                    ->title('Price (USD):')
                    ->required(!$this->plant->exists)
                    ->mask([
                        'alias' => 'currency',
                        'groupSeparator' => '',
                        'digits' => 2,
                        'autoUnmask' => true,
                        'removeMaskOnSubmit' => true,
                    ])
                    ->placeholder('Enter price'),

                Input::make('plant.old_price')
                    ->title('Old price (USD):')
                    ->mask([
                        'alias' => 'currency',
                        'groupSeparator' => '',
                        'digits' => 2,
                        'autoUnmask' => true,
                        'removeMaskOnSubmit' => true,
                    ])
                    ->placeholder('Enter old price'),

                Select::make('plant.categories')
                    ->multiple()
                    ->title(__('Categories:'))
                    ->required(!$this->plant->exists)
                    ->disabled(!$this->categories->count())
                    ->fromModel(Category::class, 'name', 'name')
                    ->placeholder($this->categories->count() ? 'Select categories' : 'Please create categories first in the "Categories" section.'),

                Select::make('plant.colors')
                    ->multiple()
                    ->title(__('Colors:'))
                    ->required(!$this->plant->exists)
                    ->disabled(!$this->colors->count())
                    ->fromModel(Color::class, 'name', 'name')
                    ->placeholder($this->colors->count() ? 'Select colors' : 'Please create colors first in the "Colors" section.'),

                Select::make('plant.pot_types')
                    ->multiple()
                    ->title(__('Pot types:'))
                    ->required(!$this->plant->exists)
                    ->disabled(!$this->pot_types->count())
                    ->fromModel(PotType::class, 'name', 'name')
                    ->placeholder($this->pot_types->count() ? 'Select pot types' : 'Please create pot types first in the "Pot types" section.'),

                Select::make('plant.plant_types')
                    ->multiple()
                    ->title(__('Plant types:'))
                    ->required(!$this->plant->exists)
                    ->disabled(!$this->plant_types->count())
                    ->fromModel(PlantType::class, 'name', 'name')
                    ->placeholder($this->plant_types->count() ? 'Select plant types' : 'Please create plant types first in the "Plant types" section.'),

                Select::make('plant.promotion')
                    ->title(__('Promotion:'))
                    ->placeholder('Select promotion')
                    ->disabled(!$this->promotions->count())
                    ->fromModel(Promotion::class, 'name', 'name')
                    ->empty($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.')
                    ->placeholder($this->promotions->count() ? 'Select promotion' : 'Please create promotions first in the "promotions" section.'),

                Input::make('plant.image')
                    ->required(!$this->plant->exists)
                    ->type('file')
                    ->title(__('Image:')),

                Input::make('plant.images')
                    ->required(!$this->plant->exists)
                    ->type('file')
                    ->title(__('Images:'))
                    ->multiple(),
            ]),

            Layout::rows([
                CheckBox::make('plant.is_new')
                    ->value(0)
                    ->sendTrueOrFalse()
                    ->placeholder(__('New')),

                CheckBox::make('plant.is_top')
                    ->value(0)
                    ->sendTrueOrFalse()
                    ->placeholder(__('Top')),

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
                Switcher::make('plant.is_available')
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
            'plant.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'plant.name' => [new NameValidationRule, 'unique:plants,name'],
            'plant.price' => 'required|numeric',
            'plant.old_price' => 'nullable|numeric',
            'plant.description' => 'required|min:3|max:900',
            'plant.categories' => 'required',
            'plant.colors' => 'required',
            'plant.pot_types' => 'required',
            'plant.plant_types' => 'required',
            'plant.promotion' => 'nullable',
            'plant.is_new' => 'nullable',
            'plant.is_top' => 'nullable',
            'plant.is_featured' => 'nullable',
            'plant.is_best_seller' => 'nullable',
        ]);

        $plantData = $request->input('plant');

        if ($request->hasFile('plant.image')) {
            $path = $request->file('plant.image')->store('', 'public');
            if ($path !== false) {
                $plantData['image'] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('plant.images')) {
            $images = [];
            foreach ($request->file('plant.images') as $certificate) {
                $path = $certificate->store('', 'public');
                if ($path !== false) {
                    $images[] = asset('storage/' . $path);
                }
            }
            $plantData['images'] = json_encode($images);
        }

        $plantData['name'] = ucwords($plantData['name']);

        $this->plant->fill($plantData)->save();
        Alert::info('You have successfully created a plant.');
        return redirect()->route('platform.plant.list');
    }

    public function update(Request $request)
    {
        $request->validate([
            'plant.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'plant.name' => [new NameValidationRule, Rule::unique('plants', 'name')->ignore($this->plant->id)],
            'plant.price' => 'required|numeric',
            'plant.old_price' => 'nullable|numeric',
            'plant.description' => 'required|min:3|max:900',
            'plant.categories' => 'required',
            'plant.colors' => 'required',
            'plant.pot_types' => 'required',
            'plant.plant_types' => 'required',
            'plant.promotion' => 'nullable',
            'plant.is_new' => 'nullable',
            'plant.is_top' => 'nullable',
            'plant.is_featured' => 'nullable',
            'plant.is_best_seller' => 'nullable',
        ]);

        $plantData = $request->input('plant');

        if ($request->hasFile('plant.image')) {
            $this->deleteSingleImage($this->plant->image);
            $path = $request->file('plant.image')->store('', 'public');
            if ($path !== false) {
                $plantData['image'] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('plant.images')) {
            $this->deleteMultipleImages(json_decode($this->plant->images));
            $images = [];
            foreach ($request->file('plant.images') as $certificate) {
                $path = $certificate->store('', 'public');
                if ($path !== false) {
                    $images[] = asset('storage/' . $path);
                }
            }
            $plantData['images'] = json_encode($images);
        }

        $plantData['name'] = ucwords($plantData['name']);

        $this->plant->fill($plantData)->save();
        Alert::info('You have successfully updated the plant.');
        return redirect()->route('platform.plant.list');
    }

    public function remove(Plant $plant)
    {
        $this->deleteSingleImage($plant->image);
        $this->deleteMultipleImages(json_decode($plant->images));

        $plant->delete();
        Alert::info('You have successfully deleted a plant.');
        return redirect()->route('platform.plant.list');
    }
}
