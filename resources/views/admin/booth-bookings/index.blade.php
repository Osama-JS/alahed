@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
@endphp

@section('title', $isArabic ? 'طلبات حجز البوثات' : 'Booth Booking Requests')
@section('page-title', $isArabic ? 'طلبات حجز البوثات' : 'Booth Booking Requests')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الطلبات' : 'Requests List' }}</h5>
    </div>
    <div class="card-body">
        @if($bookings->count())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'البوث' : 'Booth' }}</th>
                            <th>{{ $isArabic ? 'العميل' : 'Client' }}</th>
                            <th>{{ $isArabic ? 'الشركة' : 'Company' }}</th>
                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                            <th>{{ $isArabic ? 'تاريخ الطلب' : 'Requested At' }}</th>
                            <th class="text-center">{{ $isArabic ? 'تفاصيل' : 'Details' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                            <tr>
                                <td>{{ $bookings->firstItem() + $index }}</td>
                                <td>
                                    @if($booking->booth)
                                        <strong class="d-block">{{ $booking->booth->name }}</strong>
                                        @if(!is_null($booking->booth->price_before_vat))
                                            <small class="d-block text-muted">
                                                {{ $isArabic ? 'قبل الضريبة:' : 'Before VAT:' }}
                                                {{ number_format($booking->booth->price_before_vat, 2) }} {{ $booking->booth->currency }}
                                            </small>
                                        @endif
                                        <small class="d-block text-muted">
                                            {{ $isArabic ? 'السعر:' : 'Price:' }}
                                            {{ number_format($booking->booth->price, 2) }} {{ $booking->booth->currency }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $booking->name }}</div>
                                    <small class="text-muted">{{ $booking->email }}</small>
                                </td>
                                <td>{{ $booking->company ?? '-' }}</td>
                                <td>
                                    <span class="badge
                                        @if($booking->status === 'approved') bg-success
                                        @elseif($booking->status === 'rejected') bg-danger
                                        @else bg-secondary @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>{{ $booking->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.booth-bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                        {{ $isArabic ? 'عرض' : 'View' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $bookings->links() }}</div>
        @else
            <div class="alert alert-info mb-0">
                {{ $isArabic ? 'لا توجد طلبات حجز حالياً.' : 'No booking requests yet.' }}
            </div>
        @endif
    </div>
</div>
@endsection
