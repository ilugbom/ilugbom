<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfDefineEnvironmentConfigHandler.class.php 7811 2008-03-12 00:55:10Z fabien $
 */
class sfDefineEnvironmentConfigHandler extends sfYamlConfigHandler
{
  /**
   * Executes this configuration handler.
   *
   * @param  string An absolute filesystem path to a configuration file
   *
   * @return string Data to be written to a cache file
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable
   * @throws sfParseException If a requested configuration file is improperly formatted
   */
  public function execute($configFiles)
  {
    // get our prefix
    $prefix = strtolower($this->getParameterHolder()->get('prefix', ''));

    // add dynamic prefix if needed
    if ($this->getParameterHolder()->get('module', false))
    {
      $prefix .= "'.strtolower(\$moduleName).'_";
    }

    // parse the yaml
    $config = self::getConfiguration($configFiles);

    $values = array();
    foreach ($config as $category => $keys)
    {
      $values = array_merge($values, $this->getValues($prefix, $category, $keys));
    }

    $data = '';
    foreach ($values as $key => $value)
    {
      $data .= sprintf("  '%s' => %s,\n", $key, var_export($value, true));
    }

    // compile data
    $retval = '';
    if ($values)
    {
      $retval = "<?php\n".
                "// auto-generated by sfDefineEnvironmentConfigHandler\n".
                "// date: %s\nsfConfig::add(array(\n%s));\n";
      $retval = sprintf($retval, date('Y/m/d H:i:s'), $data);
    }

    return $retval;
  }

  /**
   * Gets values from the configuration array.
   *
   * @param string The prefix name
   * @param string The category name
   * @param mixed  The key/value array
   *
   * @param array The new key/value array
   */
  protected function getValues($prefix, $category, $keys)
  {
    if (!is_array($keys))
    {
      list($key, $value) = $this->fixCategoryValue($prefix.strtolower($category), '', $keys);

      return array($key => $value);
    }

    $values = array();

    $category = $this->fixCategoryName($category, $prefix);

    // loop through all key/value pairs
    foreach ($keys as $key => $value)
    {
      list($key, $value) = $this->fixCategoryValue($category, $key, $value);
      $values[$key] = $value;
    }

    return $values;
  }

  /**
   * Fixes the category name and replaces constants in the value.
   *
   * @param string The category name
   * @param string The key name
   * @param string The value
   *
   * @param string Return the new key and value
   */
  protected function fixCategoryValue($category, $key, $value)
  {
    return array($category.$key, $value);
  }

  /**
   * Fixes the category name.
   *
   * @param string The category name
   * @param string The prefix
   *
   * @return string The fixed category name
   */
  protected function fixCategoryName($category, $prefix)
  {
    // categories starting without a period will be prepended to the key
    if ($category[0] != '.')
    {
      $category = $prefix.$category.'_';
    }
    else
    {
      $category = $prefix;
    }

    return $category;
  }

  /**
   * @see sfConfigHandler
   */
  static public function getConfiguration(array $configFiles)
  {
    return self::replaceConstants(self::flattenConfigurationWithEnvironment(self::parseYamls($configFiles)));
  }
}
