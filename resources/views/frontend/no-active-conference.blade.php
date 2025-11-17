@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'لا يوجد مؤتمر نشط - العهد' : 'No Active Conference - Al-Ahd')

@section('content')

<section class="no-conference-section" style="margin-top: 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="no-conference-content">
                    <i class="fas fa-calendar-times i-big"></i>
                    <h1>{{ app()->getLocale() == 'ar' ? 'لا يوجد مؤتمر نشط حالياً' : 'No Active Conference' }}</h1>
                    <p>
                        {{ app()->getLocale() == 'ar' 
                            ? 'عذراً، لا يوجد مؤتمر نشط في الوقت الحالي. يرجى زيارة صفحة النسخ السابقة لمشاهدة المؤتمرات السابقة.' 
                            : 'Sorry, there is no active conference at the moment. Please visit the previous editions page to view past conferences.' 
                        }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('previous-editions') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-history text-sm"></i>
                            {{ app()->getLocale() == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .no-conference-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 0;
    }
    
    .no-conference-content {
        padding: 60px 40px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    }
    
    .no-conference-content .i-big {
        font-size: 100px;
        color: #ccc;
        margin-bottom: 30px;
    }
    
    .no-conference-content h1 {
        font-size: 32px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }
    
    .no-conference-content p {
        font-size: 18px;
        color: #666;
        line-height: 1.8;
        margin-bottom: 30px;
    }
</style>
@endpush

