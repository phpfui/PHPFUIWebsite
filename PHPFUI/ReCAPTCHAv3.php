<?php

namespace PHPFUI;

/**
 * Implements Googles ReCaptcha V3 (but not currently working)
 *
 * There is no UI element created for this and it can not be
 * added to a page.
 *
 * Warning: This is a work in progress and not currently working.
 */
class ReCAPTCHAv3
	{
	private $errors = null;

	private $publicKey;
	private $result = 0.0;
	private $threshold = 0.5;

	/**
	 * @param Page $page since we need to add JS
	 * @param string $publicKey your public key
	 * @param string $secretKey your private key
	 */
	public function __construct(Page $page, string $publicKey, string $secretKey, callable $callback)
		{
		// do nothing if keys are not set
		if (empty($publicKey) && empty($secretKey))
			{
			return;
			}
		$callbackKey = 'Google-{__CLASS__}-Response';
		$this->publicKey = $publicKey;
		$page->addHeadScript('https://www.google.com/recaptcha/api.js?render=' . $this->publicKey);
		// action is the page name
		$action = $page->getBaseURL();
		$jsCallback = <<<JAVASCRIPT
alert(token);
$.ajax({type:'POST',dataType:'html',data:token,
success:function(response){
  var data;
  try{
    data=JSON.parse(response);
    alert(response);
  } catch(e){
    alert('Error: '+response);
  }
		}
		});
JAVASCRIPT;

		$js = "grecaptcha.ready(function(){grecaptcha.execute('{$secretKey}',{action:'{$action}'}).then(function(token){ {$jsCallback} });});";
		$page->addJavaScript($js);

		if (! empty($_POST[$callbackKey]))
			{
			$recaptcha = new \ReCaptcha\ReCaptcha($secretKey);
			$resp = $recaptcha->verify($_POST[$callbackKey], $_SERVER['REMOTE_ADDR']);
			$callable($resp);

			if ($resp->isSuccess())
				{
				$this->isValid = true;
				}
			else
				{
				$this->errors = $resp->getErrorCodes();
				}
			}
		}

	/**
	 * Returns any errors from Google
	 */
	public function getErrors() : array
		{
		return $this->errors;
		}

	/**
	 * Returns true if OK to proceed
	 */
	public function isValid() : bool
		{
		return $this->result >= $this->threshold;
		}

	/**
	 * Set a threshold that user needs to pass.  Default 0.5
	 */
	public function setThreshold(float $threshold = 0.5) : ReCAPTCHAv3
		{
		$this->threshold = $threshold;

		return $this;
		}
	}
