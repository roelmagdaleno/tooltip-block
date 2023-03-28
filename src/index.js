import { RichTextToolbarButton } from "@wordpress/block-editor";
import { commentContent } from "@wordpress/icons";
import { __ } from "@wordpress/i18n";
import { PostPicker } from "./post-picker";
import { Popover } from "@wordpress/components";
import {
	applyFormat,
	registerFormatType,
	toggleFormat, useAnchor,
} from "@wordpress/rich-text";

import './style.scss';
import './index.scss';

const TooltipButton = ( { isActive, onChange, value, contentRef } ) => {
	const popoverAnchor = useAnchor( {
		editableContentElement: contentRef.current,
		value,
		settings: tooltip,
	} );

	return (
		<>
			<RichTextToolbarButton
				icon={ commentContent }
				title={ __( 'Tooltip', 'tooltip-block' ) }
				onClick={ () => onChange( toggleFormat( value, {
					type: 'roelmagdaleno/tooltip',
					attributes: { 'data-tooltip-id': '0' }
				} ) ) }
				isActive={ isActive }
				role="menuitemcheckbox"
			/>
			{ isActive && (
				<Popover
					anchor={ popoverAnchor }
					placement="bottom"
					shift
				>
					<div className="wp-tooltip-editor-control">
						<PostPicker
							onSelectPost={ ( post ) => {
								onChange( applyFormat( value, {
									type: 'roelmagdaleno/tooltip',
									attributes: { 'data-tooltip-id': post.id.toString() }
								} ) );
							} }
							placeholder={ 'Search tooltip' }
							postTypes={ [ 'tooltip' ] }
						/>
					</div>
				</Popover>
			) }
		</>
	);
};

export const tooltip = {
	name: 'roelmagdaleno/tooltip',
	title: __( 'Tooltip', 'tooltip-block' ),
	tagName: 'span',
	className: 'wp-tooltip',
	edit: TooltipButton,
};

registerFormatType( 'roelmagdaleno/tooltip', tooltip );
