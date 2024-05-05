<li class="nav-main-item">
    <a href="{{ route('landingpage.index') }}" class="nav-main-link
        {{ (Request::route()->getName() == 'landingpage.index') || (Request::route()->getName() == 'custom_page.index')
        || (Request::route()->getName() == 'homesection.index') || (Request::route()->getName() == 'features.index')
        || (Request::route()->getName() == 'discover.index') || (Request::route()->getName() == 'screenshots.index')
        || (Request::route()->getName() == 'pricing_plan.index') || (Request::route()->getName() == 'faq.index')
        || (Request::route()->getName() == 'testimonials.index') || (Request::route()->getName() == 'join_us.index') ? ' active' : '' }}">
        <i class="nav-main-link-icon fa fa-globe"></i>
        <span class="nav-main-link-name">{{ __('Website Settings') }}</span>
    </a>
</li>

