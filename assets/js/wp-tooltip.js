document.addEventListener('DOMContentLoaded', () => {
	if (!tippy) {
		return;
	}

	tippy('.wp-tooltip', {
		content(reference) {
			const id = reference.getAttribute('data-tooltip-id');
			const template = document.querySelector(`#wp-tooltip-${ id }`);

			return !template
				? `The tooltip with ID ${ id } does not exist.`
				: template.innerHTML;
		},
		allowHTML: true,
	});
});
