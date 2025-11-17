@extends('admin.layouts.app')

@section('title', 'البوثات')
@section('page-title', 'إدارة بوثات المعرض')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">قائمة البوثات</h5>
        <a href="{{ route('admin.exhibition-booths.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة بوث جديد
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.exhibition-booths.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>فلترة حسب المؤتمر</label>
                        <select name="conference_id" class="form-control" onchange="this.form.submit()">
                            <option value="">جميع المؤتمرات</option>
                            @foreach(\App\Models\Conference::orderBy('title_ar')->get() as $conf)
                                <option value="{{ $conf->id }}" {{ request('conference_id') == $conf->id ? 'selected' : '' }}>
                                    {{ $conf->title_ar }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>فلترة حسب النوع</label>
                        <select name="type" class="form-control" onchange="this.form.submit()">
                            <option value="">جميع الأنواع</option>
                            <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>عادي</option>
                            <option value="premium" {{ request('type') == 'premium' ? 'selected' : '' }}>مميز</option>
                            <option value="strategic" {{ request('type') == 'strategic' ? 'selected' : '' }}>استراتيجي</option>
                            <option value="main" {{ request('type') == 'main' ? 'selected' : '' }}>رئيسي</option>
                            <option value="gold" {{ request('type') == 'gold' ? 'selected' : '' }}>ذهبي</option>
                            <option value="silver" {{ request('type') == 'silver' ? 'selected' : '' }}>فضي</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>فلترة حسب الحالة</label>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">جميع الحالات</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متاح</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>محجوز</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>البحث بالاسم</label>
                        <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @if($booths->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>الأبعاد</th>
                        <th>المساحة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>المؤتمر</th>
                        <th>العارض</th>
                        <th>المشارك</th>
                        <th width="150">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booths as $index => $booth)
                    <tr>
                        <td>{{ $booths->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $booth->name }}</strong>
                            @if($booth->slug)
                                <br><small class="text-muted">{{ $booth->slug }}</small>
                            @endif
                        </td>
                        <td>
                            @if($booth->type == 'standard')
                                <span class="badge badge-secondary">عادي</span>
                            @elseif($booth->type == 'premium')
                                <span class="badge badge-primary">مميز</span>
                            @elseif($booth->type == 'strategic')
                                <span class="badge badge-info">استراتيجي</span>
                            @elseif($booth->type == 'main')
                                <span class="badge badge-dark">رئيسي</span>
                            @elseif($booth->type == 'gold')
                                <span class="badge badge-warning">ذهبي</span>
                            @else
                                <span class="badge" style="background-color: silver;">فضي</span>
                            @endif
                        </td>
                        <td>{{ $booth->formatted_dimensions }}</td>
                        <td>{{ $booth->formatted_area }}</td>
                        <td><strong>{{ number_format($booth->price, 2) }} {{ $booth->currency }}</strong></td>
                        <td>
                            @if($booth->status == 'available')
                                <span class="badge badge-success">متاح</span>
                            @else
                                <span class="badge badge-danger">محجوز</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $booth->conference->title_ar }}</span>
                        </td>
                        <td>
                            @if($booth->exhibitor)
                                <small>{{ $booth->exhibitor->name_ar }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($booth->participant)
                                <small>{{ $booth->participant->name }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.exhibition-booths.edit', $booth) }}" class="btn btn-sm btn-primary" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.exhibition-booths.duplicate', $booth) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد إنشاء نسخة من هذا البوث؟')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" title="نسخ البوث">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.exhibition-booths.destroy', $booth) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا البوث؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $booths->links() }}
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> لا يوجد بوثات حالياً. <a href="{{ route('admin.exhibition-booths.create') }}">إضافة بوث جديد</a>
        </div>
        @endif
    </div>
</div>
@endsection

