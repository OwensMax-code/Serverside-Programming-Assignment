<?php
class I18n
{
	public static function isValid($locale)
	{
		$validLang = array('bn');
		$isValid = false;
		if (in_array($locale, $validLang))
		{
			$isValid = true;
		}
		return $isValid;
	}
	
	public static function checkText($newText)
	{
		$language = null;
		if (self::isValid(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0]))
		{
			$language = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0];
		}
		
		$translationFile = "../i18n/".$language."/main.txt";
		if(!file_exists($translationFile))
		{
			return $newText;
		}
		
		$fileContent = file_get_contents($translationFile);
		$translation = json_decode($fileContent, true);
		
		if(!isset($translation[$newText]))
		{
			return $newText;
		}
		
		return $translation[$newText];
		
	}
}
?>