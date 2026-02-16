@extends('dsadmin.layouts.app')

@section('page_title', 'إعدادات النظام')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-lg border-0 rounded-lg mt-4">
                    <!-- رأس البطاقة -->
                    <div class="card-header bg-gradient-primary text-white p-4 d-flex justify-content-between align-items-center rounded-top">
                        <h4 class="m-0 font-weight-bold"><i class="fas fa-cogs mr-2"></i> إعدادات المتجر والفريق</h4>
                        <button type="submit" class="btn btn-light text-primary font-weight-bold shadow-sm">
                            <i class="fas fa-save mr-1"></i> حفظ الكل
                        </button>
                    </div>

                    <div class="card-body p-4">
                        <!-- رسائل التنبيه -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm border-left-success" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm border-left-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- نظام التبويبات -->
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active py-3" id="general-tab" data-toggle="pill" href="#general" role="tab">
                                        <i class="fas fa-store mr-2"></i> الإعدادات العامة
                                    </a>
                                    <a class="nav-link py-3" id="team-tab" data-toggle="pill" href="#team" role="tab">
                                        <i class="fas fa-users-cog mr-2"></i> هوية الفريق
                                    </a>
                                    <a class="nav-link py-3" id="contact-tab" data-toggle="pill" href="#contact" role="tab">
                                        <i class="fas fa-headset mr-2"></i> معلومات التواصل
                                    </a>
                                    <a class="nav-link py-3" id="social-tab" data-toggle="pill" href="#social" role="tab">
                                        <i class="fas fa-share-alt mr-2"></i> السوشيال ميديا
                                    </a>
                                    <a class="nav-link py-3" id="maintenance-tab" data-toggle="pill" href="#maintenance" role="tab">
                                        <i class="fas fa-tools mr-2"></i> وضع الصيانة
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    
                                    <!-- 1. تبويب عام -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <h5 class="text-primary mb-3 border-bottom pb-2">بيانات المتجر الأساسية</h5>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold">اسم المتجر / الموقع</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="site_name" value="{{ $setting->site_name ?? '' }}" placeholder="اسم المشروع">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold">العملة الافتراضية</label>
                                                <select class="form-control" name="currency">
                                                    <option value="SAR" {{ ($setting->currency ?? '') == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                                    <option value="USD" {{ ($setting->currency ?? '') == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                                    <option value="YER" {{ ($setting->currency ?? '') == 'YER' ? 'selected' : '' }}> ريال يمني (YER)</option>
                                                </select>
                                            </div>
                                            
                                            <!-- اللوجو -->
                                            <div class="col-md-6 form-group mt-3">
                                                <label class="font-weight-bold">شعار الموقع (Logo)</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo" id="logoUpload">
                                                    <label class="custom-file-label" for="logoUpload">اختر ملف...</label>
                                                </div>
                                                @if(isset($setting->logo))
                                                    <div class="mt-2 p-2 bg-light border rounded text-center">
                                                        <small class="d-block text-muted mb-1">الحالي:</small>
                                                        <img src="{{ asset($setting->logo) }}" alt="Logo" style="max-height: 60px;">
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Favicon -->
                                            <div class="col-md-6 form-group mt-3">
                                                <label class="font-weight-bold">أيقونة المتصفح (Favicon)</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="favicon" id="faviconUpload">
                                                    <label class="custom-file-label" for="faviconUpload">اختر ملف...</label>
                                                </div>
                                                @if(isset($setting->favicon))
                                                    <div class="mt-2 p-2 bg-light border rounded text-center">
                                                        <img src="{{ asset($setting->favicon) }}" alt="Favicon" style="max-height: 32px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. تبويب الفريق -->
                                    <div class="tab-pane fade" id="team" role="tabpanel">
                                        <h5 class="text-primary mb-3 border-bottom pb-2">إعدادات المطورين والحقوق</h5>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> هذه البيانات تظهر عادة في الـ Footer.
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">اسم الفريق المطور</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="team_name" value="{{ $setting->team_name ?? '' }}" placeholder="مثال: DevTeam One">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">نص حقوق الملكية (Copyright)</label>
                                            <input type="text" class="form-control" name="copyright_text" value="{{ $setting->copyright_text ?? '' }}">
                                            <small class="text-muted">مثال: جميع الحقوق محفوظة © 2026</small>
                                        </div>
                                    </div>

                                    <!-- 3. تبويب التواصل -->
                                    <div class="tab-pane fade" id="contact" role="tabpanel">
                                        <h5 class="text-primary mb-3 border-bottom pb-2">قنوات الاتصال والدعم</h5>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>البريد الإلكتروني الرسمي</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" class="form-control" name="contact_email" value="{{ $setting->contact_email ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>رقم الهاتف</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="contact_number" value="{{ $setting->contact_number ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>رقم الواتساب</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-success text-white"><i class="fab fa-whatsapp"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="whatsapp" value="{{ $setting->whatsapp ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>العنوان الفعلي</label>
                                                <textarea class="form-control" name="address" rows="2">{{ $setting->address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4. تبويب السوشيال -->
                                    <div class="tab-pane fade" id="social" role="tabpanel">
                                        <h5 class="text-primary mb-3 border-bottom pb-2">روابط التواصل الاجتماعي</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #3b5998; color: white; width: 45px; justify-content: center;"><i class="fab fa-facebook-f"></i></span>
                                                    </div>
                                                    <input type="url" class="form-control" name="facebook" placeholder="Facebook Link" value="{{ $setting->facebook ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #1DA1F2; color: white; width: 45px; justify-content: center;"><i class="fab fa-twitter"></i></span>
                                                    </div>
                                                    <input type="url" class="form-control" name="twitter" placeholder="Twitter / X Link" value="{{ $setting->twitter ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #E1306C; color: white; width: 45px; justify-content: center;"><i class="fab fa-instagram"></i></span>
                                                    </div>
                                                    <input type="url" class="form-control" name="instagram" placeholder="Instagram Link" value="{{ $setting->instagram ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #FF0000; color: white; width: 45px; justify-content: center;"><i class="fab fa-youtube"></i></span>
                                                    </div>
                                                    <input type="url" class="form-control" name="youtube" placeholder="Youtube Link" value="{{ $setting->youtube ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. تبويب الصيانة -->
                                    <div class="tab-pane fade" id="maintenance" role="tabpanel">
                                        <div class="card bg-warning text-dark border-0">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                                                    <h5 class="m-0 font-weight-bold">منطقة الخطر: وضع الصيانة</h5>
                                                </div>
                                                <p>عند تفعيل هذا الوضع، سيظهر للزوار صفحة مغلقة ولن يتمكنوا من الشراء.</p>
                                                
                                                <div class="custom-control custom-switch custom-switch-lg mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="maintenance_mode" name="maintenance_mode" {{ isset($setting->maintenance_mode) && $setting->maintenance_mode ? 'checked' : '' }}>
                                                    <label class="custom-control-label font-weight-bold" for="maintenance_mode">تفعيل وضع الصيانة</label>
                                                </div>
                                                
                                                <div class="form-group bg-white p-3 rounded text-dark">
                                                    <label>رسالة التنبيه للزوار</label>
                                                    <textarea class="form-control" name="maintenance_message" rows="3">{{ $setting->maintenance_message ?? 'الموقع يخضع حالياً لأعمال صيانة دورية، سنعود قريباً.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- End Tab Content -->
                            </div>
                        </div> <!-- End Row -->

                    </div> <!-- End Card Body -->
                    
                    <div class="card-footer bg-light text-right">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                            <i class="fas fa-save mr-2"></i> حفظ التغييرات
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<style>
    
    .nav-pills .nav-link {
        color: #5a5c69;
        font-weight: 500;
        border-radius: 0.5rem;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: #4e73df;
        color: #fff;
        box-shadow: 0 4px 6px rgba(78, 115, 223, 0.4);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: #eaecf4;
    }
    .input-group-text {
        border: none;
        background-color: #f8f9fc;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #4e73df;
    }
    .custom-switch-lg .custom-control-label::before {
        width: 3rem;
        height: 1.5rem;
        border-radius: 1rem;
    }
    .custom-switch-lg .custom-control-label::after {
        height: calc(1.5rem - 4px);
        width: calc(1.5rem - 4px);
        border-radius: 50%;
    }
    .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(1.5rem); /* تعديل الاتجاه حسب RTL/LTR */
    }
</style>
@endsection
