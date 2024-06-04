@php
    $dashboardContent = getContent('dashboard.content', true);
@endphp

<section class="dashboard-one  wow fadeInUp">
    <div class="container custom-container">
        <div class="dashboard-thumb">
            <img src="{{ getImage('assets/images/frontend/dashboard/' . @$dashboardContent->data_values->image, '1340x860') }}" alt="dashboard screenshort">
        </div>
    </div>
</section>