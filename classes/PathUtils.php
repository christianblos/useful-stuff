<?php

/**
 * Utilities for working with path strings.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class PathUtils
{

    /**
     * Remove "../" from path.
     *
     * @param string $path
     *
     * @return string
     */
    public function removeBackPaths($path)
    {
        $sep = '(\/|\\\\)';
        $regex = '/(^|' . $sep . ')(?(?=\.\.(' . $sep . '|$))|[^' . $sep . ']*)' . $sep . '\.\.(' . $sep . '|$)/U';
        while (preg_match($regex, $path)) {
            $path = preg_replace($regex, '$1', $path, 1);
        }
        return $path;
    }

    /**
     * Get parts of path as array.
     *
     * @param string $path
     *
     * @return array
     */
    public function getParts($path)
    {
        $sep = '(\/|\\\\)';
        $path = preg_replace('/' . $sep . '+$/', '', $path);
        return preg_split('/' . $sep . '+/', $path);
    }

    /**
     * Get relative path.
     *
     * @param string $fromPath
     * @param string $toPath
     * @param string $separator
     *
     * @return string
     */
    public function relative($fromPath, $toPath, $separator = DIRECTORY_SEPARATOR)
    {
        $from = $this->getParts($fromPath);
        $to = $this->getParts($toPath);

        $relative = [];
        $idx = 0;
        $stop = false;
        $countFrom = count($from);

        for ($i = 0; $i < $countFrom; $i++) {
            $f = $from[$i];
            $t = isset($to[$i]) ? $to[$i] : false;
            $idx = $i;
            if ($stop !== false) {
                $relative[] = '..';
            } else {
                if ($f == $t) {
                    continue;
                }
                $stop = $i;
                $relative[] = '..';
            }
        }

        $countTo = count($to);

        if ($stop !== false) {
            for ($i = $stop; $i < $countTo; $i++) {
                if ($to[$i]) {
                    $relative[] = $to[$i];
                }
            }
        } else {
            for ($i = $idx + 1; $i < $countTo; $i++) {
                if ($to[$i]) {
                    $relative[] = $to[$i];
                }
            }
        }

        return implode($separator, $relative);
    }
}
