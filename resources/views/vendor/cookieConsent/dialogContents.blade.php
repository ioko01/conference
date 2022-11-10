<div style="font-size: 20px;opacity: .8;"
    class="p-5 d-flex align-items-center justify-content-center position-fixed bottom-0 w-100 js-cookie-consent cookie-consent bg-dark text-white">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </span>&nbsp;

    <button onclick="location.reload();" style="background: #fff;"
        class="btn btn-white js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
