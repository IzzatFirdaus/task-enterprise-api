// Alpine.js is managed by Livewire v4 — do not import it here.

const escapeHtml = (value) => value.replace(/[&<>'"]/g, (character) => ({
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	"'": '&#039;',
	'"': '&quot;',
}[character]));

const showToast = (message) => {
	const toast = document.querySelector('#site-toast');
	if (!toast) return;
	toast.textContent = message;
	toast.hidden = false;
	window.setTimeout(() => { toast.hidden = true; }, 2400);
};

const syncThemeButtons = () => {
	const isDark = document.documentElement.classList.contains('dark');
	document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
		button.textContent = isDark ? 'Light' : 'Dark';
		button.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');
	});
};

const initEnhancements = () => {
	const search = document.querySelector('#site-search');
	const searchInput = document.querySelector('#site-search-input');
	const results = document.querySelector('#search-results');
	let lastFocus = null;

	const closeSearch = () => {
		if (!search) return;
		search.hidden = true;
		lastFocus?.focus();
	};

	const renderSearch = () => {
		if (!results || !searchInput) return;
		const term = searchInput.value.trim();
		document.querySelector('[data-search-clear]')?.toggleAttribute('hidden', !term);
		if (!term) {
			results.innerHTML = '<p class="text-sm text-slate-500">Type to search the current page.</p>';
			return;
		}
		const query = term.toLowerCase();
		const matches = [...document.querySelectorAll('main h1, main h2, main h3, main p, main td, main li, main label, main a')]
			.filter((element) => element.textContent.toLowerCase().includes(query))
			.slice(0, 12);
		results.innerHTML = matches.length ? matches.map((element) => {
			const text = element.textContent.trim().replace(/\s+/g, ' ');
			const safe = escapeHtml(text);
			const highlighted = safe.replace(new RegExp(`(${escapeHtml(term).replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'ig'), '<mark>$1</mark>');
			return `<div class="search-result">${highlighted}</div>`;
		}).join('') : '<p class="text-sm text-slate-500">No matches found on this page.</p>';
	};

	document.addEventListener('click', (event) => {
		const themeToggle = event.target.closest('[data-theme-toggle]');
		if (themeToggle) {
			document.documentElement.classList.toggle('dark');
			localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
			syncThemeButtons();
		}
		const trigger = event.target.closest('[data-search-open]');
		if (trigger && search) {
			lastFocus = trigger;
			search.hidden = false;
			searchInput?.focus();
			renderSearch();
		}
		if (event.target.closest('[data-search-close]')) closeSearch();
		if (event.target.closest('[data-search-clear]') && searchInput) {
			searchInput.value = '';
			renderSearch();
			searchInput.focus();
		}
		const copyButton = event.target.closest('[data-copy]');
		if (copyButton) {
			navigator.clipboard?.writeText(copyButton.dataset.copy || copyButton.previousElementSibling?.textContent || '')
				.then(() => showToast('Copied to clipboard.'))
				.catch(() => showToast('Copy was unavailable.'));
		}
		const cookieChoice = event.target.closest('[data-cookie-choice]');
		if (cookieChoice) {
			localStorage.setItem('cookieChoice', cookieChoice.dataset.cookieChoice);
			document.querySelector('#cookie-banner')?.setAttribute('hidden', '');
		}
		const dialogClose = event.target.closest('[data-dialog-close]');
		if (dialogClose) document.querySelector('#site-confirmation')?.close();
		const dialog = document.querySelector('#site-confirmation');
		if (dialog && event.target === dialog) dialog.close();
		const confirmTrigger = event.target.closest('[data-confirm]');
		if (confirmTrigger) {
			event.preventDefault();
			const dialog = document.querySelector('#site-confirmation');
			const confirmButton = dialog?.querySelector('[data-dialog-confirm]');
			if (!dialog || !confirmButton) return;
			dialog.querySelector('[data-dialog-message]').textContent = confirmTrigger.dataset.confirm;
			confirmButton.onclick = () => {
				dialog.close();
				if (confirmTrigger.form) confirmTrigger.form.submit();
				else if (confirmTrigger.href) window.location.assign(confirmTrigger.href);
			};
			dialog.showModal();
		}
	});

	searchInput?.addEventListener('input', renderSearch);
	document.addEventListener('keydown', (event) => {
		if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
			event.preventDefault();
			const trigger = document.querySelector('[data-search-open]');
			trigger?.click();
		}
		if (event.key === 'Escape' && search && !search.hidden) closeSearch();
	});

	if (!localStorage.getItem('cookieChoice')) {
		window.setTimeout(() => { document.querySelector('#cookie-banner')?.removeAttribute('hidden'); }, 700);
	}

	document.querySelectorAll('input[type="password"]').forEach((input) => {
		if (input.parentElement?.classList.contains('password-field')) return;
		const wrapper = document.createElement('div');
		wrapper.className = 'password-field';
		input.parentNode.insertBefore(wrapper, input);
		wrapper.appendChild(input);
		const toggle = document.createElement('button');
		toggle.type = 'button';
		toggle.className = 'password-toggle';
		toggle.textContent = 'Show';
		toggle.setAttribute('aria-label', 'Show password');
		toggle.addEventListener('click', () => {
			const visible = input.type === 'text';
			input.type = visible ? 'password' : 'text';
			toggle.textContent = visible ? 'Show' : 'Hide';
			toggle.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
		});
		wrapper.appendChild(toggle);
	});

	document.querySelectorAll('pre').forEach((block) => {
		if (block.nextElementSibling?.matches('[data-copy]')) return;
		const button = document.createElement('button');
		button.type = 'button';
		button.className = 'cookie-button cookie-button-primary';
		button.dataset.copy = block.textContent;
		button.textContent = 'Copy';
		block.insertAdjacentElement('afterend', button);
	});

	document.querySelectorAll('main h1').forEach((heading) => {
		if (heading.nextElementSibling?.matches('[data-last-updated]')) return;
		const updated = document.createElement('time');
		updated.className = 'last-updated';
		updated.dataset.lastUpdated = '';
		updated.dateTime = new Date().toISOString();
		updated.textContent = `Last updated ${new Intl.DateTimeFormat(undefined, { dateStyle: 'medium' }).format(new Date())}`;
		heading.insertAdjacentElement('afterend', updated);
	});

	const queryParams = new URLSearchParams(window.location.search);
	['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'].forEach((key) => {
		const value = queryParams.get(key);
		if (value) sessionStorage.setItem(key, value);
		const storedValue = sessionStorage.getItem(key);
		document.querySelectorAll(`[name="${key}"], [data-utm-field="${key}"]`).forEach((field) => {
			if (storedValue) field.value = storedValue;
		});
		document.querySelectorAll('form').forEach((form) => {
			if (!storedValue || form.elements.namedItem(key)) return;
			const field = document.createElement('input');
			field.type = 'hidden';
			field.name = key;
			field.value = storedValue;
			field.dataset.utmField = key;
			form.appendChild(field);
		});
	});

	document.querySelectorAll('[data-focus-trap]').forEach((drawer) => {
		drawer.addEventListener('keydown', (event) => {
			if (event.key !== 'Tab' || drawer.offsetParent === null) return;
			const focusable = [...drawer.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])')];
			if (!focusable.length) return;
			const first = focusable[0];
			const last = focusable[focusable.length - 1];
			if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
			else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
		});
		new MutationObserver(() => {
			const isOpen = drawer.offsetParent !== null;
			document.body.classList.toggle('drawer-open', isOpen);
			if (isOpen && !drawer.contains(document.activeElement)) {
				drawer.querySelector('button, a, input, select, textarea')?.focus();
			}
		}).observe(drawer, { attributes: true, attributeFilter: ['style', 'class'] });
	});

	document.querySelectorAll('form[data-success-form]').forEach((form) => {
		form.addEventListener('submit', (event) => {
			event.preventDefault();
			form.hidden = true;
			const success = document.createElement('div');
			success.className = 'rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800';
			success.setAttribute('role', 'status');
			success.textContent = form.dataset.successMessage || 'Thanks. Your response was received.';
			form.insertAdjacentElement('afterend', success);
		});
	});

	let ticking = false;
	let previousScrollY = window.scrollY;
	const updateScrollUi = () => {
		const max = document.documentElement.scrollHeight - window.innerHeight;
		const progress = max > 0 ? Math.min(100, (window.scrollY / max) * 100) : 0;
		const bar = document.querySelector('#scroll-progress');
		if (bar) { bar.style.width = `${progress}%`; bar.setAttribute('aria-valuenow', String(Math.round(progress))); }
		document.querySelector('#back-to-top')?.toggleAttribute('hidden', window.scrollY <= 300);
		document.querySelectorAll('header').forEach((header) => {
			header.dataset.autoHideHeader = 'true';
			if (window.scrollY > 120 && window.scrollY > previousScrollY + 4) header.style.transform = 'translateY(-100%)';
			else header.style.transform = 'translateY(0)';
		});
		previousScrollY = window.scrollY;
		ticking = false;
	};
	window.addEventListener('scroll', () => {
		if (!ticking) { window.requestAnimationFrame(updateScrollUi); ticking = true; }
	}, { passive: true });
	document.querySelector('#back-to-top')?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
	updateScrollUi();
	syncThemeButtons();
};

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initEnhancements);
else initEnhancements();
