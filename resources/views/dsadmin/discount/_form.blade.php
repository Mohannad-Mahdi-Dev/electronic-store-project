@php
  $c = $coupon ?? null;
@endphp

<div class="mb-3">
  <label class="form-label">Code</label>
  <input name="code" class="form-control" value="{{ old('code', $c->code ?? '') }}" required>
  @error('code')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="row">
  <div class="col-md-3 mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-select" required>
      <option value="fixed" @selected(old('type', $c->type ?? '')==='fixed')>Fixed</option>
      <option value="percent" @selected(old('type', $c->type ?? '')==='percent')>Percent</option>
    </select>
    @error('type')<small class="text-danger">{{ $message }}</small>@enderror
  </div>

  <div class="col-md-3 mb-3">
    <label class="form-label">Value</label>
    <input name="value" type="number" step="0.01" lang="en" class="form-control"
           value="{{ old('value', $c->value ?? '') }}" required>
    @error('value')<small class="text-danger">{{ $message }}</small>@enderror
  </div>

  <div class="col-md-3 mb-3">
    <label class="form-label">Min Cart</label>
    <input name="cart_value" type="number" step="0.01" lang="en" class="form-control"
           value="{{ old('cart_value', $c->cart_value ?? '') }}">
    @error('cart_value')<small class="text-danger">{{ $message }}</small>@enderror
  </div>

  <div class="col-md-3 mb-3">
    <label class="form-label">Usage Limit</label>
    <input name="usage_limit" type="number" lang="en" class="form-control"
           value="{{ old('usage_limit', $c->usage_limit ?? '') }}">
    @error('usage_limit')<small class="text-danger">{{ $message }}</small>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Expiry Date</label>
    <input name="expiry_date" type="date" class="form-control"
           value="{{ old('expiry_date', (isset($c->expiry_date) ? (is_string($c->expiry_date) ? $c->expiry_date : $c->expiry_date->format('Y-m-d')) : '')) }}">
    @error('expiry_date')<small class="text-danger">{{ $message }}</small>@enderror
  </div>

  <div class="col-md-4 mb-3 d-flex align-items-end">
    <div class="form-check">
      <input type="hidden" name="is_active" value="0">
      <input class="form-check-input" type="checkbox" name="is_active" value="1"
             @checked(old('is_active', $c->is_active ?? true))>
      <label class="form-check-label">Active</label>
    </div>
  </div>
</div>

<button class="btn btn-primary" type="submit">Save</button>
<a class="btn btn-secondary" href="{{ route('admin.coupons.index') }}">Back</a>