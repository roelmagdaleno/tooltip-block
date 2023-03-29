const elementsAsColorPickers = [
	'backgroundColor',
	'textColor',
];

const elementsWithPropsAsArray = [
	'delayShow',
	'delayHide',
	'durationShow',
	'durationHide',
	'offsetSkidding',
	'offsetDistance',
];

/**
 * Get the value of the prop as an array.
 *
 * @since 1.0.0
 *
 * @param {string} prop The prop.
 * @param {string} value The value of the prop.
 * @returns {object} The prop and the value as an array.
 */
function wpTooltip_getValueAsArrayForProp(prop, value) {
	if (!elementsWithPropsAsArray.includes(prop)) {
		return value;
	}

	const singleProps = {
		'delay': ['delayShow', 'delayHide'],
		'duration': ['durationShow', 'durationHide'],
		'offset': ['offsetSkidding', 'offsetDistance'],
	};

	const singleProp = Object.keys(singleProps).find(
		(singleProp) => prop.includes(singleProp)
	);

	const firstProp = document.querySelector(`#${ singleProps[singleProp][0] }`).value;
	const secondProp = document.querySelector(`#${ singleProps[singleProp][1] }`).value;

	return {
		prop: singleProp,
		value: [parseInt(firstProp), parseInt(secondProp)],
	};
}

/**
 * Update the tooltip props.
 *
 * If the current prop belongs to an array, then return the array
 * from `wpTooltip_getValueAsArrayForProp` function.
 *
 * @since 1.0.0
 *
 * @param e   {object}   The event object.
 */
function wpTooltip_updateTooltipProps(e) {
	const element = e.target;
	const tooltip = document.querySelector('.wp-tooltip');

	if (!element || !tooltip) {
		return;
	}

	const gettersValues = {
		'checkbox': (element) => element.checked,
		'number': (element) => parseInt(element.value),
		'select-one': (element) => element.value,
	};

	let prop = element.id;
	let value = gettersValues[element.type](element);
	const isPropArray = elementsWithPropsAsArray.includes(prop);

	if (isPropArray) {
		let valueAsArray = wpTooltip_getValueAsArrayForProp(prop, value);
		prop = valueAsArray.prop;
		value = valueAsArray.value;
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

		if (elementsAsColorPickers.includes(id)) {
			jQuery(element).wpColorPicker();
		}

		const event = element.type === 'number' ? 'input' : 'change';
		element.addEventListener(event, wpTooltip_updateTooltipProps);
	});
});
