<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Identity\Providers\IdentityServiceProvider::class,
    Modules\Onboarding\Providers\OnboardingServiceProvider::class,
    Modules\Admin\Providers\AdminServiceProvider::class,
    Modules\Guide\Providers\GuideServiceProvider::class,
    Modules\Rental\Providers\RentalServiceProvider::class,
    Modules\Booking\Providers\BookingServiceProvider::class,
    Modules\Payment\Providers\PaymentServiceProvider::class,
    Modules\Landing\Providers\LandingServiceProvider::class,
];
