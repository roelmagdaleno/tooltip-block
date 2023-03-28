import {toggleFormat, useAnchor} from "@wordpress/rich-text";
import { Popover } from "@wordpress/components";
import { tooltip as settings } from './index';
import { PostPicker } from "./post-picker";

export default function InlinePostSearch( {
   contentRef,
   value,
   activeAttributes,
   onChange,
}) {
	const linkValue = {
		url: activeAttributes.url,
		type: activeAttributes.type,
		id: activeAttributes.id,
	};

	const popoverAnchor = useAnchor( {
		editableContentElement: contentRef.current,
		value,
		settings,
	} );

	return (
		<Popover
			anchor={ popoverAnchor }
			placement="bottom"
			shift
		>
			<PostPicker
				onSelectPost={ onChange( toggleFormat( value, {
					type: 'roelmagdaleno/tooltip',
					attributes: {
						'data-meme': 'roel'
					}
				} ) ) }
				label={ "Please select a Post or Page:" }
				postTypes={ [ 'tooltip' ] }
			/>
		</Popover>
	);
}
