function wpTooltip_updateTooltipProps(e) {
	const element = e.target;
	const tooltip = document.querySelector('.wp-tooltip');

	if (!element || !tooltip) {
		return;
	}

	const prop = element.id;
	let value = false;

	if (element.type === 'checkbox') {
		value = element.checked;
	}

	if (element.type === 'number') {
		value = parseInt(element.value);
	}

	if (element.type === 'select-one') {
		value = element.value;
	}

	const tippyInstance = tooltip._tippy;
	tippyInstance.setProps({ [prop]: value });
}

document.addEventListener('DOMContentLoaded', () => {
	const settings = wpTooltip_getDefaultSettings();
	const ids = Object.keys(settings);

	ids.forEach((id) => {
		const element = document.querySelector(`#${ id }`);

		if (!element) {
			return;
		}

		const event = element.type === 'number' ? 'input' : 'change';
		element.addEventListener(event, wpTooltip_updateTooltipProps);
	});
});
