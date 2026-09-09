<div id="scroll-progress" class="scroll-progress" role="progressbar" aria-label="Page reading progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>

<button type="button" class="search-launch" data-search-open aria-label="Search this page" title="Search this page (Ctrl K)">
    Search
</button>

<div id="site-search" class="search-modal" hidden>
    <div class="search-backdrop" data-search-close></div>
    <section class="search-panel" role="dialog" aria-modal="true" aria-labelledby="search-title">
        <div class="search-heading">
            <div>
                <p class="eyebrow">Workspace search</p>
                <h2 id="search-title">Find something on this page</h2>
            </div>
            <button type="button" class="icon-button" data-search-close aria-label="Close search">&times;</button>
        </div>
        <div class="search-field-wrap">
            <label class="sr-only" for="site-search-input">Search this page</label>
            <input id="site-search-input" type="search" autocomplete="off" placeholder="Search tasks, settings, people...">
            <button type="button" class="search-clear icon-button" data-search-clear aria-label="Clear search" hidden>&times;</button>
        </div>
        <div id="search-results" class="search-results" aria-live="polite"></div>
    </section>
</div>

<div id="site-toast" class="site-toast" role="status" aria-live="polite" hidden></div>

<div id="cookie-banner" class="cookie-banner" role="region" aria-label="Privacy choices" aria-describedby="cookie-banner-text" hidden>
    <div class="cookie-banner-text">
        <p id="cookie-banner-text" class="text-base font-semibold leading-snug">A little privacy housekeeping</p>
        <p class="mt-1 text-sm leading-relaxed">Essential storage keeps your session and preferences. Analytics, if enabled, load only after you accept. <a href="{{ route('cookie-policy') }}" class="font-semibold underline underline-offset-2">Read the cookie policy</a>.</p>
    </div>
    <div class="cookie-actions" role="group" aria-label="Cookie choice">
        <button type="button" class="cookie-button cookie-button-muted" data-cookie-choice="decline">Decline non-essential</button>
        <button type="button" class="cookie-button cookie-button-muted" data-cookie-choice="accept">Accept analytics</button>
    </div>
</div>

@if (config('app.seo.analytics_id'))
    <script>
        window.analyticsMeasurementId = @json(config('app.seo.analytics_id'));
    </script>
@endif

<button type="button" id="back-to-top" class="back-to-top icon-button" aria-label="Back to top" title="Back to top" hidden>
    &uarr;
</button>

<a href="mailto:{{ config('app.seo.contact_email') }}" class="contact-button" aria-label="Contact support" title="Contact support">
    <span aria-hidden="true">?</span>
    <span class="sr-only">Contact support</span>
</a>

<dialog id="site-confirmation" class="confirmation-dialog" aria-labelledby="confirmation-title">
    <div class="confirmation-dialog-inner">
        <div class="search-heading">
            <h2 id="confirmation-title">Please confirm</h2>
            <button type="button" class="icon-button" data-dialog-close aria-label="Close dialog">&times;</button>
        </div>
        <p data-dialog-message class="mt-3 text-sm text-slate-600 dark:text-slate-300"></p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" class="cookie-button cookie-button-muted" data-dialog-close>Cancel</button>
            <button type="button" class="cookie-button cookie-button-primary" data-dialog-confirm>Continue</button>
        </div>
    </div>
</dialog>
