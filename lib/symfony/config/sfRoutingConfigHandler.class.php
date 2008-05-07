<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfRoutingConfigHandler.class.php 7811 2008-03-12 00:55:10Z fabien $
 */
class sfRoutingConfigHandler extends sfYamlConfigHandler
{
  /**
   * Executes this configuration handler.
   *
   * @param array An array of absolute filesystem path to a configuration file
   *
   * @return string Data to be written to a cache file
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable
   * @throws sfParseException         If a requested configuration file is improperly formatted
   */
  public function execute($configFiles)
  {
    // parse the yaml
    $config = self::getConfiguration($configFiles);

    // connect routes
    $data = array();
    foreach ($config as $name => $params)
    {
      $data[] = sprintf('$this->connect(\'%s\', \'%s\', %s, %s);',
        $name,
        $params['url'] ? $params['url'] : '/',
        isset($params['param']) ? var_export($params['param'], true) : 'array()',
        isset($params['requirements']) ? var_export($params['requirements'], true) : 'array()'
      );
    }

    return sprintf("<?php\n".
                   "// auto-generated by sfRoutingConfigHandler\n".
                   "// date: %s\n%s\n", date('Y/m/d H:i:s'), implode("\n", $data)
    );
  }

  /**
   * @see sfConfigHandler
   */
  static public function getConfiguration(array $configFiles)
  {
    return self::parseYamls($configFiles);
  }
}
