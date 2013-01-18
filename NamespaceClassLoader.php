<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  terminal42 gmbh 2012
 * @author     Andreas Schempp <andreas.schempp@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class NamespaceClassLoader
{

    private static $loader;

    /**
     * Return the PSR-0 ClassLoader instance
     */
    public static function getClassLoader()
    {
        if (static::$loader === null) {

            require_once(TL_ROOT . '/system/modules/!Autoload/library/Composer/Autoload/ClassLoader.php');

            static::$loader = new \Composer\Autoload\ClassLoader();
            static::$loader->register();
        }

        return static::$loader;
    }

    /**
     * Registers a set of classes
     *
     * @param string       $prefix  The classes prefix
     * @param array|string $paths   The location(s) of the classes
     */
    public static function add($prefix, $paths)
    {
        static::getClassLoader()->add($prefix, static::addContaoRoot($paths));
    }

    /**
     * @param array $classMap Class to filename map
     */
    public static function addClassMap(array $classMap)
    {
        static::getClassLoader()->addClassMap(static::addContaoRoot($classMap));
    }

    /**
     * Add the Contao root folder to path(s)
     *
     * @param  string|array
     * @return string|array
     */
    private static function addContaoRoot($path)
    {
        if (is_array($path)) {
            return array_map(array(self, 'addContaoRoot'), $path);
        }

        return TL_ROOT . '/' . $path;
    }
}
