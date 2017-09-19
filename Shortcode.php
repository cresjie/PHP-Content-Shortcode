<?php

class ShortCodes
{

	public function execute($str)
	{
		preg_match_all("/\[(.*?)\]/", $str, $shortCodeTags);

		for($i = 0; $i < count($shortCodeTags[0]); $i++) {
			
			preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $shortCodeTags[0][$i], $tagname );
			
			$codeName = $tagname[1][0];

			if( method_exists($this, $codeName) ) {

				preg_match_all('/([^,= ]+)(="([^,= ]+)")?/', $shortCodeTags[1][$i], $optionsAndValue);

				$attrs = array_combine($optionsAndValue[1], $optionsAndValue[3]);

				$str = call_user_func_array([$this, $codeName], [$str, $shortCodeTags[0][$i], $attrs]);

			}

			
		}

		return $str;
		
	}
}
