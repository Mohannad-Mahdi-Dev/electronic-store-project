@extends('front.layouts.app')

{{-- 
    صفحة الشكر بعد إتمام الطلب
    Thank You Page After Order Completion
    
    Features:
    - عرض تفاصيل الطلب / Display order details
    - عداد تنازلي لإعادة التوجيه التلقائي / Countdown timer for auto-redirect
    - إعادة توجيه تلقائية إلى صفحة الطلبات بعد 10 ثوانية / Auto-redirect to orders page after 10 seconds
    
    Future Enhancements:
    - إضافة زر لطباعة الفاتورة / Add print invoice button
    - عرض QR code للطلب / Display order QR code
    - تكامل مع خدمات التتبع / Integration with tracking services
    - إضافة خيار مشاركة الطلب / Add share order option
    - عرض منتجات مقترحة / Display recommended products
--}}

@section('content')
<main class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen py-12 px-4 transition-colors duration-300">
    <div class="max-w-3xl mx-auto">
        {{-- Success Header with Animation --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mb-6 shadow-2xl shadow-green-500/50 animate-bounce">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-3 bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Order Confirmed!</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Thank you for your purchase. We've received your order and we'll notify you once it's shipped.</p>
            
            {{-- Auto-redirect notification with countdown --}}
            <div id="redirect-notice" class="mt-6 inline-flex items-center gap-3 px-6 py-3 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-blue-800 dark:text-blue-200 font-medium">
                    Redirecting to your orders in <span id="countdown" class="font-black text-blue-600 dark:text-blue-400 text-xl">10</span> seconds...
                </span>
                <button onclick="cancelRedirect()" class="ml-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 underline font-bold">
                    Cancel
                </button>
            </div>
        </div>

        {{-- Order Details Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 transition-all hover:shadow-3xl">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 md:px-8 py-4">
                <h2 class="text-2xl font-black text-white flex items-center">
                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Order Details
                </h2>
            </div>
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:justify-between border-b pb-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Order Number</p>
                        <p class="text-lg font-bold text-primary">{{ $order->order_number }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Payment Method</p>
                        <p class="text-lg font-bold text-gray-900 uppercase">{{ $order->payment_method }}</p>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <h3 class="font-bold text-gray-800 mb-4">Items Summary</h3>
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-lg text-sm font-bold text-gray-600">
                                {{ $item->quantity }}x
                            </span>
                            <span class="font-medium text-gray-700">{{ $item->product_name }}</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ number_format($item->price * $item->quantity) }} ر.ي</span>
                    </div>
                    @endforeach
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>{{ number_format($order->subtotal) }} ر.ي</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-green-600 font-medium">
                        <span>Discount Applied</span>
                        <span>-{{ number_format($order->discount_amount) }} ر.ي</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping Fee</span>
                        <span>{{ number_format($order->shipping_fee) }} ر.ي</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-gray-200 text-xl font-black text-gray-900">
                        <span>Total Paid</span>
                        <span class="text-primary">{{ number_format($order->total) }} ر.ي</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4">
            <a href="{{ route('shop.index') }}" class="flex-1 bg-white border-2 border-gray-200 text-gray-800 text-center py-4 rounded-2xl font-bold hover:bg-gray-50 transition-all">
                Continue Shopping
            </a>
            <a href="{{ route('order.index') }}" class="flex-1 bg-primary text-white text-center py-4 rounded-2xl font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                Track My Order
            </a>
        </div>

        <p class="text-center mt-8 text-gray-500 dark:text-gray-400 text-sm">
            Have questions? Contact our support at <span class="text-primary font-bold">support@electronicstore.com</span>
        </p>
    </div>
</main>

{{-- 
    JavaScript للعداد التنازلي وإعادة التوجيه التلقائي
    JavaScript for countdown timer and auto-redirect functionality
    
    Features:
    - عداد تنازلي من 10 ثوانية / 10-second countdown
    - إعادة توجيه تلقائية إلى صفحة الطلبات / Auto-redirect to orders page
    - إمكانية إلغاء إعادة التوجيه / Cancel redirect option
    
    Future Enhancements:
    - حفظ تفضيل المستخدم في localStorage / Save user preference in localStorage
    - إضافة sound effect عند انتهاء العداد / Add sound effect on countdown end
    - تكامل مع Google Analytics لتتبع سلوك المستخدم / GA integration for user behavior tracking
--}}
<script>
    // متغير للتحكم في العداد التنازلي
    // Variable to control the countdown timer
    let countdown = 10; // 10 ثوانية
    let redirectTimer;
    let countdownInterval;

    /**
     * بدء العداد التنازلي وإعادة التوجيه
     * Start countdown and redirect
     */
    function startRedirectCountdown() {
        const countdownElement = document.getElementById('countdown');
        
        // تحديث العداد كل ثانية
        // Update countdown every second
        countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            // إضافة تأثير بصري عند الوصول إلى 3 ثوانية
            // Add visual effect when reaching 3 seconds
            if (countdown <= 3) {
                countdownElement.classList.add('text-red-600', 'dark:text-red-400');
                countdownElement.parentElement.parentElement.classList.add('border-red-300', 'dark:border-red-700', 'bg-red-50', 'dark:bg-red-900/20');
            }
            
            // عند الوصول إلى 0، إعادة التوجيه
            // When reaching 0, redirect
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ route('order.index') }}";
            }
        }, 1000);
    }

    /**
     * إلغاء إعادة التوجيه التلقائي
     * Cancel auto-redirect
     */
    function cancelRedirect() {
        clearInterval(countdownInterval);
        const notice = document.getElementById('redirect-notice');
        notice.innerHTML = `
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-green-800 dark:text-green-200 font-medium">Auto-redirect cancelled. You can stay on this page.</span>
        `;
        notice.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-200', 'dark:border-blue-800');
        notice.classList.add('bg-green-50', 'dark:bg-green-900/20', 'border-green-200', 'dark:border-green-800');
        
        // Future Enhancement: حفظ التفضيل في localStorage
        // localStorage.setItem('autoRedirectDisabled', 'true');
    }

    // بدء العداد عند تحميل الصفحة
    // Start countdown when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Future Enhancement: التحقق من تفضيلات المستخدم
        // const autoRedirectDisabled = localStorage.getItem('autoRedirectDisabled');
        // if (!autoRedirectDisabled) {
            startRedirectCountdown();
        // }
    });
</script>

{{-- 
    Styles للتحسينات البصرية
    Styles for visual enhancements
--}}
<style>
    /* تأثير الظل المحسن / Enhanced shadow effect */
    .shadow-3xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* تأثير النبض للعداد / Pulse effect for countdown */
    #countdown {
        animation: pulse 1s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
</style>
@endsection