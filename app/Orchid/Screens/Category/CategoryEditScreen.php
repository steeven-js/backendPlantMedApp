<?php

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Illuminate\Validation\Rule;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use App\Rules\NameValidationRule;

class CategoryEditScreen extends Screen
{
    public $category;

    public function query(Category $category): iterable
    {
        return [
            'category' => $category,
        ];
    }

    public function name(): ?string
    {
        return $this->category->exists ? 'Edit category' : 'Creating a new category';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Create category')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->category->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->category->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists)
                ->confirm('Are you sure you want to delete this category ?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('category.name')
                    ->title(__('Name:'))
                    ->placeholder('Category name')
                    ->required(!$this->category->exists),

                Input::make('category.image')
                    ->type('file')
                    ->title(__('Image:'))
                    ->required(!$this->category->exists),
            ])
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
            'category.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category.name'  => [new NameValidationRule, 'unique:categories,name'],
        ]);

        $categoryData = $request->input('category');

        if ($request->hasFile('category.image')) {
            $path = $request->file('category.image')->store('', 'public');
            if ($path !== false) {
                $categoryData['image'] = asset('storage/' . $path);
            }
        }

        $categoryData['name'] = ucwords($categoryData['name']);

        $this->category->fill($categoryData)->save();
        Alert::info('You have successfully created a category.');
        return redirect()->route('platform.category.list');
    }

    public function update(Request $request)
    {

        $request->validate([
            'category.image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category.name' => [new NameValidationRule, Rule::unique('categories', 'name')->ignore($this->category->id)],
        ]);

        $categoryData = $request->input('category');
        $categoryData['image'] = $this->category->image;

        if ($request->hasFile('category.image')) {
            $this->deleteSingleImage($this->category->image);
            $path = $request->file('category.image')->store('', 'public');
            if ($path !== false) {
                $categoryData['image'] = asset('storage/' . $path);
            }
        }

        $categoryData['name'] = ucwords($categoryData['name']);

        $this->category->fill($categoryData)->save();
        Alert::info('You have successfully updated the category.');
        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category)
    {

        $this->deleteSingleImage($this->category->image);

        $category->delete();
        Alert::info('You have successfully deleted the category.');
        return redirect()->route('platform.category.list');
    }
}
