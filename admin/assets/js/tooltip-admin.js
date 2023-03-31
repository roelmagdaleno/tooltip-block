/* global wpTooltip */

const elementsAsColorPickers = {
	'backgroundColor': '#333333',
	'textColor': '#ffffff',
	'linkColor': '#58b4ff',
	'linkHoverColor': '#58b4ff',
};

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

/**
 * Generate the custom CSS.
 *
 * @since 1.0.0
 *
 * @param {object} newColors The new colors.
 */
function wpTooltip_generate_custom_css(newColors) {
	const styleEl = document.querySelector('#tooltip-block-inline-css');

	if (!styleEl) {
		return;
	}

	let customCSS = wpTooltip.customCSS;

	Object.keys(elementsAsColorPickers).forEach((id) => {
		const currentColor = newColors[id] ? newColors[id] : document.querySelector(`#${ id }`).value;
		customCSS = customCSS.replaceAll(`{{${ id }}}`, currentColor);
	});

	styleEl.innerHTML = customCSS;
}

/**
 * Render the color picker for the given element.
 *
 * @since 1.0.0
 *
 * @param {object} element The element.
 * @param {string} defaultColor The default color.
 */
function wpTooltip_renderColorPicker(element, defaultColor) {
	const options = {
		defaultColor,
		change: (event, ui) => wpTooltip_generate_custom_css({ [element.id]: ui.color.toCSS('hex') }),
	};

	jQuery(element).wpColorPicker(options);
}

document.addEventListener('DOMContentLoaded', () => {
	const settings = wpTooltip_getDefaultSettings();
	const ids = Object.keys(settings);

	ids.forEach((id) => {
		const element = document.querySelector(`#${ id }`);

		if (!element) {
			return;
		}

		if (Object.keys(elementsAsColorPickers).includes(id)) {
			wpTooltip_renderColorPicker(element, elementsAsColorPickers[id]);
		}

		const event = element.type === 'number' ? 'input' : 'change';
		element.addEventListener(event, wpTooltip_updateTooltipProps);
	});

	const saveChangesButton = document.querySelector('#wp-tooltip__save-changes');
	saveChangesButton.addEventListener('click', () => document.forms[0].requestSubmit());
});
