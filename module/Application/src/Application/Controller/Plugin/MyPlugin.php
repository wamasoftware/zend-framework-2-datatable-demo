<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyPlugin
 *
 * @author wamasoftware-11
 */

class MyPlugin extends AbstractPlugin {
    public function hello() {
        echo "<h1>Hello</h1>";
    }
}
