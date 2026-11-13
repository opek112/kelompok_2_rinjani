<?php

namespace Modules\Onboarding\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class OnboardingServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Onboarding'; }
    protected function viewNamespace(): string { return 'Onboarding'; }
}
