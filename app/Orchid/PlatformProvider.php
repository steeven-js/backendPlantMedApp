<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;
use App\Models\Order;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [

            Menu::make('Plant Med')
                ->title('Plantmed')
                ->icon('bs.tree')
                ->route('platform.plantmed.list'),

            Menu::make('Symptoms')
                ->icon('bs.grid')
                ->route('platform.symptom.list'),

            Menu::make('Plants')
                ->title('Navigation')
                ->icon('bs.tree')
                ->route('platform.plant.list'),

            Menu::make('Orders')
                ->icon('bs.cart3')
                ->badge(function () {
                    if (Order::where('order_status', 'pending')->count() > 0) {
                        return Order::where('order_status', 'pending')->count();
                    }
                })
                ->route('platform.order.list'),

            Menu::make('Carousel')
                ->icon('bs.collection-play')
                ->route('platform.slide.list'),

            Menu::make('Categories')
                ->icon('bs.grid')
                ->route('platform.category.list'),

            Menu::make('Promocodes')
                ->icon('bs.percent')
                ->route('platform.promocode.list'),

            Menu::make('Types of Plants')
                ->icon('bs.list')
                ->route('platform.plant.type.list'),

            Menu::make('Types of Pots')
                ->icon('bs.list')
                ->route('platform.pot.type.list'),

            Menu::make('Colors')
                ->icon('bs.palette')
                ->route('platform.color.list'),

            Menu::make('Promotions')
                ->icon('bs.gift')
                ->route('platform.promotion.list'),

            Menu::make('Reviews')
                ->icon('bs.chat-left-text')
                ->route('platform.review.list'),

            Menu::make('App Users')
                ->icon('bs.person')
                ->route('platform.appuser.list'),

            Menu::make('Banner')
                ->icon('bs.image')
                ->route('platform.banner.list'),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make('Documentation')
                ->title('Docs')
                ->icon('bs.box-arrow-up-right')
                ->url('https://orchid.software/en/docs')
                ->target('_blank'),

            Menu::make('Changelog')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(fn () => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
