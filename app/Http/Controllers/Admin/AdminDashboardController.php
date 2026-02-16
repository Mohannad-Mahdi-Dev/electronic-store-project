<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ✅ السماح للسوبر أدمن (1) والسَب أدمن (2)
        if (!in_array((int) auth()->user()->role_id, [1, 2])) {
            return redirect()->route('home'); // أو redirect('/')
        }

        $productsCount = Product::count();
        $ordersCount   = Order::count();

        // ✅ العملاء هم role_id = 3 (لأنك قلت user = 3)
        $customersCount = User::where('role_id', 3)->count();

        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // Total Sales (only completed orders)
        $totalSales = Order::where('status', 'completed')->sum('total');

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('dsadmin.dashboard', compact(
            'productsCount',
            'ordersCount',
            'customersCount',
            'latestOrders',
            'ordersByStatus',
            'totalSales'
        ));
    }
}
?>
<!-- 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {

        
        $productsCount = Product::count();
        $ordersCount   = Order::count();


        $customersCount = User::where('role_id', 2)->count();


        $latestOrders = Order::with('user')->latest()->take(5)->get();


        $ordersByStatus = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        // أذا انت تشتي تعمل شرط للدخول لل user و ال admin من هنا 
        //عرض البيانات في لوحة التحكم 
        return view('dsadmin.dashboard', compact(
            'productsCount',
            'ordersCount',
            'customersCount',
            'latestOrders',
            'ordersByStatus'
        ));


                    
        } else {
            return redirect()->route('/');
        }
    }
    
} -->