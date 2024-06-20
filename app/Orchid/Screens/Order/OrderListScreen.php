<?php

namespace App\Orchid\Screens\Order;

use Orchid\Screen\Screen;

use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

use App\Models\Order;

class OrderListScreen extends Screen {

  public function query(): iterable {
    return [
      'order' => Order::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Orders';
  }

  public function commandBar(): iterable {
    return [];
  }

  public function layout(): iterable {
    return [
      Layout::table('order', [
        TD::make('id', 'ID')
          ->cantHide()
          ->sort()
          ->render(function (Order $order) {
            return '#' . $order->id;
          }),

        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return Link::make(Str::ucfirst($order->name, 25))->route('platform.order.detail', $order->id);
          }),

        TD::make('phone_number', 'Phone')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return substr($order->phone_number, 0, 3) . '****' . substr($order->phone_number, -4);
          }),

        TD::make('total', 'Total')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return '$' . $order->total;
          }),

        TD::make('order_status', 'Status')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            if ($order->order_status == 'processing') {
              return '<i class="text-info">●</i> ' . ucfirst($order->order_status);
            }
            if ($order->order_status == 'completed') {
              return '<i class="text-success">●</i> ' . ucfirst($order->order_status);
            }
            if ($order->order_status == 'pending') {
              return '<i class="text-warning">●</i> ' . ucfirst($order->order_status);
            }
            if ($order->order_status == 'canceled') {
              return '<i class="text-danger">●</i> ' . ucfirst($order->order_status);
            }
          }),

        // date
        TD::make('created_at', 'Created')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return $order->created_at;
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->render(fn (Order $order) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([

              Link::make(__('Details'))
                ->route('platform.order.detail', $order->id)
                ->icon('bs.pencil'),

            ])),

      ])
    ];
  }
}
