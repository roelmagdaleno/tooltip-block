/* global wpTooltip */

function wpTooltip_getDefaultSettings() {
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
	};
}

document.addEventListener('DOMContentLoaded', () => {
	if (!tippy) {
		return;
	}

	const args = {
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
