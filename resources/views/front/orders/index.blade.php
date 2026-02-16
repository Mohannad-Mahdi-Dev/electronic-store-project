@extends('front.layouts.app')

{{-- 
    صفحة طلبات المستخدم
    User Orders Page
    
    Features:
    - عرض جميع طلبات المستخدم / Display all user orders
    - فلترة حسب الحالة / Filter by status
    - بحث بالطلب / Search by order
    - تصميم responsive / Responsive design
    
    Future Enhancements:
    - تصدير الطلبات إلى Excel/PDF / Export orders to Excel/PDF
    - فلترة متقدمة (حسب التاريخ، السعر) / Advanced filtering (by date, price)
    - إمكانية إعادة الطلب / Re-order functionality
    - تتبع الشحنة مباشرة / Direct shipment tracking
--}}

@section('content')
<main class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 px-6 md:px-10 py-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto">

        {{-- Breadcrumb with enhanced styling --}}
        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">
                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Home
            </a>
            <span class="text-gray-300 dark:text-gray-600">/</span>
            <span class="text-gray-800 dark:text-gray-200 font-medium">My Orders</span>
        </div>

        {{-- Header Section with Stats --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black tracking-tight bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent mb-2">
                        {{ __('messages.my_orders') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        You have placed <span class="font-bold text-primary">{{ $orders->total() }}</span> orders in total
                    </p>
                </div>

                {{-- Quick Actions --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('shop.index') }}"
                       class="h-12 px-6 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold inline-flex items-center gap-2 shadow-lg shadow-primary-500/30 transition-all hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Start Shopping
                    </a>
                </div>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('order.index') }}" class="mt-6">
                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search by order number..."
                        class="w-full h-14 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white pl-14 pr-4 font-medium"
                    />
                    <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </div>
            </form>
        </div>

        {{-- Status Tabs with Modern Design --}}
        @php
            $active = request('status','all');
            $tabs = [
                'all' => ['label' => 'All Orders', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                'pending' => ['label' => 'Pending', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                'progress' => ['label' => 'In Progress', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                'completed' => ['label' => 'Completed', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                'cancelled' => ['label' => 'Cancelled', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-2 mb-6">
            <div class="flex items-center gap-2 overflow-x-auto">
                @foreach($tabs as $key => $tab)
                    <a href="{{ route('order.index', array_filter(['status'=>$key, 'q'=>request('q')])) }}"
                       class="flex-1 min-w-fit px-6 py-3 rounded-xl font-bold text-sm transition-all {{ $active===$key ? 'bg-gradient-to-r from-primary-600 to-primary-700 text-white shadow-lg shadow-primary-500/30' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                            </svg>
                            {{ $tab['label'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Orders Grid/List --}}
        <div class="space-y-4">
            @forelse($orders as $order)
                @php
                    $method = match($order->payment_method) {
                        'cod' => 'Cash on Delivery',
                        'stripe' => 'Credit Card',
                        'paypal' => 'PayPal',
                        default => $order->payment_method
                    };

                    // Status badge configuration
                    $statusConfig = match($order->status ?? 'pending') {
                        'completed' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-700 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-800'],
                        'pending' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'text' => 'text-yellow-700 dark:text-yellow-400', 'border' => 'border-yellow-200 dark:border-yellow-800'],
                        'progress' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800'],
                        'cancelled' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'text' => 'text-red-700 dark:text-red-400', 'border' => 'border-red-200 dark:border-red-800'],
                        default => ['bg' => 'bg-gray-50 dark:bg-gray-900/20', 'text' => 'text-gray-700 dark:text-gray-400', 'border' => 'border-gray-200 dark:border-gray-800']
                    };
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-2xl transition-all hover:scale-[1.01]">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            {{-- Order Info --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                                        {{ $order->order_number ?? '#ORD-' . $order->id }}
                                    </h3>
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold border-2 {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                        <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $order->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $method }}
                                    </div>
                                    <div class="flex items-center gap-2 font-black text-primary">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        ${{ number_format($order->total_price ?? $order->total, 2) }}
                                    </div>
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div>
                                <a href="{{ route('orders.show', $order) }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:scale-105 active:scale-95">
                                    View Details
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No Orders Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="{{ route('shop.index') }}"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Browse Products
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif

        {{-- Help Section --}}
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-2xl p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-black text-gray-900 dark:text-white mb-1">Need Help with an Order?</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Our support team is available 24/7 for your assistance.</div>
                    </div>
                </div>

                <a href="{{ url('/contact') }}"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 font-bold text-gray-900 dark:text-white hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>

    </div>
</main>
@endsection
