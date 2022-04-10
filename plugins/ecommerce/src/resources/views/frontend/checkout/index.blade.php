<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="anyflexbox boxshadow display-table">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $shop_name }} - {{ trans('frontend.payment_order') }}" />
    <title>{{ $shop_name }} - {{ trans('frontend.payment_order') }}</title>
    <link rel="shortcut icon" href="{{ media_url(shop_setting('shop_icon')) }}" type="image/x-icon" />

    <link href="{{ asset('styles/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('styles/css/nprogress.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('styles/css/select2-min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('styles/css/checkout.css') }}" rel="stylesheet" type="text/css" />
    
    <script> var Juzaweb = Juzaweb || {}; Juzaweb.store = '{{ request()->getHost() }}'; Juzaweb.theme = {"id":606449,"role":"main","name":"{{ $shop_name }}"}; Juzaweb.template = ''; </script>

    <script type="text/javascript">if (typeof Juzaweb == 'undefined') { Juzaweb = {}; }
        Juzaweb.Checkout = {};
        Juzaweb.Checkout.token = "{{ $cart->token }}";
        Juzaweb.Checkout.apiHost = "{{ request()->getHost() }}";
    </script>
</head>
<body class="body--custom-background-color ">
<div class="banner" data-header="">
    <div class="wrap">
        <div class="shop logo logo--left ">

            <h1 class="shop__name">
                <a href="/">
                    {{ $shop_name }}
                </a>
            </h1>

        </div>
    </div>
</div>
<button class="order-summary-toggle" bind-event-click="Juzaweb.StoreCheckout.toggleOrderSummary(this)">
    <div class="wrap">
        <h2>
            <label class="control-label">{{ trans('frontend.order') }}</label>
            <label class="control-label hidden-small-device">
                ({{ $cart->item_count }} {{ trans('frontend.products') }})
            </label>
            <label class="control-label visible-small-device inline">
                ({{ $cart->item_count }})
            </label>
        </h2>
        <a class="underline-none expandable pull-right" href="javascript:void(0)">
            {{ trans('frontend.view_detail') }}
        </a>
    </div>
</button>

<div context="paymentStatus" define='{ paymentStatus: new Juzaweb.PaymentStatus(this,{payment_processing:"",payment_provider_id:"",payment_info:{} }) }'>

</div>
<form method="post" action="" data-toggle="validator" class="content stateful-form formCheckout">
    <div class="wrap" context="checkout" define='{checkout: new Juzaweb.StoreCheckout(this,{ token: "{{ $cart->token }}", email: "{{ $customer->email }}", totalOrderItemPrice: {{ deprice_format($cart->total_price) }}, shippingFee: 0, freeShipping: false, requiresShipping: {{ $requires_shipping ? 'true' : 'false' }}, existCode: false, code: "", discount: 0, settingLanguage: "vi", moneyFormat: "₫", discountLabel: "{{ trans('frontend.free') }}", districtPolicy: "optional", wardPolicy: "hidden", district: "", ward: "", province:"", otherAddress: false, shippingId: 0, shippingMethods: {!! json_encode($shipping_methods) !!}, customerAddressId: 0, reductionCode: "" })}'>
        <div class='sidebar '>
            <div class="sidebar_header">
                <h2>
                    <label class="control-label">{{ trans('frontend.order') }} ({{ $cart->item_count }} {{ trans('frontend.products') }})</label>
                </h2>
                <hr class="full_width"/>
            </div>
            <div class="sidebar__content">
                <div class="order-summary order-summary--product-list order-summary--is-collapsed">
                    <div class="summary-body summary-section summary-product" >
                        <div class="summary-product-list">
                            <table class="product-table">
                                <tbody>
                            @php
                            $items = $cart->items;
                            @endphp

                            @foreach($items as $item)
                                <tr class="product product-has-image clearfix">
                                    <td>
                                        <div class="product-thumbnail">
                                            <div class="product-thumbnail__wrapper">
                                                <img src="{{ media_url($item->image) }}" class="product-thumbnail__image" />
                                            </div>
                                            <span class="product-thumbnail__quantity" aria-hidden="true">{{ $item->quantity }}</span>
                                        </div>
                                    </td>
                                    <td class="product-info">
                                        <span class="product-info-name">
                                            {{ $item->name }}
                                        </span>
                                    </td>

                                    <td class="product-price text-right">
                                        {{ $item->line_price }}
                                    </td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                            <div class="order-summary__scroll-indicator">
                                {{ trans('frontend.scroll_mouse_to_view_more') }}
                                <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <hr class="m0"/>
                </div>
                <div class="order-summary order-summary--discount">
                    <div class="summary-section">
                        <div class="form-group m0" bind-show="!existCode || !applyWithPromotion || code == null || !code.length">
                            <div class="field__input-btn-wrapper">
                                <div class="field__input-wrapper">
                                    <input bind="code" name="code" type="text" class="form-control discount_code" placeholder="{{ trans('frontend.enter_discount_code') }}" value="" id="checkout_reduction_code"/>
                                </div>
                                <button bind-event-click="reduction_code = false, caculateShippingFee('')" class="btn btn-primary event-voucher-apply" type="button">{{ trans('frontend.apply') }}</button>
                            </div>
                        </div>
                        <div bind-class="{'warning' : existCode && !freeShipping && discount == 0,'success' : existCode && ( freeShipping || discount >0 )}" class="clearfix hide" bind-show="code!= null && code.length && existCode && applyWithPromotion">
                            <div class="pull-left">
                                <i class="fa fa-check applied-discount-status-success" aria-hidden="true"></i>
                                <i class="fa fa-exclamation-triangle applied-discount-status-warning" aria-hidden="true"></i>
                            </div>
                            <div bind="code" class="pull-left applied-discount-code">

                            </div>
                            <div bind="(discountShipping && freeShipping) ? '{{ trans('frontend.free') }}' : discount" class="pull-right">
                                0
                            </div>
                            <input bind-event-click="removeCode('')" class="btn btn-delete" type="button" value="×" name="commit">
                        </div>
                        <div class="error mt10 hide" bind-show="inValidCode">
                            {{ trans('frontend.discount_code_is_not_valid') }}
                        </div>
                        <div class="error mt10 hide" bind-show="!applyWithPromotion && existCode">
                            {{--Mã khuyến mãi không được áp dụng chung với chương trình khuyến mãi--}}
                        </div>
                    </div>
                    <hr class="m0"/>
                </div>
                <div class="order-summary order-summary--total-lines">
                    <div class="summary-section border-top-none--mobile">
                        <div class="total-line total-line-subtotal clearfix">
                            <span class="total-line-name pull-left">
                                {{ trans('frontend.total_price') }}
                            </span>

                            <span bind="totalOrderItemPrice" class="total-line-subprice pull-right">
                                {{ price_format($cart->total_line_item_price) }}
                            </span>
                        </div>

                        <div class="total-line total-line-shipping clearfix" bind-show="requiresShipping">
                            <span class="total-line-name pull-left">
                                {{ trans('frontend.shipping_fee') }}
                            </span>
                            <span bind="shippingFee !=  0 ? shippingFee : ((requiresShipping && shippingMethods.length == 0) ? 'This area does not support transportation': '{{ trans('frontend.free') }}')" class="total-line-shipping pull-right" >
                                {{ trans('frontend.free') }}
                            </span>
                        </div>

                        <div class="total-line total-line-total clearfix">
                            <span class="total-line-name pull-left">
                                {{ trans('frontend.total') }}
                            </span>
                            <span bind="totalPrice" class="total-line-price pull-right">
                                {{ price_format($cart->total_price) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix hidden-sm hidden-xs">
                    <div class="field__input-btn-wrapper mt10">
                        <a class="previous-link" href="/cart">
                            <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
                            <span>{{ trans('frontend.back_to_cart') }}</span>
                        </a>
                        <input class="btn btn-primary btn-checkout" data-loading-text="{{ trans('frontend.please_wait') }}" type="button" bind-event-click="paymentCheckout('AIzaSyAjQYbV19v7UMDVk0cDZ54yKh3OP1hQhbk;AIzaSyCLd-YkfOzBXlNGfS_FNLnpolyME1tRAJI;AIzaSyDdvilzaJlb50t2IRC3PrfSb1lNzf6n3pQ')" value="{{ \Illuminate\Support\Str::upper(trans('frontend.order2')) }}" />
                    </div>
                </div>
                <div class="form-group has-error">
                    <div class="help-block ">
                        <ul class="list-unstyled">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main" role="main">
            <div class="main_header">
                <div class="shop logo logo--left ">

                    <h1 class="shop__name">
                        <a href="/">
                            {{ $shop_name }}
                        </a>
                    </h1>

                </div>
            </div>
            <div class="main_content">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="section" define="{billing_address: {}}">
                            <div class="section__header">
                                <div class="layout-flex layout-flex--wrap">
                                    <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                        <i class="fa fa-id-card-o fa-lg section__title--icon hidden-md hidden-lg" aria-hidden="true"></i>
                                        <label class="control-label">{{ trans('frontend.information') }}</label>
                                    </h2>
                                @if(!Auth::guard('customer')->check())
                                    <a class="layout-flex__item section__title--link" href="/account/login?returnUrl=/checkout">
                                        <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>
                                        {{ trans('frontend.login') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                            <div class="section__content">
                                <div class="form-group" bind-class="{'has-error' : invalidEmail}">
                                    <div>
                                        <label class="field__input-wrapper" bind-class="{ 'js-is-filled': email }">
                                            <span class="field__label" bind-event-click="handleClick(this)">
                                                {{ trans('frontend.email') }}
                                            </span>
                                            <input name="Email" type="email" bind-event-change="changeEmail()" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_email" data-error="{{ trans('frontend.email_is_malformed') }}" required value="" pattern="^([a-zA-Z0-9_\-\.\+]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" bind="email" />
                                        </label>
                                    </div>
                                    <div class="help-block with-errors">
                                    </div>
                                </div>

                                <div class="billing">
                                    <div>
                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': billing_address.full_name }">
                                                    <span class="field__label" bind-event-click="handleClick(this)">
                                                        {{ trans('frontend.full_name') }}
                                                    </span>
                                                <input name="BillingAddress_LastName" type="text" bind-event-change="saveAbandoned()" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_billing_address_last_name" data-error="{{ trans('frontend.please_enter_full_name') }}" required bind="billing_address.full_name" autocomplete="off" value="{{ $customer->name }}"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': billing_address.phone }">
                                                <span class="field__label" bind-event-click="handleClick(this)">
                                                    {{ trans('frontend.phone') }}
                                                </span>
                                                <input name="BillingAddress_Phone" bind-event-change="saveAbandoned()" type="tel" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_billing_address_phone" data-error="{{ trans('frontend.please_enter_full_phone') }}" pattern="^([0-9,\+,\-,\(,\),\.]{8,20})$" bind="billing_address.phone" value="{{ $customer->phone }}"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        @if($order_address)
                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': billing_address.address1 }">
                                            <span class="field__label" bind-event-click="handleClick(this)">
                                                {{ trans('frontend.address') }}
                                            </span>
                                                <input name="BillingAddress_Address1" bind-event-change="saveAbandoned()" type="text" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_billing_address_address1"  bind="billing_address.address1"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        @endif

                                        @if($order_country)
                                        <div class="form-group">
                                            <div class="field__input-wrapper field__input-wrapper--select">
                                                <label class="field__label" for="BillingCountryId">
                                                    {{ trans('frontend.country') }}
                                                </label>
                                                <select class="field__input field__input--select form-control filter-dropdown" name="BillingCountryId" id="billingCountry" required data-error="{{ trans('frontend.please_choose', ['name' => trans('frontend.country')]) }}" bind-event-change="billingCountryChange('')" bind="BillingCountryId">
                                                    <option value=''>--- {{ trans('frontend.choose_country') }} ---</option>
                                                    @foreach($countrys as $country)
                                                        <option value='{{ $country->code }}' @if($selected_country == $country->code) selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        @endif

                                        @if($order_address)
                                        <div class="form-group">
                                            <div class="field__input-wrapper field__input-wrapper--select">
                                                <label class="field__label" for="BillingProvinceId">
                                                    {{ trans('frontend.provinces') }}
                                                </label>
                                                <select class="field__input field__input--select form-control filter-dropdown" name="BillingProvinceId" id="billingProvince" required data-error="{{ trans('frontend.please_choose', ['name' => trans('frontend.province')]) }}" bind-event-change="billingDistrictChange('')" bind="BillingProvinceId">
                                                    <option value=''>--- {{ trans('frontend.choose_province') }} ---</option>
                                                    @foreach($provinces as $province)
                                                        <option value='{{ $province->id }}'>{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div bind-show="!otherAddress" class="form-group">
                                            <div class="error hide" bind-show="requiresShipping && loadedShippingMethods && shippingMethods.length == 0  && BillingProvinceId  ">
                                                <label>{{ trans('frontend.area_not_support_shipping') }}</label>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section pt10">
                            <div class="section__content">
                                <div class="form-group" bind-show="requiresShipping">
                                    <div class="checkbox-wrapper">
                                        <div class="checkbox__input">
                                            <input class="input-checkbox" type="checkbox" value="false" name="otherAddress" id="other_address" bind="otherAddress" bind-event-change="changeOtherAddress(this)">
                                        </div>
                                        <label class="checkbox__label" for="other_address">
                                            {{ trans('frontend.shipping_to_other_address') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section pt10" bind-show="otherAddress">
                            <div class="section__header">
                                <h2 class="section__title">
                                    <i class="fa fa-id-card-o fa-lg section__title--icon hidden-md hidden-lg" aria-hidden="true"></i>
                                    <label class="control-label">
                                        {{ trans('frontend.shipping_information') }}
                                    </label>
                                </h2>
                            </div>
                            <div class="section__content">
                                <div bind-show="otherAddress" define="{shipping_address: {}, shipping_expand:true,show_district: false,show_ward:  false ,show_country:  true }" class="shipping  hide ">
                                    <div bind-show="shipping_expand || !otherAddress">
                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': shipping_address.full_name }">
                                                <span class="field__label" bind-event-click="handleClick(this)">
                                                    {{ trans('frontend.full_name') }}
                                                </span>
                                                <input name="ShippingAddress_LastName" bind-event-change="saveAbandoned()" type="text" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_shipping_address_last_name" data-error="{{ trans('frontend.please_enter_full_name') }}" bind="shipping_address.full_name" />
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': shipping_address.phone }">
                                                <span class="field__label" bind-event-click="handleClick(this)">
                                                    {{ trans('frontend.phone') }}
                                                </span>
                                                <input name="ShippingAddress_Phone" bind-event-change="saveAbandoned()" type="tel" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_shipping_address_phone"  data-error="{{ trans('frontend.please_enter_phone') }}" pattern="^([0-9,\+,\-,\(,\),\.]{8,20})$" bind="shipping_address.phone"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="field__input-wrapper" bind-class="{ 'js-is-filled': shipping_address.address1 }">
                                                <span class="field__label" bind-event-click="handleClick(this)">
                                                    {{ trans('frontend.address') }}
                                                </span>
                                                <input name="ShippingAddress_Address1" bind-event-change="saveAbandoned()" type="text" bind-event-focus="handleFocus(this)" bind-event-blur="handleFieldBlur(this)" class="field__input form-control" id="_shipping_address_address1"  bind="shipping_address.address1" />
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        @if($countrys !== false)
                                        <div class="form-group">
                                            <div class="field__input-wrapper field__input-wrapper--select">
                                                <label class="field__label" for="ShippingCountryId">
                                                    {{ trans('frontend.country') }}
                                                </label>
                                                <select class="field__input field__input--select form-control filter-dropdown" name="ShippingCountryId" id="shippingCountry"  bind-event-change="shippingCountryChange('')" bind="ShippingCountryId">
                                                    <option value="">--- {{ trans('frontend.choose_country') }} ---</option>
                                                    @foreach($countrys as $country)
                                                        <option value='{{ $country->code }}' @if($selected_country == $country->code) selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="field__input-wrapper field__input-wrapper--select">
                                                <label class="field__label" for="BillingProvinceId">
                                                    {{ trans('frontend.province') }}
                                                </label>
                                                <select class="field__input field__input--select form-control filter-dropdown" name="ShippingProvinceId" id="shippingProvince" data-error="{{ trans('frontend.please_choose', ['name' => trans('frontend.province')]) }}" bind-event-change="shippingProviceChange('')" bind="ShippingProvinceId">
                                                    <option value=''>--- {{ trans('frontend.choose_province') }} ---</option>
                                                    @foreach($provinces as $province)
                                                        <option value='{{ $province->id }}'>{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="error hide" bind-show="requiresShipping && shippingMethods.length == 0 && ShippingProvinceId ">
                                                <label>{{ trans('frontend.area_not_support_shipping') }}</label>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section" bind-class="{ 'pt0': otherAddress, 'pt10': !otherAddress}">
                            <div class="section__content">
                                <div class="form-group m0">
                                    <div>
                                        <label class="field__input-wrapper" bind-class="{'js-is-filled': note}" style="border: none">
												<span class="field__label" bind-event-click="handleClick(this)" >
													{{ trans('frontend.note') }}
												</span>
                                            <textarea name="note"
                                                      bind-event-change="saveAbandoned()"
                                                      bind-event-focus="handleFocus(this)"
                                                      bind-event-blur="handleFieldBlur(this)"
                                                      bind="note"
                                                      class="field__input form-control m0"></textarea>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="section shipping-method hide" bind-show="shippingMethodsLoading || shippingMethods.length > 0">
                            <div class="section__header">
                                <h2 class="section__title">
                                    <i class="fa fa-truck fa-lg section__title--icon hidden-md hidden-lg" aria-hidden="true"></i>
                                    <label class="control-label">{{ trans('frontend.shipping') }}</label>
                                </h2>
                            </div>
                            <div class="section__content">
                                <div class="wait-loading-shipping-methods hide" bind-show="shippingMethodsLoading" style="margin-bottom:10px">
                                    <div class="next-spinner">
                                        <svg class="icon-svg icon-svg--color-accent icon-svg--size-32 icon-svg--spinner">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-spinner"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="content-box" bind-show="!shippingMethodsLoading && shippingMethods.length > 0">

                                </div>
                            </div>
                        </div>

                        <div class="section payment-methods" bind-class="{'p0--desktop': shippingMethods.length == 0}">
                            <div class="section__header">
                                <h2 class="section__title">
                                    <i class="fa fa-credit-card fa-lg section__title--icon hidden-md hidden-lg" aria-hidden="true"></i>
                                    <label class="control-label">{{ trans('frontend.payment') }}</label>
                                </h2>
                            </div>
                            <div class="section__content">
                            @foreach($payment_methods as $index => $payment_method)
                                <div class="content-box">

                                    <div class="content-box__row">
                                        <div class="radio-wrapper">
                                            <div class="radio__input">
                                                <input class="input-radio" type="radio" value="{{ $payment_method->id }}" name="PaymentMethodId" id="payment_method_{{ $payment_method->id }}" data-check-id="4" bind="payment_method_id" @if($index == 0) checked @endif>
                                            </div>
                                            <label class="radio__label" for="payment_method_{{ $payment_method->id }}">
                                                <span class="radio__label__primary">{{ $payment_method->name }}</span>
                                                <span class="radio__label__accessory">
                                                <ul>
                                                    <li class="payment-icon-v2 payment-icon--4">
                                                        <i class="fa fa-money payment-icon-fa" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="radio-wrapper content-box__row content-box__row--secondary hide" id="payment-gateway-subfields-{{ $payment_method->id }}" bind-show="payment_method_id == {{ $payment_method->id }}">
                                        <div class="blank-slate">
                                            <p>{{ $payment_method->description }}</p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            </div>
                        </div>
                        <div class="section hidden-md hidden-lg">
                            <div class="form-group clearfix m0">
                                <input class="btn btn-primary btn-checkout" data-loading-text="Đang xử lý" type="button" bind-event-click="paymentCheckout('AIzaSyAjQYbV19v7UMDVk0cDZ54yKh3OP1hQhbk;AIzaSyCLd-YkfOzBXlNGfS_FNLnpolyME1tRAJI;AIzaSyDdvilzaJlb50t2IRC3PrfSb1lNzf6n3pQ')" value="{{ \Illuminate\Support\Str::upper(trans('frontend.order')) }}" />
                            </div>
                            <div class="text-center mt20">
                                <a class="previous-link" href="/cart">
                                    <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
                                    <span>{{ trans('frontend.back_to_cart') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main_footer footer unprint">
                <div class="mt10"></div>
            </div>

            <div class="modal fade" id="refund-policy" data-width="" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">{{ trans('frontend.refund_policy') }}</h4>
                        </div>
                        <div class="modal-body">
                            <pre></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="privacy-policy" data-width="" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">{{ trans('frontend.privacy_policy') }}</h4>
                        </div>
                        <div class="modal-body">
                            <pre></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="terms-of-service" data-width="" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">{{ trans('frontend.terms_of_service') }}</h4>
                        </div>
                        <div class="modal-body">
                            <pre></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="icon-symbols" style="display: none;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol id="spinner-large"><svg xmlns="http://www.w3.org/2000/svg" viewBox="-270 364 66 66"><path d="M-237 428c-17.1 0-31-13.9-31-31s13.9-31 31-31v-2c-18.2 0-33 14.8-33 33s14.8 33 33 33 33-14.8 33-33h-2c0 17.1-13.9 31-31 31z"/></svg></symbol><symbol id="chevron-right"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><path d="M2 1l1-1 4 4 1 1-1 1-4 4-1-1 4-4" /></svg></symbol><symbol id="success"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 24C5.373 24 0 18.627 0 12S5.373 0 12 0s12 5.373 12 12-5.373 12-12 12zm0-2c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm3.784-13.198c.386-.396 1.02-.404 1.414-.018.396.386.404 1.02.018 1.414l-5.85 6c-.392.403-1.04.403-1.432 0l-3.15-3.23c-.386-.396-.378-1.03.018-1.415.395-.385 1.028-.377 1.414.018l2.434 2.5 5.134-5.267z"/></svg></symbol><symbol id="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M16 8.1l-8.1 8.1-1.1-1.1L13 8.9H0V7.3h13L6.8 1.1 7.9 0 16 8.1z" /></svg></symbol><symbol id="spinner-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M20 10c0 5.523-4.477 10-10 10S0 15.523 0 10 4.477 0 10 0v2c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8h2z"/></svg></symbol>
        <symbol id="next-spinner"><svg preserveAspectRatio="xMinYMin"><circle class="next-spinner__ring" cx="50%" cy="50%" r="45%"></circle></svg></symbol>
    </svg>
</div>
<script>var code_langs = {'choose_province': '{{ trans('frontend.choose_province') }}'};</script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
@include('jscsrf_token')
<script src="{{ asset('styles/js/load-ajax.js') }}"></script>
<script src="{{ asset('styles/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/twine.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/validator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/nprogress.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/money-helper.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/select2-full-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('styles/js/ua-parser.pack.js') }}" type='text/javascript'></script>
<script src="{{ asset('styles/js/checkout.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ajaxStart(function () {
        NProgress.start();
    });
    $(document).ajaxComplete(function () {
        NProgress.done();
    });

    context = {};

    $(function () {
        Twine.reset(context).bind().refresh();
    });

    $(document).ready(function () {
        var $select2 = $('.filter-dropdown').select2({
            containerCssClass: 'field__input',
            dropdownCssClass: 'field__input',
            dropdownParent: $('.main_content'),
            language: {
                noResults: function () { return "{{ trans('frontend.no_results') }}" },
                searching: function () { return "{{ trans('frontend.searching') }}…" }
            }
        });

        setTimeout(function() {
            Twine.context(document.body).checkout.calculateFeeAndSave('');
        }, 50);

    });
</script>

</body>
</html>