import {
	ClassicEditor,
	AccessibilityHelp,
	Autoformat,
	AutoImage,
	AutoLink,
	Autosave,
	Bold,
	CKBox,
	CKBoxImageEdit,
	CloudServices,
	Code,
	CodeBlock,
	Essentials,
	GeneralHtmlSupport,
	Heading,
	HtmlComment,
	HtmlEmbed,
	ImageBlock,
	ImageCaption,
	ImageInline,
	ImageInsert,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	ImageUpload,
	Italic,
	Link,
	LinkImage,
	List,
    MediaEmbed,
	ListProperties,
	Paragraph,
	PasteFromOffice,
	PictureEditing,
	SelectAll,
	ShowBlocks,
	SourceEditing,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	TextTransformation,
	Undo
} from 'ckeditor5';
import { PasteFromOfficeEnhanced } from 'ckeditor5-premium-features';

import translations from 'ckeditor5/translations/ja.js';
import premiumFeaturesTranslations from 'ckeditor5-premium-features/translations/ja.js';

/**
 * Please update the following values with your actual tokens.
 * Instructions on how to obtain them: https://ckeditor.com/docs/trial/latest/guides/real-time/quick-start.html
 */
const LICENSE_KEY = 'T0ZsRFhOMWJUZG5mRldIaksxcW1XaDVYSkxrMEJBQzEzbHhKT0ZER1k0aTVsZno1TmVtYVNmOGxsMDVrZVE9PS1NakF5TkRBNE1qYz0=';
const CKBOX_TOKEN_URL = 'https://114734.cke-cs.com/token/dev/4snf8NHowxPWVRffyucxPhsSuUaqhqu0Hrgz?limit=10';

const editorConfig = {
	toolbar: {
		items: [
			'undo',
			'redo',
			'|',
			'sourceEditing',
			'showBlocks',
			'selectAll',
			'|',
			'heading',
			'|',
			'bold',
			'italic',
			'code',
			'|',
			'link',
			'insertImage',
			'ckbox',
			'insertTable',
            'mediaEmbed',
			'codeBlock',
			'htmlEmbed',
			'|',
			'bulletedList',
			'numberedList',
			'|',
			'accessibilityHelp'
		],
		shouldNotGroupWhenFull: false
	},
	plugins: [
		AccessibilityHelp,
		Autoformat,
		AutoImage,
		AutoLink,
		Autosave,
		Bold,
		CKBox,
		CKBoxImageEdit,
		CloudServices,
		Code,
		CodeBlock,
		Essentials,
		GeneralHtmlSupport,
		Heading,
		HtmlComment,
		HtmlEmbed,
		ImageBlock,
		ImageCaption,
		ImageInline,
		ImageInsert,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		ImageUpload,
		Italic,
		Link,
		LinkImage,
		List,
        MediaEmbed,
		ListProperties,
		Paragraph,
		PasteFromOffice,
		PasteFromOfficeEnhanced,
		PictureEditing,
		SelectAll,
		ShowBlocks,
		SourceEditing,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar,
		TextTransformation,
		Undo
	],
	ckbox: {
		tokenUrl: CKBOX_TOKEN_URL
	},
	heading: {
		options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'headline_comment',
                view: { name: 'div', classes: 'fuki' },
                title: '見出しコメント',
            },
            {
                model: 'headline_text',
                view: { name: 'h4', classes: 'customers_detail_section_ttl' },
                title: '見出しテキスト',
            },
		]
	},
    mediaEmbed: {
        previewsInData: true
    },
	htmlSupport: {
		allow: [
			{
				name: /^.*$/,
				styles: true,
				attributes: true,
				classes: true
			}
		]
	},
	image: {
		toolbar: [
			'toggleImageCaption',
			'imageTextAlternative',
			'|',
			'imageStyle:inline',
			'imageStyle:wrapText',
			'imageStyle:breakText',
			'|',
			'resizeImage',
			'|',
			'ckboxImageEdit'
		]
	},
	// initialData:'',
	language: 'ja',
	licenseKey: LICENSE_KEY,
	link: {
		addTargetToExternalLinks: true,
		defaultProtocol: 'https://',
		decorators: {
			toggleDownloadable: {
				mode: 'manual',
				label: 'Downloadable',
				attributes: {
					download: 'file'
				}
			}
		}
	},
	list: {
		properties: {
			styles: true,
			startIndex: true,
			reversed: true
		}
	},
	// placeholder: '記事情報を入力してください!',
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	},
	translations: [translations, premiumFeaturesTranslations]
};


ClassicEditor.create(document.querySelector('#editor'), editorConfig);

