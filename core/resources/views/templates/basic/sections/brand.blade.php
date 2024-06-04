@php
    $brandContent = getContent('brand.content', true);
    $brandElements = getContent('brand.element', orderById: true);
@endphp

<div class="client-section wow fadeInUp pt-80" id="brand" data-wow-duration="600ms">
    <div class="container-fluid">
        <h5 class="title"> {{ @$brandContent->data_values->heading }} </h5>
        <div class="client-logos client-slider">
            @foreach ($brandElements as $brandElement)
                <img src="{{ getImage('assets/images/frontend/brand/' . @$brandElement->data_values->image, '150x40') }}" alt="">
            @endforeach
        </div>
    </div>
</div>