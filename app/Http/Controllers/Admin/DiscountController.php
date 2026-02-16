<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $q = Coupon::query();

        if ($request->filled('code')) {
            $q->where('code', 'like', '%' . strtoupper(trim($request->code)) . '%');
        }
        if ($request->filled('type')) {
            $q->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $q->where('is_active', $request->status === 'active');
        }

        $coupons = $q->orderByDesc('id')->paginate(20)->withQueryString();
        return view('dsadmin.discount.index', compact('coupons'));
    }

    public function create()
    {
        return view('dsadmin.discount.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateCoupon($request);
        $data['code'] = strtoupper(trim($data['code']));
        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'تم إنشاء الكوبون');
    }

    public function edit(Coupon $coupon)
    {
        return view('dsadmin.discount.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $this->validateCoupon($request, $coupon->id);
        $data['code'] = strtoupper(trim($data['code']));
        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'تم تحديث الكوبون');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'تم حذف الكوبون');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'تم تغيير الحالة');
    }

    private function validateCoupon(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($ignoreId)],
            'type' => ['required', Rule::in(['fixed', 'percent'])],
            'value' => ['required', 'numeric', 'min:0.01', function ($attr, $val, $fail) use ($request) {
                if ($request->type === 'percent' && ($val <= 0 || $val > 100)) {
                    $fail('النسبة يجب أن تكون بين 1 و 100');
                }
            }],
            'cart_value'  => ['nullable', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
    }
}
