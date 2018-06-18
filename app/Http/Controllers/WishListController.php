<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 5/24/2017
 * Time: 10:12 PM
 */

namespace App\Http\Controllers;


class WishListController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $items = [];
            $wish_list = app('wishlist');

            $wish_list->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });

            return response(array(
                'success' => true,
                'data' => $items,
                'message' => 'wishlist get items success'
            ),200,[]);
        }
        else
        {
            return view('cart');
        }
    }

    public function add()
    {
        $wish_list = app('wishlist');
        $id = request('id');
        $name = request('name');
        $price = request('price');
        $qty = request('qty');

        $wish_list->add($id, $name, $price, $qty, array());
    }

    public function delete($id)
    {
        $wish_list = app('wishlist');

        $wish_list->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ),200,[]);
    }

    public function details()
    {
        $wish_list = app('wishlist');

        return response(array(
            'success' => true,
            'data' => array(
                'total_quantity' => $wish_list->getTotalQuantity(),
                'sub_total' => $wish_list->getSubTotal(),
                'total' => $wish_list->getTotal(),
            ),
            'message' => "Get wishlist details success."
        ),200,[]);
    }
}