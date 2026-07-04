<?php

namespace App\View;

class SlideShow extends \PHPFUI\SlickSlider
	{

	private \PHPFUI\Input\Select $goToSlide;

	private string $selector = '';

	private string $goToSelector = '';

	private bool $allowDelete;

	public function __construct(private \PHPFUI\Interfaces\Page $page, private string $folder)
		{
		$this->allowDelete = isset($_GET['DeleteAllowed']);
		if (isset($_GET['download']))
			{
			$file = $_GET['download'];
			$path = PUBLIC_ROOT . $folder . '/' . $file;
			\header('Cache-Control: public');
			\header('Content-Description: File Transfer');
			\header('Content-Disposition: attachment; filename="' . $file . '"');
			\header('Content-Transfer-Encoding: binary');
			\header('Content-Length: ' . filesize($path));
			readfile($path);

			exit;
			}
		if ($this->allowDelete && isset($_POST['file']) && isset($_POST['index']))
			{
			@unlink(PUBLIC_ROOT . $folder . '/' . basename($_POST['file']));
			@unlink(PUBLIC_ROOT . $folder . '/small/' . basename($_POST['file']));
			$page->setRawResponse(\json_encode(['success' => $_POST['index']]));
			return;
			}

		parent::__construct($page);
		$this->goToSlide = new \PHPFUI\Input\Select('goto');
		$this->selector = '$("#' . $this->getId() . '")';
		$this->goToSelector = '$("#' . $this->goToSlide->getId() . '")';

		$page->addJavaScript($this->selector . '.on("beforeChange", function(event, slick, currentSlide, nextSlide){' . $this->goToSelector . '.val(nextSlide);})');

		$this->addSliderAttribute('slidesToScroll', 1);
		$this->addSliderAttribute('autoplay', true);
		$this->addSliderAttribute('autoplaySpeed', 2500);
		$this->addSliderAttribute('adaptiveHeight', true);
		$this->addSliderAttribute('lazyLoad', "'ondemand'");
		$this->addSliderAttribute('mobileFirst', true);
		$this->addSliderAttribute('swipeToSlide', true);
		$this->addSliderAttribute('arrows', false);
		$this->addSliderAttribute('centerMode', true);
		$this->addSliderAttribute('pauseOnFocus', false);
		$this->addSliderAttribute('speed', 0);

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(PUBLIC_ROOT . $folder . '/small', \RecursiveDirectoryIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		$counter = 0;
		foreach ($iterator as $item)
			{
			$file = $iterator->getSubPathName();
			$file = \str_replace('\\', '/', $file);
			$this->goToSlide->addOption($file, $counter, $counter == 0);

			if ($item->isFile())
				{
				$this->addImage($folder . '/small/' . $file);
				}
			++$counter;
			}
		}

	public function getStart() : string
		{
		$multiColumn = new \PHPFUI\MultiColumn();
		$arrowLeft = new \PHPFUI\FAIcon('fas', 'arrow-left', '#');
		$arrowLeft->setAttribute('onclick', $this->selector . '.slick("slickPrev");');
		$multiColumn->add('&nbsp; ' . $arrowLeft);

		$pause = new \PHPFUI\FAIcon('fas', 'pause', '#');
		$pause->setAttribute('onclick', $this->selector . '.slick("slickPause");');
		$multiColumn->add($pause);

		$play = new \PHPFUI\FAIcon('fas', 'play', '#');
		$play->setAttribute('onclick', $this->selector . '.slick("slickPlay");');
		$multiColumn->add($play);

		$download = new \PHPFUI\FAIcon('fas', 'file-download', '#');
		$url = $this->page->getBaseURL();
		$download->setAttribute('onclick', 'window.open("' . $url . '?download="+' . $this->goToSelector . '.find("option:selected").text(), "_blank");');
		$multiColumn->add($download);

		if ($this->allowDelete)
			{
			$delete = new \PHPFUI\FAIcon('fas', 'trash-alt', '#');
			$js = <<<JAVASCRIPT
var file={$this->goToSelector}.find("option:selected").text();var index={$this->goToSelector}.val();
$.post("{$_SERVER['REQUEST_URI']}",{file:file,index:index}).done(function(data){console.log(data);{$this->selector}.slick("slickNext");{$this->selector}.slick("slickRemove",data.index+1,false);});
JAVASCRIPT;
			$delete->setAttribute('onclick', $js);
			$multiColumn->add($delete);
			}

		$arrowRight = new \PHPFUI\FAIcon('fas', 'arrow-right', '#');
		$arrowRight->setAttribute('onclick', $this->selector . '.slick("slickNext");');
		$multiColumn->add($arrowRight);

		$this->goToSlide->setAttribute('onchange', $this->selector . '.slick("slickGoTo", this.value, true);');
		$multiColumn->add($this->goToSlide);

		return $multiColumn . parent::getStart();
		}

	}
