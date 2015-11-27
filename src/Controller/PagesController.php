<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use App\Controller\AppController;
use App\Form\LandingPageForm;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Displays a view
 *
 * @return void
 * @throws Cake\Error\NotFoundException When the view file could not be found
 *    or Cake\Error\MissingViewException in debug mode.
 */
 
  public function beforeFilter(Event $event) {
      parent::beforeFilter($event);
      // Allow free access.
      $this->Auth->allow(['display']);
      $this->layout = 'frontend';
  }
    
	public function display() {
		$path = func_get_args();
		$url = implode('/',$path);
		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
			
			if(in_array($page,['challenges'])) // list has to use same form
			{
				$landingpage = new LandingPageForm();
				$submitted = false;
				if($this->request->is('post'))
				{
					if ($landingpage->execute($this->request->data)) {
						// store to db
						$this->loadModel('LandingPagesFormdata');
						$landingpageformdata = $this->LandingPagesFormdata;
						$data = $landingpageformdata->newEntity(['url'=>$url, 'serialized_data'=>serialize($this->request->data)]);
						$landingpageformdata->save($data);
						
						// show thank you
						$submitted = true;
					
					} else {					
						$this->Flash->error('There was a problem submitting your form. Please ensure you have included your name and a valid email address.');
					}
				}
				$this->set(compact('landingpage','submitted'));
			}
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout', 'url'));

		try {
			$this->render(implode('/', $path));
		} catch (Error\MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new Error\NotFoundException();
		}
	}
	
  public function isAuthorized($user) {

      // Default allow
      return true;
  }
  
  
  
	  
}
