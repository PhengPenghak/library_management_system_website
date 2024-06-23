<?php

namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\bootstrap4\Html;

class ImageUploadWidget extends InputWidget
{
	public $placeholder = 'Upload Image';
	public $imageUrl;

	public function init()
	{
		parent::init();
		if (!$this->imageUrl) {
			$this->imageUrl = Yii::getAlias("@web/img/upload_image.png");
		}
	}

	public function run()
	{
		$this->options['onchange'] = 'showPreview(event);';
		$this->options['accept'] = 'image/*';
		echo Html::beginTag('div', ['class' => 'form-image-upload']);
		echo Html::beginTag('div', ['class' => 'preview']);
		echo Html::img($this->imageUrl, ['id' => 'image-preview']);
		echo Html::endTag('div');
		echo Html::label($this->placeholder, strtolower($this->model->formName() . '-' . $this->attribute));
		echo Html::activeFileInput($this->model, $this->attribute, $this->options);
		echo Html::endTag('div');

		$defaultImageUrl = Yii::getAlias("@web/img/upload_image.png");
		$this->getView()->registerJs(<<<JS

			function showPreview(event) {
				var preview = document.getElementById("image-preview");
				if (event.target.files.length > 0) {
					var src = URL.createObjectURL(event.target.files[0]);
					preview.src = src;
					preview.style.display = "block";
				}else {
					preview.src = "$defaultImageUrl";
					// preview.style.display = "none";
				}
				
				preview.onload = function() {
					URL.revokeObjectURL(preview.src) // free memory
				}
			}
		JS, \yii\web\View::POS_END);

		$this->getView()->registerCss(<<<CSS
			.form-image-upload {
				width: 100%;
				padding: 20px;
				background: #fff;
				box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
				3px 3px 7px rgba(94, 104, 121, 0.377);
			}
			
			.form-image-upload img {
				width: 100%;
				/* display: none; */
				margin-bottom: 30px;
				object-fit: cover;
				height: 300px;
			}
			
			.form-image-upload input {
				display: none;
			}
			
			.form-image-upload label {
				display: block;
				width: 45%;
				height: 35px;
				margin-left: 25%;
				line-height: 30px;
				text-align: center;
				color: #363642;
				background-color: #f6f7f9;
				border-color: #ecedf1;
				font-size: 13px;
				font-family: "Open Sans", sans-serif;
				text-transform: Uppercase;
				font-weight: 600;
				border-radius: 5px;
				cursor: pointer;
			}
		CSS);
	}
}
