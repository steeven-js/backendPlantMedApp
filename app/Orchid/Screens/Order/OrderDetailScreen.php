<?php

namespace App\Orchid\Screens\Order;

use Orchid\Screen\Screen;

use Orchid\Screen\TD;
use App\Models\Order;
use App\Models\Plant;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;

class OrderDetailScreen extends Screen {
  public $products;
  public $order;

  public function query(Order $order): iterable {
    return [
      'order' => Order::find($order->id),
      'plants' => collect($order->products)->mapInto(Plant::class),
    ];
  }

  public function name(): ?string {
    return 'Order Details';
  }

  public function commandBar(): iterable {
    return [

      Button::make('Accept')
        ->icon('check')
        ->method('accept')
        ->confirm('Are you sure you want to accept this order ?')
        ->canSee($this->order->order_status == 'pending' || $this->order->order_status == 'canceled'),

      Button::make('Decline')
        ->icon('bs.x-circle')
        ->method('decline')
        ->canSee($this->order->order_status == 'pending' || $this->order->order_status == 'processing')
        ->confirm('Are you sure you want to decline this order ?'),

    ];
  }

  public function layout(): iterable {

    return [
      Layout::legend('order', [
        Sight::make('id', 'Order ID:')->render(function (Order $order) {
          return '#' . $order->id;
        }),
        Sight::make('name', 'Name:')->render(function (Order $order) {
          return ucfirst($order->name);
        }),
        Sight::make('email', 'Email:')->render(function (Order $order) {
          return substr($order->email, 0, 3) . '****' . substr($order->email, strpos($order->email, '@'));
        }),
        Sight::make('phone_number', 'Phone Number:')->render(function (Order $order) {
          return substr($order->phone_number, 0, 3) . '****' . substr($order->phone_number, -4);
        }),
        Sight::make('address', 'Address:')->render(function (Order $order) {
          return $order->address;
        }),
        Sight::make('order_status', 'Status:')->render(function (Order $order) {
          if ($order->order_status == 'pending') {
            return '<i class="text-warning">●</i> ' . ucfirst($order->order_status);
          }
          if ($order->order_status == 'canceled') {
            return '<i class="text-danger">●</i> ' . ucfirst($order->order_status);
          }
          if ($order->order_status == 'completed') {
            return '<i class="text-success">●</i> ' . ucfirst($order->order_status);
          }
          if ($order->order_status == 'processing') {
            return '<i class="text-info">●</i> ' . ucfirst($order->order_status);
          }
          if ($order->order_status == 'on-hold') {
            return '<i class="text-warning">●</i> ' . ucfirst($order->order_status);
          }
          if ($order->order_status == 'refunded') {
            return '<i class="text-danger">●</i> ' . ucfirst($order->order_status);
          }
        }),
      ]),

      Layout::table('plants', [

        TD::make('name', 'Name')
          ->cantHide()
          ->render(function (Plant $plant) {
            return ucfirst($plant->name);
          }),

        TD::make('price', 'Price')
          ->cantHide()
          ->render(function (Plant $plant) {
            return '$' . $plant->price;
          }),

        TD::make('old_price', 'Old Price')
          ->cantHide()
          ->render(function (Plant $plant) {
            if ($plant->old_price == null) {
              return '-';
            }
            return '<del>$' . $plant->old_price . '</del>';
          }),

        TD::make('color', 'Color')
          ->cantHide()
          ->render(function (Plant $plant) {
            if ($plant->color == null) {
              return '-';
            }
            return $plant->color;
          }),

        TD::make('quantity', 'Quantity')
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->render(function (Plant $plant) {
            return $plant->quantity;
          }),
      ])->title('Products in order'),

      Layout::legend('order', [
        Sight::make('subtotal', 'Subtotal:')->render(function () {
          return '$' . $this->order->subtotal;
        }),
        Sight::make('total', 'Total:')->render(function () {
          return '$' . $this->order->total;
        }),
        Sight::make('discount', 'Discount:')->render(function () {
          return $this->order->discount . '%';
        }),
        Sight::make('delivery_price', 'Delivery:')->render(function () {
          if ($this->order->delivery == 'Free') {
            return '<span class="text-success">' . $this->order->delivery . '</span>';
          } else {
            return '$' . $this->order->delivery;
          }
        }),


      ])->title('Order Summary'),

      Layout::legend('order', [
        Sight::make('created_at', 'Created:')->render(function (Order $order) {
          return $order->created_at;
        }),
      ])->title('Date'),
    ];
  }

  public function remove(Order $order) {
    $order->delete();
    Alert::info('You have successfully deleted the order.');
    return redirect()->route('platform.order.list');
  }

  public function accept(Order $order) {
    $order->order_status = 'processing';
    $order->save();
    Alert::info('You have successfully accepted the order.');
    return redirect()->route('platform.order.list');
  }

  public function decline(Order $order) {
    $order->order_status = 'canceled';
    $order->save();
    Alert::info('You have successfully declined the order.');
    return redirect()->route('platform.order.list');
  }
}
