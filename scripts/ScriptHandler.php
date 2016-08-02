<?php

/**
 * @file
 * Contains \UpMembership-Project\ScriptHandler.
 */

namespace CrowCG\UpMembership;

use Composer\Script\Event;
use Composer\Util\ProcessExecutor;

class ScriptHandler {
  /**
   * Moves front-end libraries to upmembership's installed directory.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function deployLibraries(Event $event) {
    $extra = $event->getComposer()->getPackage()->getExtra();
    if (isset($extra['installer-paths'])) {
      foreach ($extra['installer-paths'] as $path => $criteria) {
        if (array_intersect(['crowdcg/upmembership', 'type:drupal-profile'], $criteria)) {
          $upmembership = $path;
        }
      }
      if (isset($upmembership)) {
        $upmembership = str_replace('{$name}', 'upmembership', $upmembership);
        $executor = new ProcessExecutor($event->getIO());
        $output = NULL;
        $executor->execute('npm run install-libraries', $output, $upmembership);
      }
    }
  }
}