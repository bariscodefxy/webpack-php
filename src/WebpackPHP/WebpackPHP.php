<?php

/**
 * Copyright 2023 bariscodefx
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and 
 * associated documentation files (the “Software”), to deal in the Software without restriction, including 
 * without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished 
 * to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be 
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT 
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace bariscodefx\WebpackPHP;

/**
 * Webpack Main Class
 */
class WebpackPHP {

    /**
     * Asset Directory
     *
     * @var string
     */
    public string $assets_dir;

    /**
     * __construct
     *
     * @param string $assets_dir
     */
    public function __construct($assets_dir = "assets/"){
        $this->assets_dir = $assets_dir;
        if(!str_ends_with($this->assets_dir, "/"))
            $this->assets_dir .= "/";
    }

    /**
     * asset
     *
     * @param string $file_regex
     * @param string $asset_type
     * @param string $assets_dir
     * @return string|null
     */
    public function asset($file_regex = "", $asset_type = "script", $assets_dir = ""): ?string
    {
        if ( !$file_regex )
        {
            throw new \Exception("WebpackPHP::asset(): you should write the first parameter. (\$file_regex)");
        }

        if ( !$assets_dir )
        {
            $assets_dir = $this->assets_dir;
        }

        if ( !is_dir($assets_dir) )
        {
            throw new \Exception("WebpackPHP::asset(): $assets_dir is not an asset directory.");
        }

        $ignored = ['.', '..'];
        
        $files = array();
        foreach(scandir($assets_dir, SCANDIR_SORT_DESCENDING) as $file)
        {
            if(in_array($file, $ignored)) continue;
            $files[$file] = filemtime($assets_dir . $file);
        }
        
        arsort($files);
        $files = array_keys($files);

        foreach($files as $file)
        {
            if( preg_match( sprintf("/^%s$/", $file_regex), $file ) ) 
            {
                $asset = $file;
                break;
            }
        }

        if ( !$asset )
        {
            throw new \Exception("Asset file not found: " . $file_regex);
        }

        if ( $asset_type == "style" )
            return "<link rel=\"stylesheet\" href=\"" . $assets_dir . $asset . "\">";
        else if ($asset_type == "script")
            return "<script type=\"text/javascript\" src=\"" . $assets_dir . $asset . "\">";
        else
            throw new \Exception("WebpackPHP::asset(): unknown asset type");
    }

}