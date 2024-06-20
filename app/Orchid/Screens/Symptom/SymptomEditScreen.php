<?php

namespace App\Orchid\Screens\Symptom;

use App\Models\Symptom;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Rules\NameValidationRule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

class SymptomEditScreen extends Screen
{
    public $symptom;

    public function query(Symptom $symptom): iterable
    {

        return [
            'symptom' => $symptom,
            'symptoms' => Symptom::all(),
        ];
    }

    public function name(): ?string
    {
        return $this->symptom->exists ? 'Edit symptom' : 'Creating a new symptom';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Create symptom')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->symptom->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->symptom->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->symptom->exists)
                ->confirm('Are you sure you want to delete this symptom ?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('symptom.name')
                    ->required(!$this->symptom->exists)
                    ->placeholder('Symptom name')
                    ->title(__('Name:')),

                Input::make('symptom.image')
                    ->required(!$this->symptom->exists)
                    ->type('file')
                    ->title(__('Image:')),
            ]),

        ];
    }

    private function deleteSingleImage($image)
    {
        $image = str_replace(asset('storage/'), '', $image);
        Storage::disk('public')->delete($image);
    }

    public function create(Request $request)
    {
        $request->validate([
            'symptom.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'symptom.name' => [new NameValidationRule, 'unique:plants,name'],
        ]);

        $SymptomData = $request->input('symptom');

        if ($request->hasFile('symptom.image')) {
            $path = $request->file('symptom.image')->store('', 'public');
            if ($path !== false) {
                $SymptomData['image'] = asset('storage/' . $path);
            }
        }

        $SymptomData['name'] = ucwords($SymptomData['name']);

        $this->symptom->fill($SymptomData)->save();
        Alert::info('You have successfully created a symptom.');
        return redirect()->route('platform.symptom.list');
    }

    public function update(Request $request)
    {
        $request->validate([
            'symptom.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'symptom.name' => [new NameValidationRule, 'unique:plants,name'],
        ]);

        $SymptomData = $request->input('symptom');

        if ($request->hasFile('symptom.image')) {
            $this->deleteSingleImage($this->symptom->image);
            $path = $request->file('symptom.image')->store('', 'public');
            if ($path !== false) {
                $SymptomData['image'] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('symptom.images')) {
            $this->deleteMultipleImages(json_decode($this->symptom->images));
            $images = [];
            foreach ($request->file('symptom.images') as $certificate) {
                $path = $certificate->store('', 'public');
                if ($path !== false) {
                    $images[] = asset('storage/' . $path);
                }
            }
            $SymptomData['images'] = json_encode($images);
        }

        $SymptomData['name'] = ucwords($SymptomData['name']);

        $this->symptom->fill($SymptomData)->save();
        Alert::info('You have successfully updated the symptom.');
        return redirect()->route('platform.symptom.list');
    }

    public function remove(Symptom $symptom)
    {
        $this->deleteSingleImage($symptom->image);
        $this->deleteMultipleImages(json_decode($symptom->images));

        $symptom->delete();
        Alert::info('You have successfully deleted a symptom.');
        return redirect()->route('platform.symptom.list');
    }
}
