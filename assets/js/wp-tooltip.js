/* global wpTooltip, tippy */

/**
 * Get the default settings for the tooltips.
 *
 * @since 1.0.0
 *
 * @returns {object}   The default settings.
 */
function wpTooltip_getDefaultSettings() {
	const missingSettings = {
		backgroundColor: '',
		textColor: '',
		linkColor: '',
		linkHoverColor: '',
		delayShow: 0,
		delayHide: 0,
		durationShow: 0,
		durationHide: 0,
		offsetSkidding: 0,
		offsetDistance: 0,
	};

	return !wpTooltip ? { allowHTML: true } : {
		allowHTML: wpTooltip.allowHTML === '1',
		arrow: wpTooltip.arrow === '1',
		delay: [parseInt(wpTooltip.delayShow), parseInt(wpTooltip.delayHide)],
		duration: [parseInt(wpTooltip.durationShow), parseInt(wpTooltip.durationHide)],
		hideOnClick: wpTooltip.hideOnClick === '1',
		interactive: wpTooltip.interactive === '1',
		interactiveBorder: parseInt(wpTooltip.interactiveBorder),
		maxWidth: parseInt(wpTooltip.maxWidth),
		offset: [parseInt(wpTooltip.offsetSkidding), parseInt(wpTooltip.offsetDistance)],
		placement: wpTooltip.placement,
		trigger: wpTooltip.trigger,
		zIndex: parseInt(wpTooltip.zIndex),
		...missingSettings,
	};
}

document.addEventListener('DOMContentLoaded', () => {
	if (!tippy) {
		return;
	}

	const theme = wpTooltip.theme === 'custom' ? 'wp-tooltip' : wpTooltip.theme;

	const args = {
		theme,
		content(reference) {
			const id = reference.getAttribute('data-tooltip-id');
			const template = document.querySelector(`#wp-tooltip-${ id }`);

			return !template
				? `The tooltip with ID ${ id } does not exist.`
				: template.innerHTML;
		},
		...wpTooltip_getDefaultSettings()
	};

	tippy('.wp-tooltip', args);
});
