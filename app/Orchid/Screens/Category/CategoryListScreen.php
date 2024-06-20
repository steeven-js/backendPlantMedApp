<?php

namespace App\Orchid\Screens\Category;


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
use App\Models\Category;

class CategoryListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'categories' => Category::filters()->defaultSort('updated_at', 'desc')->paginate(10)
        ];
    }

    public function name(): ?string
    {
        return 'Categories';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('bs.plus-circle')
                ->route('platform.category.edit')
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('categories', [
                TD::make('image', 'Image')
                    ->cantHide()
                    ->render(function (Category $category) {
                        return '<img src="' . $category->image . '" width="40" height="40" style="object-fit: cover; object-position: center; border-radius: 7%;">';
                    }),

                TD::make('name', 'Name')
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Category $category) {
                        return Link::make(Str::ucfirst($category->name))
                            ->route('platform.category.edit', ['category' => $category]);
                    }),

                TD::make('updated_at', __('Last edit'))
                    ->sort()
                    ->cantHide()
                    ->filter(Input::make())
                    ->render(function (Category $category) {
                        return $category->updated_at->format('M j, Y');
                    }),

                TD::make(__('Actions'))
                    ->cantHide()
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Category $category) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.category.edit', ['category' => $category])
                                ->icon('bs.pencil'),
                            Button::make('Delete')
                                ->icon('bs.trash3')
                                ->confirm('Are you sure you want to delete this category ?')
                                ->method('remove')
                                ->parameters([
                                    'category' => $category->id,
                                ]),
                        ])),
            ])
        ];
    }

    private function deleteSingleImage($image)
    {
        $image = str_replace(asset('storage/'), '', $image);
        Storage::disk('public')->delete($image);
    }

    public function remove(Category $category)
    {

        $this->deleteSingleImage($category->image);

        $category->delete();
        Alert::info('You have successfully deleted the category.');
    }
}
