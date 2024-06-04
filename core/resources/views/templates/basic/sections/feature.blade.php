@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', orderById: true);
@endphp

<section class="feature-section ptb-100" id="feature">
    <div class="container custom-container">
        <h2 class="section-title wow fadeInUp" data-wow-duration="600ms"> {{ __(@$content->data_values->heading) }} </h2>
        <div class="row">
            <div class="col-12 p-fix-scroll">
                @foreach ($elements as $key => $item)
                    <div class="feature-wrapper section-style wow fadeInUp {{ $key == 0 ? 'demo' : null }}" data-wow-duration="600ms">
                        <div class="feature_thumb">
                            <img src="{{ getImage('assets/images/frontend/feature/' . @$item->data_values->image, '150x40') }}" alt="Image">
                        </div>
                        <div class="feature-content">
                            <h2 class="feature-content__title"> {{ __(@$item->data_values->title) }} </h2>
                            @php echo @$item->data_values->features @endphp
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>