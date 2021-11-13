<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShipDivision;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if(Session::has('coupon')) {
          Session::forget('coupon');
        }

        if ($product->discount_price == NULL)
        {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'options' => [
                  'image' => $product->product_thambnail,
                  'color' => $request->color,
                  'size' => $request->size,
                ],
              ]);

            return response()->json(['success' => 'Successfully Add On Your Cart']);
        } else {
              Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => 1,
                'options' => [
                  'image' => $product->product_thambnail,
                  'color' => $request->color,
                  'size' => $request->size,
                ],
              ]);

          return response()->json(['success' => 'Successfully Add On Your Cart']);
        }
    }

    public function AddMiniCart()
    {
      $carts = Cart::content();
      $cartQty = Cart::count();
      $cartTotal = Cart::total();

      return response()->json(array(
        'carts' => $carts,
        'cartQty' => $cartQty,
        'cartTotal' => round($cartTotal),
      ));
    }

    public function RemoveMiniCart($rowId)
    {
      Cart::remove($rowId);
      return response()->json(['success' => 'Minicart Remove Successfully']);
    }

    public function AddToWishlist(Request $request, $product_id)
    {

      if(Auth::check())
      {
        $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();
        
        if(!$exists){
          Wishlist::insert([
            'user_id' => Auth::id(),
            'product_id' => $product_id,
            'created_at' => Carbon::now()
          ]);
  
          return response()->json(['success' => 'Successfully Add To Your Wishlist']);
        } else {
          return response()->json(['error' => 'This Product Has Already On Your Wishlist']);
        }
        
      } else {
        return response()->json(['error' => 'At First Login your account']);
      }

    }


    public function CouponApply(Request $request)
    {
       $coupon = Coupon::where('coupon_name', $request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();
       if ($coupon)
       {
           Session::put('coupon',[
             'coupon_name' => $coupon->coupon_name,
             'coupon_discount' => $coupon->coupon_discount,
             'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
             'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
           ]);

           return response()->json(array(
             'validity' => true,
             'success' => 'Coupon Applied Successfull'
           ));
       } else {
           return response()->json(['error' => 'Inviled Coupon']);
       }
    }

    public function CouponCalculation()
    {
      if (Session::has('coupon')) {
        return response()->json(array(
          'subtotal' => Cart::total(),
          'coupon_name' => session()->get('coupon')['coupon_name'],
          'coupon_discount' => session()->get('coupon')['coupon_discount'],
          'discount_amount' => session()->get('coupon')['discount_amount'],
          'total_amount' => session()->get('coupon')['total_amount'],
        ));
      } else {
        return response()->json(array(
          'total' => Cart::total(),
        ));
      }
    }

    public function CouponRemove()
    {
      Session::remove('coupon');
      return response()->json(['success' => 'Coupon Remove Successfully']);
    }

    public function CheckoutCreate()
    {
      if (Auth::check()) 
      {
        if (Cart::total() > 0)
        {
          $carts = Cart::content();
          $cartQty = Cart::count();
          $cartTotal = Cart::total();
          $divisions = ShipDivision::orderBy('division_name','ASC')->get();

          return view('frontend.checkout.checkout_view', compact('carts','cartQty','cartTotal','divisions'));
        } else {
          $notification = array(
            'message' => 'Shopping At List One Product',
            'alert-type' => 'error'
          );

          return redirect()->to('/')->with($notification);
        }
      } else {
        $notification = array(
          'message' => 'You Need To Login First',
          'alert_type' => 'error'
        );

        return redirect()->route('login')->with($notification);
      }
    }
}
