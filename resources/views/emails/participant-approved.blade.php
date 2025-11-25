<x-mail::message>
# مرحباً {{ $participant->name }}

تمت الموافقة على طلب اشتراكك في **{{ app()->getLocale() == 'ar' ? $participant->conference->title_ar : $participant->conference->title_en }}**

## معلومات الاشتراك

- **النوع:** {{ $participant->type == 'visitor' ? 'زائر' : ($participant->type == 'exhibitor' ? 'عارض' : ($participant->type == 'speaker' ? 'متحدث' : 'راعي')) }}
@if($participant->conference->start_date && $participant->conference->end_date)
- **التاريخ:** {{ \Carbon\Carbon::parse($participant->conference->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($participant->conference->end_date)->format('d/m/Y') }}
@endif
@if($participant->conference->location_ar)
- **المكان:** {{ app()->getLocale() == 'ar' ? $participant->conference->location_ar : $participant->conference->location_en }}
@endif

## تحميل بطاقة الدخول

يمكنك الآن تحميل بطاقة الدخول الخاصة بك من خلال الضغط على الزر أدناه:

<x-mail::button :url="$downloadUrl" color="success">
تحميل البطاقة
</x-mail::button>

> **ملاحظة مهمة:** يمكنك استخدام نفس البطاقة للدخول في جميع أيام المؤتمر. سيتم تسجيل حضورك يومياً عند المسح.

نتطلع لرؤيتك في الفعالية!

شكراً لك،<br>
{{ config('app.name') }}
</x-mail::message>
